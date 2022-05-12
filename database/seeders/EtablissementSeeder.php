<?php

namespace Database\Seeders;

use App\Models\Etage_etablissement;
use App\Models\Etablissement;
use App\Models\Bloc_etablissement;
use App\Models\Bloc_poubelle;
use App\Models\Poubelle;
use App\Models\Responsable_etablissement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EtablissementSeeder extends Seeder{
    public function run(){
         Responsable_etablissement::factory(8)->create();
        //  Etablissement::factory(5)->create();
         Etablissement::create([
            'zone_travail_id'=>1,
            'responsable_etablissement_id'=>1,
            'nom_etablissement'=> 'ESSECT',
            'type_etablissement'=> 'universite',
            'nbr_personnes'=> 3500,
            'url_map'=> 'https://goo.gl/maps/bJuBsVTcdLjxmFMw5',
            'adresse'=> '4, Rue Abou Zakaria El Hafsi - 1089 Montfleury - Tunis - 1089 Tunis',
            'longitude'=> 10.174750000000000000000000000,
            'latitude'=> 36.787200000000000000000000000,
            'quantite_dechets_plastique'=>0,
            'quantite_dechets_composte'=> 0,
            'quantite_dechets_papier'=> 0,
            'quantite_dechets_canette'=> 0,
        ]);
        Etablissement::create([
            'zone_travail_id'=>1,
            'responsable_etablissement_id'=>2,
            'nom_etablissement'=> 'FSEG',
            'type_etablissement'=> 'universite',
            'nbr_personnes'=> 4000,
            'url_map'=>'https://goo.gl/maps/CEjvUY8Mz283VKn78',
            'adresse'=> 'Tunis, B.P 248 2092، Tunis',
            'longitude'=> 10.150930000000000000000000000,
            'latitude'=> 36.831850000000000000000000000,
            'quantite_dechets_plastique'=>0,
            'quantite_dechets_composte'=> 0,
            'quantite_dechets_papier'=> 0,
            'quantite_dechets_canette'=> 0,
        ]);
        Etablissement::create([
            'zone_travail_id'=>1,
            'responsable_etablissement_id'=>3,
            'nom_etablissement'=> 'ISG',
            'type_etablissement'=> 'universite',
            'nbr_personnes'=> 3000,
            'url_map'=> 'https://goo.gl/maps/CTPFs8EkZpfYU5177',
            'adresse'=> '41 Av. de la Liberte, Tunis 2000',
            'longitude'=> 10.150433000000000000000000000,
            'latitude'=> 36.804441000000000000000000000,
            'quantite_dechets_plastique'=>0,
            'quantite_dechets_composte'=> 0,
            'quantite_dechets_papier'=> 0,
            'quantite_dechets_canette'=> 0,
        ]);
        Etablissement::create([
            'zone_travail_id'=>2,
            'responsable_etablissement_id'=>4,
            'nom_etablissement'=> 'ISI',
            'type_etablissement'=> 'universite',
            'nbr_personnes'=> 2000,
            'url_map'=> 'https://goo.gl/maps/YrXFuaSxCewfGv8x6',
            'adresse'=> 'Rue Abourraihan Al Bayrouni, Ariana 2080',
            'longitude'=> 10.188910000000000000000000000,
            'latitude'=> 36.861600000000000000000000000,
            'quantite_dechets_plastique'=>0,
            'quantite_dechets_composte'=> 0,
            'quantite_dechets_papier'=> 0,
            'quantite_dechets_canette'=> 0,
        ]);
        Etablissement::create([
            'zone_travail_id'=>1,
            'responsable_etablissement_id'=>5,
            'nom_etablissement'=> 'IHEC',
            'type_etablissement'=> 'universite',
            'nbr_personnes'=> 3000,
            'url_map'=>'https://goo.gl/maps/dvJSDyY3vS61sSVx8',
            'adresse'=> 'Rue Victor Hugo, Site archéologique de Carthage',
            'longitude'=> 10.332830000000000000000000000,
            'latitude'=> 36.878860000000000000000000000,
            'quantite_dechets_plastique'=>0,
            'quantite_dechets_composte'=> 0,
            'quantite_dechets_papier'=> 0,
            'quantite_dechets_canette'=> 0,
        ]);
        Etablissement::create([
            'zone_travail_id'=>4,
            'responsable_etablissement_id'=>6,
            'nom_etablissement'=> 'ESEN',
            'type_etablissement'=> 'universite',
            'nbr_personnes'=> 2000,
            'url_map'=>'https://goo.gl/maps/zQPUUhbQkNKdzz9A9',
            'adresse'=> 'Technopole de la Manouba – Manouba CP 2010',
            'longitude'=> 10.073130000000000000000000000,
            'latitude'=> 36.807740000000000000000000000,
            'quantite_dechets_plastique'=>0,
            'quantite_dechets_composte'=> 0,
            'quantite_dechets_papier'=> 0,
            'quantite_dechets_canette'=> 0,
        ]);
        Etablissement::create([
            'zone_travail_id'=>4,
            'responsable_etablissement_id'=>7,
            'nom_etablissement'=> 'ISCAE',
            'type_etablissement'=> 'universite',
            'nbr_personnes'=> 3200,
            'url_map'=>'https://goo.gl/maps/8dgifEeMXvGE72bs6',
            'adresse'=> 'Campus universitaire Manouba, 2010',
            'longitude'=> 10.060890000000000000000000000,
            'latitude'=> 36.815180000000000000000000000,
            'quantite_dechets_plastique'=>0,
            'quantite_dechets_composte'=> 0,
            'quantite_dechets_papier'=> 0,
            'quantite_dechets_canette'=> 0,
        ]);
        Etablissement::create([
            'zone_travail_id'=>1,
            'responsable_etablissement_id'=>8,
            'nom_etablissement'=> 'reschool',
            'type_etablissement'=> 'primaire',
            'nbr_personnes'=> 2500,
            'url_map'=> 'https://goo.gl/maps/JThJ4X5Ccuk1TDVz9',
            'adresse'=> '42 Rue 8603  Charguia 1 2035 Tunis',
            'longitude'=> 10.205499186074000000000000000,
            'latitude'=> 36.841488984544000000000000000,
            'quantite_dechets_plastique'=>0,
            'quantite_dechets_composte'=> 0,
            'quantite_dechets_papier'=> 0,
            'quantite_dechets_canette'=> 0,
        ]);

        for ($i = 1; $i <9; $i++) {
            Bloc_etablissement::create([
                'etablissement_id'=> $i,
                'nom_bloc_etablissement'=>'Bloc A',
            ]);
            Bloc_etablissement::create([
                'etablissement_id'=> $i,
                'nom_bloc_etablissement'=>'Bloc B',
            ]);
            Bloc_etablissement::create([
                'etablissement_id'=> $i,
                'nom_bloc_etablissement'=>'Bloc C',
            ]);
        }
        for ($b = 1; $b <25; $b++) {
            for ($e = 1; $e<4; $e++) {
                Etage_etablissement::create([
                    'bloc_etablissement_id'=> $b,
                    'nom_etage_etablissement'=> 'Etage '.$e,
                ]);
            }
        }
        for ($b = 1; $b <74; $b++) {
            $etage=\App\Models\Etage_etablissement::all()->random()->id;
            Bloc_poubelle::create([
                'etage_etablissement_id'=> $etage,
            ]);

            $zone_travail = 1;
            $etablissement =  1;

            $qrcode= Hash::make('poubelle');
            $capacite=[120,240,360,480];
            $taille= array_rand($capacite);
            $poubelles=[
                [$capacite[$taille],'plastique','PL'],
                [$capacite[$taille],'papier','PA'],
                [$capacite[$taille],'composte','CO'],
                [$capacite[$taille],'canette','CA']
            ];
            foreach($poubelles as $poubelle){
              Poubelle::create([
                'bloc_poubelle_id'=>$b,
                'nom'=>$poubelle[2].'-EG'.$etage.'-BP'.$b,
                'qrcode' => $qrcode,
                'capacite_poubelle'=>$poubelle[0],
                'type'=>$poubelle[1],
                'Etat'=>rand(0.1, 1000) / 10,
                'temps_remplissage'=>'2022-04-26 13:39:52',
            ]);
        }
        }
    }
}
