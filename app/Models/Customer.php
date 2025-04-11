<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes, HasApiTokens, Notifiable;
    protected $guarded = [];
    protected $appends = ['image_url'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'dob' => 'date',
    ];
    /**
     * Generate the image URL
     * @param string $imageName
     * @return string|null
     */
    protected function generateImageUrl($imageName)
    {
        if (!empty($imageName)) {
            return asset('uploads/all_photo/' . rawurlencode($imageName));
        } else {
            return null;
        }
    }
    /**
     * Get the image URL
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        return $this->generateImageUrl($this->image) ?: asset('uploads/all_photo/default.png');
    }

    /**
     * Relationship with the Income model
     * income hasMany customer
     */
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
    /*
    * Relationship with the ExpenseType model
    * expense hasMany customer
    */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    /**
     * Relationship with the ExpenseType model
     * expenseType hasMany customer
     */
    public function expenseTypes()
    {
        return $this->hasMany(ExpenseType::class);
    }

    /*
     * Relationship with the IncomeType model
     * incomeType hasMany customer
     */
    public function incomeTypes()
    {
        return $this->hasMany(IncomeType::class);
    }
    /**
     * Relationship with the Budget model
     * budget hasMany customer
     */
    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }


    /**
     * Generate a unique contact ID with 10 characters
     * @return string
     */
    public static function generateContactId()
    {
        $length = 10;

        do {
            $randomNumber = mt_rand(pow(10, $length - 1), pow(10, $length) - 1);
            $contactId = (string) $randomNumber;
        } while (self::where('contact_id', $contactId)->exists());

        return $contactId;
    }

    /**
     * Boot the model and set the contact_id if not already set
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($customer) {
            if (!$customer->contact_id) {
                $customer->contact_id = self::generateContactId();
            }
        });
    }
}
