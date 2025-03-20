<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'baby_id' => $this->baby_id,
            'guardian_id' => $this->guardian_id,
            'doctor_id' => $this->doctor_id,
            'nurse_id' => $this->nurse_id,
            'vaccine_id' => $this->vaccine_id,
            'appointment_date' => $this->appointment_date,
            'status' => $this->status,
            'reminder_sent' => $this->reminder_sent,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}