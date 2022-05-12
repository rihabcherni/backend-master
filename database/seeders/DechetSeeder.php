<?php

namespace Database\Seeders;

use App\Models\Dechet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DechetSeeder extends Seeder{
    public function run()
    {
        // Dechet::factory(4)->create();
        Dechet::create([
            'type_dechet'=> 'plastique',
            'prix_unitaire'=>1200,
            'photo' =>null,
        ]);
        Dechet::create([
            'type_dechet'=> 'composte',
            'prix_unitaire'=>2000,
            'photo' =>null,
        ]);
        Dechet::create([
            'type_dechet'=> 'papier',
            'prix_unitaire'=>800,
            'photo' =>null,
        ]);
        Dechet::create([
            'type_dechet'=> 'canette',
            'prix_unitaire'=>1400,
            'photo' =>null,
        ]);
    }
}
