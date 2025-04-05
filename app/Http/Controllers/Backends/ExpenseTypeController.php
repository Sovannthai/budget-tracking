<?php

namespace App\Http\Controllers\Backends;

use App\Actions\ExpenseType\StoreExpenseTypeAction;
use App\Actions\ExpenseType\UpdateExpenseTypeAction;
use App\Models\Customer;
use App\Models\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Cache\Store;

class ExpenseTypeController extends Controller
{
    /**
     * Return expense type list.
     */
    public function index()
    {
        $expenseTypes = ExpenseType::latest()->paginate($this->limit());
        $customers    = Customer::where('status', 1)->latest()->paginate($this->limit());
        return view('backend.expenseType.index', compact('expenseTypes', 'customers'));
    }
    /**
     * Store new expense type.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{    
            DB::beginTransaction();

            $expenseType = StoreExpenseTypeAction::run($request);

            DB::commit();
            $output = [
                'success' => 1,
                'msg'     => __('Expense Type :name Created Successfully', ['name' => $expenseType->name]),
            ];
        }catch(\Exception $e){
            $output = [
                'success' => 0,
                'msg'     => __('Something went wrong'),
            ];
        }
        return redirect()->route('expense-types.index')->with($output);
    }
    /**
     * Update expense type.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpenseType  $expenseType
     */
    public function update(Request $request, ExpenseType $expenseType)
    {
        try{
            DB::beginTransaction();

            $expenseType = UpdateExpenseTypeAction::run($request, $expenseType);

            DB::commit();
            $output = [
                'success' => 1,
                'msg'     => __('Expense Type :name Updated Successfully', ['name' => $expenseType->name]),
            ];
        }catch(\Exception $e){
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg'     => __('Cannot update expense type :name', ['name' => $e->getMessage()]),
            ];
        }
        return redirect()->route('expense-types.index')->with($output);
    }

    /**
     * Delete expense type.
     */
    public function destroy(ExpenseType $expenseType)
    {
        try{
            DB::beginTransaction();

            $expenseType->delete();

            DB::commit();
            $output = [
                'success' => 1,
                'msg'     => __('Expense Type :name Deleted Successfully', ['name' => $expenseType->name]),
            ];
        }catch(\Exception $e){
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg'     => __('Cannot delete expense type :name', ['name' => $e->getMessage()]),
            ];
        }
        return redirect()->route('expense-types.index')->with($output);
    }
}
