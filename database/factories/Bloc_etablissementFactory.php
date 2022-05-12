<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Bloc_etablissementFactory extends Factory
{

    public function definition()
    {
        $bloc = 'Bloc '. $this->faker->unique()->randomElement(['A','B','C']);
        return [
            'etablissement_id'=> \App\Models\Etablissement::all()->random()->id,
            'nom_bloc_etablissement'=>$bloc,
        ];

    }
}
