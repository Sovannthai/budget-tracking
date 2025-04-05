<?php

namespace App\Http\Controllers\Backends;

use App\Models\Income;
use App\Models\Customer;
use App\Models\IncomeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Cache\Store;
use App\Actions\Income\StoreIncomeAction;
use App\Actions\Income\UpdateIncomeAction;

class IncomeController extends Controller
{
    /**
     * Return all incomes
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incomes     = Income::latest()->paginate($this->limit());
        $customers   = Customer::where('status', 1)->latest()->paginate($this->limit());
        $incomeTypes = IncomeType::latest()->paginate($this->limit());
        return view('backend.income.index', compact('incomes', 'customers', 'incomeTypes'));
    }

    /**
     * Return form to create new income
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers   = Customer::where('status', 1)->latest()->paginate($this->limit());
        $incomeTypes = IncomeType::latest()->paginate($this->limit());
        return view('backend.income.create', compact('customers', 'incomeTypes'));
    }

    /**
     * Store new income
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();

            $income = StoreIncomeAction::run($request);

            DB::commit();
            $output = [
                'success' => 1,
                'msg'     => __('Income :name Created Successfully', ['name' => $income->amount]),
            ];
        }catch (\Exception $e){
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg'     => __('Cannot create income :name', ['name' => $e->getMessage()]),
            ];
        }
        return redirect()->route('incomes.index')->with($output);
    }

    /**
     * Return form to edit income
     * @param \App\Models\Income $income
     * @return \Illuminate\Http\Response
     */
    public function edit(Income $income)
    {
        $customers   = Customer::where('status', 1)->latest()->paginate($this->limit());
        $incomeTypes = IncomeType::latest()->paginate($this->limit());
        return view('backend.income.edit', compact('income', 'customers', 'incomeTypes'));
    }

    /**
     * Update income
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Income $income
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Income $income)
    {
        try{
            DB::beginTransaction();

            $income = UpdateIncomeAction::run($request, $income);

            DB::commit();
            $output = [
                'success' => 1,
                'msg'     => __('Income :name Updated Successfully', ['name' => $income->amount]),
            ];
        }catch (\Exception $e){
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg'     => __('Cannot update income :name', ['name' => $e->getMessage()]),
            ];
        }
        return redirect()->route('incomes.index')->with($output);
    }

    /**
     * Delete income
     * @param \App\Models\Income $income
     * @return \Illuminate\Http\Response
     */
    public function destroy(Income $income)
    {
        try{
            DB::beginTransaction();

            $income->delete();

            DB::commit();
            $output = [
                'success' => 1,
                'msg'     => __('Income :name Deleted Successfully', ['name' => $income->amount]),
            ];
        }catch (\Exception $e){
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg'     => __('Cannot delete income :name', ['name' => $e->getMessage()]),
            ];
        }
        return redirect()->route('incomes.index')->with($output);
    }
}
