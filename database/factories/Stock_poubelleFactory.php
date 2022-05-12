<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class Stock_poubelleFactory extends Factory{
    public function definition()
    {
        return [
            'type_poubelle'=>'plastique',
            'capacite_poubelle'=>240,
            'quantite_disponible'=>0,
            'pourcentage_remise'=>0,
            'photo' => null,
        ];

     }
}
