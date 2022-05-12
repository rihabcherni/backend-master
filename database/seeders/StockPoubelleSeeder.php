<?php

namespace Database\Seeders;

use App\Models\Stock_poubelle;
use Illuminate\Database\Seeder;

class StockPoubelleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $capacite_poubelle=[120,240,360,480];
        foreach($capacite_poubelle as $capacite){
            Stock_poubelle::create([
                'type_poubelle'=>'plastique',
                'capacite_poubelle'=>$capacite,
                'quantite_disponible'=>0,
                'pourcentage_remise'=>0,
                'photo'=>null,
            ]);
        }

    }
}
