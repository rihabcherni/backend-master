<?php

namespace App\Http\Resources\GestionDechet;

use Illuminate\Http\Resources\Json\JsonResource;

class Detail_commande_dechet extends JsonResource{
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            'commande_dechet_id' => $this->commande_dechet_id,
            'dechet_id' => $this->dechet_id,
            'quantite' => $this->quantite,

            'created_at' => $this->created_at->format('d/m/y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/y H:i:s'),
            'deleted_at' => $this->deleted_at,

        ];
    }
}
