<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                      => $this->id,
            'customer_id'             => $this->customer_id,
            'income_type_id'          => $this->income_type_id,
            'amount'                  => $this->amount,
            'date'                    => $this->date,
            'description'             => $this->description,
        ];
    }
}
