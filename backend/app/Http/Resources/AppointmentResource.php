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
            'baby' => $this->whenLoaded('baby', function () {
                return [
                    'id' => $this->baby->id,
                    'full_name' => $this->baby->first_name . ' ' . $this->baby->last_name,
                ];
            }),
            'guardian' => $this->whenLoaded('guardian', function () {
                return [
                    'id' => $this->guardian->id,
                    'full_name' => $this->guardian->first_name . ' ' . $this->guardian->last_name,
                ];
            }),
            'doctor' => $this->whenLoaded('doctor', function () {
                return [
                    'id' => $this->doctor->id,
                    'contact_number' => $this->doctor->work_phone_number,
                ];
            }),
            'vaccine' => $this->whenLoaded('vaccine', function () {
                return [
                    'id' => $this->vaccine->id,
                    'name' => $this->vaccine->vaccine_name,
                ];
            }),
            'appointment_details' => [
                'date' => $this->appointment_date,
                'status' => $this->status,
                'notes' => $this->notes,
                'reminder_sent' => $this->reminder_sent,
            ]
        ];
    }
}