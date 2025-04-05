<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $guarded = [];
    /**
     * Relationship with the ExpenseType model
     * This indicates that an expense belongs to an expense type.
     * @var array
     */
    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class);
    }
    /**
     * Relationship with the Customer model
     * This indicates that an expense belongs to a customer.
     * @var array
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
