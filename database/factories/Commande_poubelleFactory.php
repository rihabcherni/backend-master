<?php

namespace Database\Factories;

use App\Models\Commande_poubelle;
use Illuminate\Database\Eloquent\Factories\Factory;
class Commande_poubelleFactory extends Factory{
    protected $model = Commande_poubelle::class;

    public function definition()
    {
        return [
            'responsable_etablissement_id'=>\App\Models\Responsable_etablissement::all()->random()->id,
            'type_paiment'=>  $this->faker->randomElement(['en ligne','en cheque','en espece']),
            'montant_total'=> $this->faker->numberBetween(1000,10000),
            'date_commande'=>$this->faker->dateTimeBetween('now', '+1 days')->format('Y.m.d H:i:s'),
            'date_livraison'=>$this->faker->dateTimeBetween('+5 days', '+30 days')->format('Y.m.d H:i:s'),
        ];
    }
}
