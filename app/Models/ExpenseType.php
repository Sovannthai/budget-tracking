<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    protected $guarded = [];
    
    /**
     * Relationship with the Expense model
     * This indicates that an expense type can have multiple expenses.
     * @var array
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
