<?php

namespace App\Observers;

use App\Models\Budget;
use App\Models\Income;

class IncomeObserver
{
    /**
     * Handle the Income "created" event.
     * @param  \App\Models\Income  $income
     * @return void
     */
    public function created(Income $income): void
    {
        $this->updateBudget($income);
    }

    /**
     * Handle the Income "updated" event.
     * @param  \App\Models\Income  $income
     * @return void
     */
    public function updated(Income $income): void
    {
         $originalAmount   = $income->getOriginal('amount') ?? 0;
         $amountDifference = $income->amount - $originalAmount;
         
         if ($amountDifference != 0) {
             $budget = Budget::where('customer_id', $income->customer_id)->first();
             
             if ($budget) {
                 $budget->balance += $amountDifference;
                 $budget->save();
             }
         }
    }

    /**
     * Handle the Income "deleted" event.
     * @param  \App\Models\Income  $income
     * @return void
     */
    public function deleted(Income $income): void
    {
        $budget = Budget::where('customer_id', $income->customer_id)->first();
        
        if ($budget) {
            $budget->balance -= $income->amount;
            $budget->save();
        }
    }

    /**
     * Update budget when income is created
     * @param  \App\Models\Income  $income
     * @return void
     */
    private function updateBudget(Income $income): void
    {
        $budget = Budget::where('customer_id', $income->customer_id)->first();
        
        if ($budget) {
            $budget->balance += $income->amount;
            $budget->save();
        } else {
            Budget::create([
                'customer_id' => $income->customer_id,
                'amount'      => $income->amount,
                'balance'     => $income->amount
            ]);
        }
    }

    /**
     * Handle the Income "restored" event.
     * @param  \App\Models\Income  $income
     * @return void
     */
    public function restored(Income $income): void
    {
        //
    }

    /**
     * Handle the Income "force deleted" event.
     * @param  \App\Models\Income  $income
     * @return void
     */
    public function forceDeleted(Income $income): void
    {
        //
    }
}
