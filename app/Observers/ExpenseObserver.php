<?php

namespace App\Observers;

use App\Models\Budget;
use App\Models\Expense;

class ExpenseObserver
{
    /**
     * Handle the Expense "created" event.
     *  
     * @param Expense $expense
     * @return void
     */
    public function created(Expense $expense): void
    {
        $this->updateBudget($expense);
    }

    /**
     * Handle the Expense "updated" event.
     * 
     * @param Expense $expense
     * @return void
     */
    public function updated(Expense $expense): void
    {
        $originalAmount = $expense->getOriginal('amount') ?? 0;
        
        $amountDifference = $expense->amount - $originalAmount;
        
        if ($amountDifference != 0) {
            $budget = Budget::where('customer_id', $expense->customer_id)->first();
            
            if ($budget) {
                $budget->balance -= $amountDifference;
                $budget->save();
            }
        }
    }

    /**
     * Handle the Expense "deleted" event.
     * 
     * @param Expense $expense
     * @return void
     */
    public function deleted(Expense $expense): void
    {
        $budget = Budget::where('customer_id', $expense->customer_id)->first();
        
        if ($budget) {
            $budget->balance += $expense->amount;
            $budget->save();
        }
    }
    /**
    * Update budget when expense is created
    *
    * @param Expense $expense
    * @return void
    */
   private function updateBudget(Expense $expense): void
   {
       $budget = Budget::where('customer_id', $expense->customer_id)->first();
       
       if ($budget) {
           $budget->balance -= $expense->amount;
           $budget->save();
       } else {
           // Create a budget if it doesn't exist with negative balance
           Budget::create([
               'customer_id' => $expense->customer_id,
               'amount' => 0,
               'balance' => -$expense->amount
           ]);
       }
   }

    /**
     * Handle the Expense "restored" event.
     */
    public function restored(Expense $expense): void
    {
        //
    }

    /**
     * Handle the Expense "force deleted" event.
     */
    public function forceDeleted(Expense $expense): void
    {
        //
    }
}
