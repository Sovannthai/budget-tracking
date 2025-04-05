<?php

namespace App\Actions\ExpenseType;

use Lorisleiva\Actions\Concerns\AsAction;

class UpdateExpenseTypeAction
{
    use AsAction;
    /**
     * Handle the action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpenseType  $expenseType
     * @return void
     */
    public function handle($request, $expenseType)
    {
        $expenseType->customer_id = $request->customer_id;
        $expenseType->name        = $request->name;
        $expenseType->icon        = $request->icon;
        $expenseType->description = $request->description;

        $expenseType->save();
        return $expenseType;
    }
}
