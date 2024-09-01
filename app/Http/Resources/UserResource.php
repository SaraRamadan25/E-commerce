<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'middle_name' => $this->when($this->middle_name, $this->middle_name),
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->when($this->phone_number, $this->phone_number),
            'address' => $this->when($this->address, $this->address),
            'city' => $this->when($this->city, $this->city),
            'country' => $this->when($this->country, $this->country),
            'postal_code' => $this->when($this->postal_code, $this->postal_code),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
