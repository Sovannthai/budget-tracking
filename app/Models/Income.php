<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    /**
     * Relationship with the IncomeType model
     * This indicates that an income belongs to an income type.
     * @var array
     */
    public function incomeType()
    {
        return $this->belongsTo(IncomeType::class);
    }
    
    /**
     * Relationship with the Customer model
     * This indicates that an income belongs to a customer.
     * @var array
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
