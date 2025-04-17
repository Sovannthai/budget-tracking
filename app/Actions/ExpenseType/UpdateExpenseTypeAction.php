<?php

namespace App\Actions\ExpenseType;

use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Events\ExpenseType\ExpenseTypeUpdated;

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
        
        // Fire the event and log it for debugging
        // Log::info('Dispatching ExpenseTypeUpdated event', ['id' => $expenseType->id, 'name' => $expenseType->name]);
        // event(new ExpenseTypeUpdated($expenseType));
        
        return $expenseType;
    }
}
