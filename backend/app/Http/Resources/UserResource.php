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
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'gender' => $this->gender,
            'role' => $this->role,
            'nationality' => $this->nationality,
            'national_id' => $this->national_id,
            'date_of_birth' => $this->date_of_birth,
            'address' => $this->address,
            'marital_status' => $this->marital_status,
            'next_of_kin' => $this->next_of_kin,
            'next_of_kin_contact' => $this->next_of_kin_contact,
            'no_of_children' => $this->no_of_children,
        ];
    }
}
