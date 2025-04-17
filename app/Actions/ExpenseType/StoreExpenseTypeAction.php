<?php

namespace App\Actions\ExpenseType;

use App\Models\ExpenseType;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Events\ExpenseType\ExpenseTypeCreated;

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
        
        // Fire the event and log it for debugging
        // Log::info('Dispatching ExpenseTypeCreated event', ['id' => $expenseType->id, 'name' => $expenseType->name]);
        // event(new ExpenseTypeCreated($expenseType));
        
        return $expenseType;
    }
}
