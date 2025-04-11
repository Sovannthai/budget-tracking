<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Customer;
use App\Models\IncomeType;
use App\Models\ExpenseType;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\EmailVerificationOtp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\IncomeResource;
use Illuminate\Validation\Rules\Email;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\CustomerResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\IncomeTypeResource;
use App\Http\Resources\ExpenseTypeResource;

class AppApiController extends Controller
{
    public $otpService;
    /*
    * Upload image
    *
    * @param  \Illuminate\Http\UploadedFile  $image
    * @return string
    */
    public function uploadImage($image)
    {
        $extension = $image->getClientOriginalExtension();
        $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $extension;
        $image->move(public_path('uploads/all_photo/'), $imageName);
        return $imageName;
    }

    /*
    * Constructor
    * @param OtpService $otpService
    * @return void
    */
    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }
    
    /*
    * Send OTP to email
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'email'      => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $customer = Customer::where('id', $request->customer_id)->where('email',$request->email)->first();
        
        if(!$customer){
            return response()->json([
                'success' => false,
                'message' => 'Customer not found'
            ], 404);
        }
        
        if ($customer->email != $request->email) {
            return response()->json([
                'success' => false,
                'message' => 'Email does not match'
            ], 422);
        }
        
        $otp = $this->otpService->generateOtp($customer);
        
        return response()->json([
            'message' => 'Verification code sent to your email',
            'otp' => $otp
        ], 200);
    }
    
    /*
    * Verify OTP
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'otp' => 'required|string|min:6|max:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        
        $customer    = Customer::where('id',$request->customer_id)->first();
        $otp         = $request->otp;
        $expired_otp = EmailVerificationOtp::where('customer_id', $customer->id)
            ->where('otp', $otp)
            ->where('expires_at', '<', Carbon::now())
            ->first();

        if ($this->otpService->validateOtp($customer, $otp)) {
            return response()->json([
                'otp' => $otp,
                'message' => 'Email verified successfully'
            ], 200);
        }

        if($expired_otp){
            return response()->json([
                'success' => false,
                'message' => 'OTP expired'
            ], 422);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Invalid verification code'
        ], 422);
    }

    /* 
    * Set new password after email verification
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function setNewPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'      => 'required',
            'password'         => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        
        $customer = Customer::where('id',$request->customer_id)->first();
        if(!$customer){
            return response()->json([
                'message' => 'Customer not found',
            ], 404);
        }
        
        $customer->password = Hash::make($request->password);
        $customer->email_verified_at = Carbon::now();
        $customer->save();
        
        return response()->json([
            'message' => 'Password updated successfully',
            'password'=> $request->password,
        ], 200);
    }
    
    /*
    * register customer
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|unique:customers',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $customer           = new Customer();
        $customer->email    = $request->email;
        $customer->password = Hash::make($request->password);
        $customer->save();
        $token              = $customer->createToken('customer-token')->plainTextToken;

        return response()->json([
            'message'  => 'Register successful',
            'token'    => $token,
            'customer' => $customer,
        ], 200);
    }

    /*
    * Login customer
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $customer = Customer::where('email', $request->email)->first();
        if ($customer) {
            $customerResource = new CustomerResource($customer);
        }
        if ($customer && Hash::check($request->password, $customer->password)) {
            $token = $customer->createToken('customer-token')->plainTextToken;

            return response()->json([
                'message'  => 'Login successful',
                'token'    => $token,
                'customer' => $customerResource,
            ], 200);
        }
        return response()->json([
            'message' => 'Invalid email or password',
        ], 401);
    }

    /*
    * Update customer
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function updateCustomerInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_id' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $customer = Customer::where('contact_id', $request->contact_id)->first();
        if(!$customer){
            return response()->json([
                'message' => 'Customer not found',
            ], 404);
        }
        $customer             = Customer::find($customer->id);
        $old_photo_path       = $customer->image;
        $customer->first_name = $request->first_name;
        $customer->last_name  = $request->last_name;
        $customer->dob        = $request->dob;
        $customer->email      = $request->email;
        $customer->phone      = $request->phone;
        $customer->address    = $request->address;
        $customer->gender     = $request->gender;

        if ($request->hasFile('image')) {
            $customer->image = $this->uploadImage($request->file('image'));
            if ($old_photo_path && File::exists(public_path('uploads/all_photo/' . $old_photo_path))) {
                File::delete(public_path('uploads/all_photo/' . $old_photo_path));
            }
        }
        
        $customer->save();
        if ($customer) {
            $customerResource = new CustomerResource($customer);
        }
        return response()->json([
            'message'  => 'Customer updated successfully',
            'customer' => $customerResource,
        ], 200);
    }

    /*
    * Update Password by customer_id
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_id'     => 'required',
            'old_password'   => 'required',
            'new_password'   => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        
        $customer = Customer::where('contact_id', $request->contact_id)->first();
        if(!$customer){
            return response()->json([
                'message' => 'Customer not found',
            ], 404);
        }
        
        if(!Hash::check($request->old_password, $customer->password)) {
            return response()->json([
                'message' => 'Old password is incorrect',
            ], 422);
        }
        
        $customer->password = Hash::make($request->new_password);
        $customer->save();
        
        return response()->json([
            'message' => 'Password updated successfully',
            'password'=> $request->new_password,
        ], 200);
    }
    
    /*
    * Get customer info
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function getCustomerById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $customer = Customer::where('contact_id', $request->contact_id)->first();
        if(!$customer){
            return response()->json([
                'message' => 'Customer not found',
            ], 404);
        }
        $customerResource = new CustomerResource($customer);
        return response()->json([
            'message'  => 'Customer found',
            'customer' => $customerResource,
        ], 200);
    }

    /*
    * Get income types by customer
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function getIncomeTypeByCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $incomeTypes = IncomeType::where('customer_id',$request->customer_id)->latest()->paginate($this->limit());
        if(!$incomeTypes){
            return response()->json([
                'message' => 'Income Types not found',
            ], 404);
        }
        $incomeTypeResources = IncomeTypeResource::collection($incomeTypes);

        return response()->json($incomeTypeResources, 200);
    }

    /* 
    * Create income type
    * @param Request $request   
    * @return \Illuminate\Http\JsonResponse
    */
    public function createIncomeType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'name'        => 'required',
            'icon'        => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        try{
            DB::beginTransaction();

            $incomeType              = new IncomeType();
            $incomeType->customer_id = $request->customer_id;
            $incomeType->name        = $request->name;
            $incomeType->icon        = $request->icon;
            $incomeType->description = $request->description;
    
            $incomeType->save();
            DB::commit();
            $incomeTypeResource = new IncomeTypeResource($incomeType);

            return response()->json([
                'message'     => 'Income Type created successfully',
                'income_type' => $incomeTypeResource,
            ], 200);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /*
    * Update income type
    * @param Request $request   
    * @return \Illuminate\Http\JsonResponse
    */
    public function updateIncomeType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'    => 'required',
            'income_type_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        try{
            DB::beginTransaction();

            $incomeType = IncomeType::where('customer_id',$request->customer_id)->where('id',$request->income_type_id)->first();
            if(!$incomeType){
                return response()->json([
                    'message' => 'Income Type not found',
                ], 404);
            }
            $incomeType->name        = $request->name;
            $incomeType->icon        = $request->icon;
            $incomeType->description = $request->description;
    
            $incomeType->save();
            DB::commit();
            $incomeTypeResource = new IncomeTypeResource($incomeType);

            return response()->json([
                'message'     => 'Income Type updated successfully',
                'income_type' => $incomeTypeResource,
            ], 200);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete income type
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteIncomeType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'    => 'required',
            'income_type_id' => 'required|exists:income_types,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        
        try {
            DB::beginTransaction();

            $incomeType = IncomeType::where('customer_id', $request->customer_id)
                            ->where('id', $request->income_type_id)
                            ->first();
            
            if (!$incomeType) {
                return response()->json([
                    'message' => 'Income Type not found'
                ], 404);
            }

            if (Income::where('income_type_id', $request->income_type_id)->exists()) {
                return response()->json([
                    'message' => 'Cannot delete: Income Type is currently in use'
                ], 422);
            }

            $incomeType->delete();
            DB::commit();

            return response()->json([
                'message' => 'Income Type deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /* 
    * Get Income
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function getIncomeByCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $incomes          = Income::where('customer_id',$request->customer_id)->latest()->paginate($this->limit());
        $incomesResources = IncomeResource::collection($incomes);
        if(!$incomes){
            return response()->json([
                'message' => 'Incomes not found',
            ], 404);
        }
        return response()->json($incomesResources, 200);
    }

    /*
    * Create Income
    * @param Request $request   
    * @return \Illuminate\Http\JsonResponse
    */
    public function createIncome(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'   => 'required',
            'income_type_id'=> 'required',
            'amount'        => 'required',
            'date'          => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        try{
            DB::beginTransaction();

            $income                 = new Income();
            $income->customer_id    = $request->customer_id;
            $income->income_type_id = $request->income_type_id;
            $income->amount         = $request->amount;
            $income->date           = $request->date;
            $income->description    = $request->description;
    
            $income->save();
            DB::commit();
            $incomeResource = new IncomeResource($income);

            return response()->json([
                'message' => 'Income created successfully',
                'income'  => $incomeResource,
            ], 200);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /*
    * Update Income
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function updateIncome(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'   => 'required',
            'income_id'     => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        try{
            DB::beginTransaction();

            $income = Income::where('customer_id',$request->customer_id)->where('id',$request->income_id)->first();
            if(!$income){
                return response()->json([
                    'message' => 'Income not found',
                ], 404);
            }
            $income->customer_id    = $request->customer_id;
            $income->income_type_id = $request->income_type_id;
            $income->amount         = $request->amount;
            $income->date           = $request->date;
            $income->description    = $request->description;
    
            $income->save();
            DB::commit();
            $incomeResource = new IncomeResource($income);

            return response()->json([
                'message' => 'Income updated successfully',
                'income'  => $incomeResource,
            ], 200);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete income
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteIncome(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'income_id'   => 'required|exists:incomes,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        
        try {
            DB::beginTransaction();
            $income = Income::where('customer_id', $request->customer_id)
                            ->where('id', $request->income_id)
                            ->first();
            if (!$income) {
                return response()->json([
                    'message' => 'Income not found'
                ], 404);
            }
            $income->delete();
            DB::commit();

            return response()->json([
                'message' => 'Income deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /*
    * Get ExpensesTypes by customer
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function getExpenseTypeByCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $expenseTypes = ExpenseType::where('customer_id',$request->customer_id)->latest()->paginate($this->limit());
        if(!$expenseTypes){
            return response()->json([
                'message' => 'Expense Types not found',
            ], 404);
        }
        $expenseTypeResources = ExpenseTypeResource::collection($expenseTypes);

        return response()->json($expenseTypeResources, 200);
    }

    /*
    * Create Expense type
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function createExpenseType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'name'        => 'required',
            'icon'        => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        try{
            DB::beginTransaction();

            $expenseType              = new ExpenseType();
            $expenseType->customer_id = $request->customer_id;
            $expenseType->name        = $request->name;
            $expenseType->icon        = $request->icon;
            $expenseType->description = $request->description;
    
            $expenseType->save();
            DB::commit();
            $expenseTypeResource = new ExpenseTypeResource($expenseType);

            return response()->json([
                'message'      => 'Expense Type created successfully',
                'expense_type' => $expenseTypeResource,
            ], 200);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /*
    * Update Expense type
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function updateExpenseType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'    => 'required',
            'expense_type_id'=> 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        try{
            DB::beginTransaction();

            $expenseType = ExpenseType::where('customer_id',$request->customer_id)->where('id',$request->expense_type_id)->first();
            if(!$expenseType){
                return response()->json([
                    'message' => 'Expense Type not found',
                ], 404);
            }
            $expenseType->name        = $request->name;
            $expenseType->icon        = $request->icon;
            $expenseType->description = $request->description;
    
            $expenseType->save();
            DB::commit();
            $expenseTypeResource = new ExpenseTypeResource($expenseType);

            return response()->json([
                'message'      => 'Expense Type updated successfully',
                'expense_type' => $expenseTypeResource,
            ], 200);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete expense type
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteExpenseType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'    => 'required',
            'expense_type_id'=> 'required|exists:expense_types,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        
        try {
            DB::beginTransaction();

            $expenseType = ExpenseType::where('customer_id', $request->customer_id)
                            ->where('id', $request->expense_type_id)
                            ->first();
            
            if (!$expenseType) {
                return response()->json([
                    'message' => 'Expense Type not found'
                ], 404);
            }

            if (Income::where('income_type_id', $request->expense_type_id)->exists()) {
                return response()->json([
                    'message' => 'Cannot delete: Expense Type is currently in use'
                ], 422);
            }

            $expenseType->delete();
            DB::commit();

            return response()->json([
                'message' => 'Expense Type deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /*
    * Get Expenses by customer
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function getExpenseByCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $expenses          = ExpenseType::where('customer_id',$request->customer_id)->latest()->paginate($this->limit());
        $expensesResources = ExpenseTypeResource::collection($expenses);
        if(!$expenses){
            return response()->json([
                'message' => 'Expenses not found',
            ], 404);
        }
        return response()->json($expensesResources, 200);
    }

    /*
    * Create Expense
    * @param Request $request  
    * @return \Illuminate\Http\JsonResponse
    */
    public function createExpense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'   => 'required',
            'expense_type_id'=> 'required',
            'amount'        => 'required',
            'date'          => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        try{
            DB::beginTransaction();

            $expense                 = new Expense();
            $expense->customer_id    = $request->customer_id;
            $expense->expense_type_id= $request->expense_type_id;
            $expense->amount         = $request->amount;
            $expense->date           = $request->date;
            $expense->description    = $request->description;
    
            $expense->save();
            DB::commit();
            $expenseResource = new ExpenseResource($expense);

            return response()->json([
                'message'  => 'Expense created successfully',
                'expense'  => $expenseResource,
            ], 200);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /*
    * Update Expense
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function updateExpense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'   => 'required',
            'expense_id'    => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        try{
            DB::beginTransaction();

            $expense = Expense::where('customer_id',$request->customer_id)->where('id',$request->expense_id)->first();
            if(!$expense){
                return response()->json([
                    'message' => 'Expense not found',
                ], 404);
            }
            $expense->customer_id    = $request->customer_id;
            $expense->expense_type_id= $request->expense_type_id;
            $expense->amount         = $request->amount;
            $expense->date           = $request->date;
            $expense->description    = $request->description;
    
            $expense->save();
            DB::commit();
            $expenseResource = new ExpenseResource($expense);

            return response()->json([
                'message'  => 'Expense updated successfully',
                'expense'  => $expenseResource,
            ], 200);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete expense
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteExpense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'expense_id'  => 'required|exists:expenses,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        
        try {
            DB::beginTransaction();
            $expense = Expense::where('customer_id', $request->customer_id)
                            ->where('id', $request->expense_id)
                            ->first();
            if (!$expense) {
                return response()->json([
                    'message' => 'Expense not found'
                ], 404);
            }
            $expense->delete();
            DB::commit();

            return response()->json([
                'message' => 'Expense deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
