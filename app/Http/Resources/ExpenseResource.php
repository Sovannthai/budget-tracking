<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'amount'         => $this->amount,
            'customer_id'    => $this->customer_id,
            'expense_type_id'=> $this->expense_type_id,
            'description'    => $this->description,
            'date'           => $this->date,
        ];
    }
}
