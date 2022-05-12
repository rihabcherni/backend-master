<?php

namespace App\Http\Resources\GestionPoubelleEtablissements;

use Illuminate\Http\Resources\Json\JsonResource;

class Etage_etablissements extends JsonResource{
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            'bloc_etablissement_id' => $this->bloc_etablissement_id,
            'nom_etage_etablissement' => $this->nom_etage_etablissement,
            'bloc_poubelles' => $this->bloc_poubelles,

            'created_at' => $this->created_at->format('d/m/y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/y H:i:s'),
            'deleted_at' => $this->deleted_at,
        ];     }
}
