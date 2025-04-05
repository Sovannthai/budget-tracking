<?php

namespace App\Http\Controllers\Backends;

use App\Models\Customer;
use App\Models\IncomeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Actions\IncomeType\StoreIncomeTypeAction;
use App\Actions\IncomeType\UpdateIncomeTypeAction;

class IncomeTypeController extends Controller
{
    /**
     * Return all income types.
     */
    public function index()
    {
        $incomeTypes = IncomeType::latest()->paginate($this->limit());
        $customers   = Customer::where('status', 1)->latest()->paginate($this->limit());
        return view('backend.incomeType.index',compact('incomeTypes', 'customers'));
    }
    /**
     * Store new income type.
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    * @throws \Illuminate\Database\QueryException
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'customer_id' => 'required',
                'name'        => 'required|unique:income_types,name',
            ]);
            DB::beginTransaction();

            $incomeTypes = StoreIncomeTypeAction::run($request);
            
            DB::commit();
            $output = [
                'success' => 1,
                'msg'     => __('Income Type :name Created Successfully', ['name' => $incomeTypes->name]),
            ];
        }catch(\Exception $e){
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong'),

            ];
        }
        return redirect()->route('income-types.index')->with($output);
    }
    /**
     * Update income type.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IncomeType  $incomeType
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     * @throws \Throwable
     */
    public function update(Request $request, IncomeType $incomeType)
    {
        try{
            $request->validate([
                'customer_id' => 'required',
                'name'        => 'required|unique:income_types,name,'.$incomeType->id,
            ]);
            DB::beginTransaction();

            $incomeType = UpdateIncomeTypeAction::run($request, $incomeType);

            DB::commit();
            $output = [
                'success' => 1,
                'msg'     => __('Income Type :name Updated Successfully', ['name' => $incomeType->name]),
            ];
        }catch(\Exception $e){
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg' => __('Something went wrong'),
            ];
        }
        return redirect()->route('income-types.index')->with($output);
    }

    /**
     * Delete income type.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IncomeType  $incomeType
     * @throws \Exception
     */
    public function destroy(Request $request, IncomeType $incomeType)
    {
        try{
            DB::beginTransaction();
            $incomeType->delete();
            DB::commit();
            $output = [
                'success' => 1,
                'msg'     => __('Income Type :name Deleted Successfully', ['name' => $incomeType->name]),
            ];
        }catch(\Exception $e){
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg'     => __('Something went wrong'),
            ];
        }
        return redirect()->route('income-types.index')->with($output);
    }
}
