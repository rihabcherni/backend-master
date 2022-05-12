<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Etage_etablissementFactory extends Factory
{

    public function definition()
    {
        $etage = 'Etage '. $this->faker->randomElement(['1','2','3']);
        return [
            'bloc_etablissement_id'=> \App\Models\Bloc_etablissement::all()->random()->id,
            'nom_etage_etablissement'=>$etage,
        ];
    }
}
