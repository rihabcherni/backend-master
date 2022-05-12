<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class Bloc_poubelleFactory extends Factory{
    public function definition() {
        return [
            'etage_etablissement_id'=> \App\Models\Etage_etablissement::all()->random()->id,
        ];
    }
}

