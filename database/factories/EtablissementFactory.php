<?php

namespace Database\Factories;

use App\Models\Etablissement;
use Illuminate\Database\Eloquent\Factories\Factory;

class EtablissementFactory extends Factory{

    public function definition() {
        return [
            'zone_travail_id'=>\App\Models\Zone_travail::factory()->create()->id,
            'responsable_etablissement_id'=>\App\Models\Responsable_etablissement::factory()->create()->id,
            'nom_etablissement'=> $this->faker->name,
            'type_etablissement'=>  $this->faker->randomElement(['primaire', 'college','secondaire','universite','societe']),
            'nbr_personnes'=> $this->faker->randomNumber(4, true),
            'url_map'=> $this->faker->sentence(),
            'adresse'=> $this->faker->address,
            'longitude'=> $this->faker->longitude($min = -180, $max = 180),
            'latitude'=> $this->faker->latitude($min = -90, $max = 90),
            'quantite_dechets_plastique'=>0,
            'quantite_dechets_composte'=> 0,
            'quantite_dechets_papier'=>0,
            'quantite_dechets_canette'=>0,
        ];
    }
}
