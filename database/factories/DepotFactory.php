<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class DepotFactory extends Factory{
    public function definition()
    {
        return [
            'zone_depot_id'=>\App\Models\Zone_depot::all()->random()->id,
            'camion_id'=>\App\Models\Camion::all()->random()->id,
            'date_depot'=>$this->faker->date('Y-m-d h-i-s','now'),
            'quantite_depose_plastique'=> 0,
            'quantite_depose_papier'=> 0,
            'quantite_depose_composte'=> 0,
            'quantite_depose_canette'=> 0,
        ];
    }
}
