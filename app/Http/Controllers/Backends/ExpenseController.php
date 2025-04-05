<?php

namespace App\Http\Controllers\Backends;

use App\Actions\Expense\StoreExpenseAction;
use App\Actions\Expense\UpdateExpenseAction;
use App\Models\Expense;
use App\Models\Customer;
use App\Models\ExpenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ExpenseController extends Controller
{
    /**
     * Return all the expense
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::latest()->paginate($this->limit());
        $customers = Customer::where('status', 1)->latest()->paginate($this->limit());
        return view('backend.expenses.index', compact('expenses', 'customers'));
    }

    /**
     * Return form create new expense
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::where('status', 1)->latest()->paginate($this->limit());
        $expenseTypes = ExpenseType::latest()->paginate($this->limit());
        return view('backend.expenses.create', compact('customers', 'expenseTypes'));
    }

    /**
     * Store new expense
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();

            $expense = StoreExpenseAction::run($request);

            DB::commit();
            $output = [
                'success' => 1,
                'msg'     => __('Expense :name Created Successfully', ['name' => $expense->amount]),
            ];
        }catch (\Exception $e){
            DB::rollback();
            $output = [
                'success' => 0,
                'msg'     => __('Cannot create expense :error', ['error' => $e->getMessage()]),
            ];
        }
        return redirect()->route('expenses.index')->with($output);
    }

    /**
     * Return form edit expense
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        $customers = Customer::where('status', 1)->latest()->paginate($this->limit());
        $expenseTypes = ExpenseType::latest()->paginate($this->limit());
        return view('backend.expenses.edit', compact('expense', 'customers', 'expenseTypes'));
    }

    /**
     * Update expense
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        try{
            DB::beginTransaction();

            $expense = UpdateExpenseAction::run($request, $expense);

            DB::commit();
            $output = [
                'success' => 1,
                'msg'     => __('Expense :name Updated Successfully', ['name' => $expense->amount]),
            ];
        }catch (\Exception $e){
            DB::rollback();
            $output = [
                'success' => 0,
                'msg'     => __('Cannot update expense :error', ['error' => $e->getMessage()]),
            ];
        }
        return redirect()->route('expenses.index')->with($output);
    }

    /**
     * Delete expense
     * @param \App\Models\Expense $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        try{
            DB::beginTransaction();

            $expense->delete();

            DB::commit();
            $output = [
                'success' => 1,
                'msg'     => __('Expense :name Deleted Successfully', ['name' => $expense->amount]),
            ];
        }catch (\Exception $e){
            DB::rollback();
            $output = [
                'success' => 0,
                'msg'     => __('Cannot delete expense :error', ['error' => $e->getMessage()]),
            ];
        }
        return redirect()->route('expenses.index')->with($output);
    }
}
