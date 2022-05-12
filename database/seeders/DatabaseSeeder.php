<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Bloc_etablissement, User, Gestionnaire,Fournisseur,Client_dechet,Mecanicien,Reparateur_poubelle,Zone_travail,Responsable_etablissement,Etablissement,Camion,Ouvrier,
    Bloc_poubelle,Poubelle ,Commande_dechet,Commande_poubelle,Dechet,Depot,Detail_commande_dechet,Detail_commande_poubelle, Etage_etablissement, Materiau_primaire,Reparation_camion,
    Reparation_poubelle,Stock_poubelle,Zone_depot};

class DatabaseSeeder extends Seeder{
    public function run(){

        $this->call([
            ZoneTravailSeeder::class,
            DechetSeeder::class,
            EtablissementSeeder::class,
            StockPoubelleSeeder::class,
        ]);
        $this->call([
            CompteSeeder::class,
        ]);
        User::factory(1)->create();
        Gestionnaire::factory(5)->create();
        Fournisseur::factory(5)->create();
        Client_dechet::factory(5)->create();
        Mecanicien::factory(5)->create();
        Reparateur_poubelle::factory(5)->create();

        // Zone_travail::factory(1)->create();
        // Responsable_etablissement::factory(5)->create();
        // Etablissement::factory(5)->create();


        // Zone_travail::factory(24)->create()->each(function ($zone) {
        //     $etb = Etablissement::factory(1)->make();
        //     $zone->etablissements()->saveMany($etb);
        // });


        Camion::factory(5)->create();
        Ouvrier::factory(10)->create();

        // Bloc_poubelle::factory(50)
        //     ->has(Poubelle::factory()->count(4))
        //     ->create();

        Reparation_camion::factory(5)->create();
        Reparation_poubelle::factory(5)->create();
        Materiau_primaire::factory(5)->create();

        // Stock_poubelle::factory(1)->create();
        Zone_depot::factory(5)->create();

        // Dechet::factory(4)->create();
        Depot::factory(15)->create();

        $commande_dechet = Commande_dechet::factory(10)->create();
        $commande_dechet->each(function ($u) {
            $u->detail_commande_dechet()->save(Detail_commande_dechet::factory()->make());
        });

        $commande_poubelle = Commande_poubelle::factory(10)->create();
        $commande_poubelle->each(function ($u) {
            $u->detail_commande_poubelle()->save(Detail_commande_poubelle::factory()->make());
        });


/*    Etablissement::factory()
        ->has(\App\Models\Zone_travail::factory()->count(4))
        ->count(10)
        ->create();

            Etablissement::factory(5)->create() ->each(function ($u) {
            $u->responsable_etablissement()->save(\App\Models\Responsable_etablissement::factory()->make());
        });
        */

    }
}
