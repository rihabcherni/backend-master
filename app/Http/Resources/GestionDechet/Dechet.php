<?php

namespace App\Http\Resources\GestionDechet;

use Illuminate\Http\Resources\Json\JsonResource;

class Dechet extends JsonResource{
    public function toArray($request){
       return [
        'id' => $this->id,

        'type_dechet' => $this->type_dechet,
        'prix_unitaire' => $this->prix_unitaire,
        'photo'=>$this->photo,
        'created_at' => $this->created_at->format('d/m/y H:i:s'),
        'updated_at' => $this->updated_at->format('d/m/y H:i:s'),
        'deleted_at' => $this->deleted_at,
    ];
    }
}
