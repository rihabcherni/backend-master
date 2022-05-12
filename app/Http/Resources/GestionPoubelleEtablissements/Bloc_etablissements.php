<?php

namespace App\Http\Resources\GestionPoubelleEtablissements;

use Illuminate\Http\Resources\Json\JsonResource;

class Bloc_etablissements extends JsonResource{
    public function toArray($request) {
        return [
            'id' => $this->id,

            'etablissement_id' => $this->etablissement_id,
            'nom_bloc_etablissement' => $this->nom_bloc_etablissement,
            'etage_etablissements' => $this->etage_etablissements,

            'created_at' => $this->created_at->format('d/m/y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/y H:i:s'),
            'deleted_at' => $this->deleted_at,
        ];
     }
}
