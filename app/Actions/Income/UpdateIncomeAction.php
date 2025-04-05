<?php

namespace App\Actions\Income;

use Lorisleiva\Actions\Concerns\AsAction;

class UpdateIncomeAction
{
    use AsAction;
    /**
     * Handle the action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Income  $income
     * @return void
     */
    public function handle($request, $income)
    {
        $income->customer_id    = $request->customer_id;
        $income->income_type_id = $request->income_type_id;
        $income->amount         = $request->amount;
        $income->date           = $request->date;
        $income->description    = $request->description;

        $income->save();
        return $income;
    }
}
