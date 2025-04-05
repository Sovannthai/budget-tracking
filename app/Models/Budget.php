<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $guarded = [];
    /**
     * Relationship with the Customer model
     * This indicates that a budget belongs to a customer.
     * @var array
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
