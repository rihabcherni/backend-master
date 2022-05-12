<?php

namespace App\Http\Resources\GestionPoubelleEtablissements;

use Illuminate\Http\Resources\Json\JsonResource;

class Bloc_poubelle extends JsonResource{
    public function toArray($request)
    {
       return [
        'id' => $this->id,

        'etage_etablissement_id' => $this->etage_etablissement_id,

        'poubelle'=>$this->poubelles,

        'created_at' => $this->created_at->format('d/m/y H:i:s'),
        'updated_at' => $this->updated_at->format('d/m/y H:i:s'),
        'deleted_at' => $this->deleted_at,
    ];
    }
}
