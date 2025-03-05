<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'user_id' => $this->user_id,
            'specialization' => $this->specialization,
            'availability' => $this->availability,
            'license_number' => $this->license_number,
            'work_phone_number' => $this->work_phone_number,
            'bio' => $this->bio,
            
            // Include related user information
            'user' => $this->whenLoaded('user', function() {
                return [
                    'id'=> $this->user->id,
                    'first_name'=> $this->user->first_name,
                    'last_name'=> $this->user->last_name,
                    'email'=> $this->user->email,
                    'phone_number'=> $this->user->phone_number,
                    'gender' => $this->user->gender,
                ];
            }),
        ];
    }
}
