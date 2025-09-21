<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class ReceptionResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'patient' => $this->patient,
            'observations' => $this->observations,
            'status' => $this->status,
            'cups' => $this->cups,
        ];
    }
}
