<?php

namespace App\Http\Resources\ProductionPoubelle;

use Illuminate\Http\Resources\Json\JsonResource;

class MateriauxPrimaire extends JsonResource{
    public function toArray($request) {
        return [
            'id' => $this->id,

            'fournisseur_id' => $this->fournisseur_id,
            'nom_materiel' => $this->nom_materiel,
            'prix_unitaire' => $this->prix_unitaire,
            'quantite' => $this->quantite,
            'prix_total' => $this->prix_total,

            'created_at' => $this->created_at->format('d/m/y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/y H:i:s'),
            'deleted_at' => $this->deleted_at,
        ];
    }
}
