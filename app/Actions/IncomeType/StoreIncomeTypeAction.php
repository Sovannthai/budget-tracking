<?php

namespace App\Actions\IncomeType;

use App\Models\IncomeType;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreIncomeTypeAction
{
    use AsAction;
    /**
     * Handle the action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handle($request)
    {
        $incomeType              = new IncomeType();
        $incomeType->customer_id = $request->customer_id;
        $incomeType->name        = $request->name;
        $incomeType->icon        = $request->icon;
        $incomeType->description = $request->description;
        $incomeType->save();
        return $incomeType;
    }
}
