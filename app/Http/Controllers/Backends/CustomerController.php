<?php

namespace App\Http\Controllers\Backends;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Actions\Customer\StoreCustomerAction;
use App\Actions\Customer\UpdateCustomerAction;

class CustomerController extends Controller
{
    /**
     * Return all customers
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $customers = Customer::latest()->paginate($this->limit());
        return view('backend.customers.index',compact('customers'));
    }

    /**
     * Return the form create new customer
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('backend.customers.create');
    }

    /**
     * Store new customer
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();

            $customers = StoreCustomerAction::run($request);

            DB::commit();
            $output = [
                'success' => 1,
                'msg' => __('Customer :name created successfully.', ['name' => $customers->first_name.' '.$customers->last_name])
            ];
        }catch (\Exception $e){
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong'),
            ];
        }
        return redirect()->route('customers.index')->with($output);
    }

    /**
     * Return the form edit customer
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Customer $customer)
    {
        return view('backend.customers.edit', compact('customer'));
    }

    /*
    * Return the form show customer
    * @param \App\Models\Customer $customer
    * @return \Illuminate\Contracts\View\View
    */
    public function show(Customer $customer)
    {
        $totalIcome   = $customer->incomes()->sum('amount');
        $totalExpense = $customer->expenses()->sum('amount');
        $totalBudget  = $customer->budgets()->sum('balance');
        return view('backend.customers.show', compact('customer', 'totalIcome', 'totalExpense', 'totalBudget'));
    }

    /**
     * Update the customer data
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(Request $request, Customer $customer)
    {
        try{
            DB::beginTransaction();

            $customers = UpdateCustomerAction::run($request, $customer);

            DB::commit();
            $output = [
                'success' => 1,
                'msg' => __('Customer :name updated successfully.', ['name' => $customers->first_name.' '.$customers->last_name])
            ];
        }catch (\Exception $e){
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong'),
            ];
        }
        return redirect()->route('customers.index')->with($output);
    }

    /**
     * Delete the customer
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Customer $customer)
    {
        try{
            DB::beginTransaction();

            $old_photo_path = $customer->image;

            if ($old_photo_path && File::exists(public_path('uploads/all_photo/' . $old_photo_path))) {
                File::delete(public_path('uploads/all_photo/' . $old_photo_path));
            }
            $customer->delete();

            DB::commit();
            $output = [
                'success' => 1,
                'msg' => __('Customer :name deleted successfully.', ['name' => $customer->first_name.' '.$customer->last_name])
            ];
        }catch (\Exception $e){
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong'),
            ];
        }
        return redirect()->route('customers.index')->with($output);
    }
    /*
    * Update customer status
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function updateStatus (Request $request)
    {
        try {
            DB::beginTransaction();

            $query = Customer::where('id', $request->id)->first();

            $query->status = !$query->status;
            $query->save();

            DB::commit();

            return response()->json(['success' => true, 'msg' => 'Status updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'msg' => 'Something went wrong'], 500);
        }
    }
}
