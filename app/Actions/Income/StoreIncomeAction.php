<?php

namespace App\Actions\Income;

use App\Models\Income;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreIncomeAction
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
        $income                 = new Income();
        $income->customer_id    = $request->customer_id;
        $income->income_type_id = $request->income_type_id;
        $income->amount         = $request->amount;
        $income->date           = $request->date;
        $income->description    = $request->description;
        
        $income->save();
        return $income;
    }
}
