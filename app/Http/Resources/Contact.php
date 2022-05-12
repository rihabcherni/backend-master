<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Contact extends JsonResource{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'numero_telephone' => $this->numero_telephone,
            'message' => $this->message,
            'created_at' => $this->created_at->format('d/m/y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/y H:i:s'),
            'deleted_at' => $this->deleted_at,

        ];    }
}
