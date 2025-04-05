<?php

namespace App\Actions\Expense;

use Lorisleiva\Actions\Concerns\AsAction;

class UpdateExpenseAction
{
    use AsAction;

    public function handle($request , $expense)
    {
        $expense->customer_id     = $request->customer_id;
        $expense->expense_type_id = $request->expense_type_id;
        $expense->amount          = $request->amount;
        $expense->date            = $request->date;
        $expense->description     = $request->description;

        $expense->save();
        return $expense;
    }
}
