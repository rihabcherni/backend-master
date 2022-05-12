<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class Zone_travailFactory extends Factory{
    public function definition()
    {
        return [
            'region'=> $this->faker->city,
            'quantite_total_collecte_plastique'=>0,
            'quantite_total_collecte_composte'=> 0,
            'quantite_total_collecte_papier'=>0,
            'quantite_total_collecte_canette'=> 0,
        ];
    }
}
