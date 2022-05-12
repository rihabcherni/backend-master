<?php

namespace App\Http\Resources\GestionCompte;

use Illuminate\Http\Resources\Json\JsonResource;

class Responsable_etablissement extends JsonResource{
    public function toArray($request){
        return [
            'id' => $this->id,

            'nom_etablissement' => $this->nom_etablissement,
            'nom_responsable' => $this->nom_responsable,
            'numero_fixe' => $this->numero_fixe,
            'adresse' => $this->adresse,
            'numero_telephone' => $this->numero_telephone,
            'email' => $this->email,
            'mot_de_passe' => $this->mot_de_passe,e,

            'created_at' => $this->created_at->format('d/m/y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/y H:i:s'),
            'deleted_at' => $this->deleted_at,
        ];
    }
}
