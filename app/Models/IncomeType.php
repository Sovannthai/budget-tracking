<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeType extends Model
{
    // use SoftDeletes;
    /**
     * Relationship with the Customer model
     *  This indicates that an income type belongs to a customer.
     * @var array
     */
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    /**
     * Relationship with the Income model
     * This indicates that an income type can have multiple incomes.
     * @var array
     */
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
}
