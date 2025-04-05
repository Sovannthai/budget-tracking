<?php

namespace App\Actions\Expense;

use App\Models\Expense;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreExpenseAction
{
    use AsAction;

    public function handle($request)
    {
        $expense                  = new Expense();
        $expense->customer_id     = $request->customer_id;
        $expense->expense_type_id = $request->expense_type_id;
        $expense->amount          = $request->amount;
        $expense->date            = $request->date;
        $expense->description     = $request->description;

        $expense->save();
        return $expense;
    }
}
