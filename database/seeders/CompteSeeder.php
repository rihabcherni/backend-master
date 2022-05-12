<?php

namespace Database\Seeders;

use App\Models\Camion;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Client_dechet;
use App\Models\Gestionnaire;
use App\Models\Ouvrier;
use App\Models\Responsable_etablissement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompteSeeder extends Seeder{
    public function run(){
        Gestionnaire::create([
            'nom'=> 'gestionnaire',
            'prenom'=> 'reschool',
            'CIN'=> 125411222,
            'numero_telephone'=> 23657412,
            'email'=> 'gestionnaire1.reschool@gmail.com',
            'adresse'=> 'adresse gestionnaire',
            'mot_de_passe'=> Hash::make('gestionnaire1'),
            'QRcode'=> Hash::make('gestionnaire1.reschool@gmail.com'),
        ]);
        Responsable_etablissement::create([
            'nom_etablissement'=> 'reponsable ',
            'nom_responsable'=> 'etablissement',
            'numero_telephone'=> 21548796,
            'numero_fixe'=> 231211224,
            'email'=> 'responsable1.reschool@gmail.com',
            'adresse'=> 'adresse responsable etablissement',
            'mot_de_passe'=> Hash::make('responsable1'),
            'QRcode'=> Hash::make('responsable1.reschool@gmail.com'),
        ]);

        Camion::create([
            'zone_travail_id'=> 1,
            'matricule' =>'125 tunis 201',
            'QRcode' => Hash::make(Str::random(10)),
            'latitude'=> 36.87885 ,
            'longitude'=>10.23284,
            'volume_maximale_camion'=>2000,
            'volume_actuelle_plastique'=>0,
            'volume_actuelle_papier'=> 0,
            'volume_actuelle_composte'=>0,
            'volume_actuelle_canette'=> 0,
            'volume_carburant_consomme'=>0,
            'Kilometrage'=>0,
        ]);
        Ouvrier::create([
            'zone_travail_id'=> 1,
            'camion_id'=> 1,
            'poste'=> 'conducteur',
            'QRcode' => Hash::make('ouvrier1'),
            'nom'=> 'Samir',
            'prenom'=> 'Ben salah',
            'CIN'=> 12475555,
            'numero_telephone'=> 55875252,
            'email'=> 'ouvrier1.reschool@gmail.com',
            'adresse'=> 'adresse ouvrier',
            'mot_de_passe'=> Hash::make('ouvrier1'),
        ]);
        Ouvrier::create([
            'zone_travail_id'=> 1,
            'camion_id'=> 1,
            'poste'=> 'agent',
            'QRcode' => Hash::make('ouvrier2'),
            'nom'=> 'Ahmed',
            'prenom'=> 'Ben ahmed',
            'CIN'=> 12475855,
            'numero_telephone'=> 45212154,
            'email'=> 'ouvrier2.reschool@gmail.com',
            'adresse'=> 'adresse ouvrier 2',
            'mot_de_passe'=> Hash::make('ouvrier2'),
        ]);
        Client_dechet::create([
            'nom_entreprise'=> 'client',
            'nom_responsable'=> 'reschool',
            'matricule_fiscale'=> 21548796,
            'numero_telephone'=> 421211224,
            'numero_fixe'=> 421231224,
            'email'=> 'client1.reschool@gmail.com',
            'adresse'=> 'adresse client dechet',
            'mot_de_passe'=> Hash::make('client-dechet1'),
            'QRcode'=> Hash::make('client1.reschool@gmail.com'),
        ]);

    }
}
