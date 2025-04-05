<?php

namespace App\Actions\IncomeType;

use Lorisleiva\Actions\Concerns\AsAction;

class UpdateIncomeTypeAction
{
    use AsAction;
    /**
     * Handle the action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IncomeType  $incomeType
     * @return void
     */
    public function handle($request, $incomeType)
    {
        $incomeType->customer_id = $request->customer_id;
        $incomeType->name        = $request->name;
        $incomeType->icon        = $request->icon;
        $incomeType->description = $request->description;
        $incomeType->save();
        return $incomeType;
    }
}
