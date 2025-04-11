<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * 
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'contact_id' => $this->contact_id,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'gender'     => $this->gender,
            'dob'        => $this->dob,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'address'    => $this->address,
            'image_url'  => $this->image_url,
        ];
    }
}
