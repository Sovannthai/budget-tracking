<?php

namespace App\Actions\ExpenseType;

use App\Models\ExpenseType;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreExpenseTypeAction
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
        $expenseType              = new ExpenseType();
        $expenseType->customer_id = $request->customer_id;
        $expenseType->name        = $request->name;
        $expenseType->icon        = $request->icon;
        $expenseType->description = $request->description;

        $expenseType->save();
        return $expenseType;
    }
}
