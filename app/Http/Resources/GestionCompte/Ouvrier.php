<?php

namespace App\Http\Resources\GestionCompte;

use Illuminate\Http\Resources\Json\JsonResource;

class Ouvrier extends JsonResource{
    public function toArray($request){
        return [
            'id' => $this->id,

            'zone_travail_id'=> $this->zone_travail_id,
            'camion_id'=> $this->camion_id,
            'poste'=> $this->poste,
            'qrcode'=> $this->qrcode,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'adresse' => $this->adresse,
            'CIN' => $this->CIN,
            'photo' => $this->photo,
            'numero_telephone' => $this->numero_telephone,
            'email' => $this->email,
            'mot_de_passe' => $this->mot_de_passe,

            'created_at' => $this->created_at->format('d/m/y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/y H:i:s'),
            'deleted_at' => $this->deleted_at,
        ];
    }
}
