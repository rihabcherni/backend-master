<?php

use App\Http\Controllers\API\ContactsController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\API\TransportDechet\CamionController;

use App\Http\Controllers\API\Dashboard\CompteurController;
use App\Http\Controllers\API\Dashboard\SommeDechetController;
use App\Http\Controllers\API\Dashboard\RechercheController;
use App\Http\Controllers\API\Dashboard\RegionController;
use App\Http\Controllers\API\Dashboard\DashboardEtablissementController;
use App\Http\Controllers\API\Dashboard\CalendrierController;

use App\Http\Controllers\Auth\ClientDechet\AuthClientDechetController;
use App\Http\Controllers\Authentification\AuthController;
use App\Http\Controllers\Auth\Gestionnaire\AuthGestionnaireController;
use App\Http\Controllers\Auth\Ouvrier\AuthOuvrierController;
use App\Http\Controllers\Auth\ResponsableEtablissement\AuthResponsableEtablissementController;


/**--------------  **************           debut web       ************************** -------------------**/

    /** -------------  **************          debut recherche    ************************** ------------------**/
            Route::get('/recherche-etablissement-zone-travail-nom/{nom_zone}', [RechercheController::class, 'rechercheEtablissementNomZone']);
            Route::get('/recherche-etablissement-zone-travail-id/{zone_travail_id}', [RechercheController::class, 'rechercheEtablissementIDZone']);

            Route::get('/recherche-zone-travail/{region}', [RechercheController::class, 'rechercheZoneTravail']);

            Route::get('/recherche-reparateur-poubelle/{adresse}', [RechercheController::class, 'rechercheReparateurPoubelleAdresse']);

            Route::get('/recherche-bloc-poubelle/{etablissement}/{nom_bloc_etab}/{nom_etage}/{id_bloc_poubelle}', [RechercheController::class, 'rechercheBlocPoubelleEtab']);

            Route::get('/poubelle-bloc-poubelle-id/{bloc_poubelle_id}', [RechercheController::class, 'rechercheBlocPoubelleId']);
            Route::get('/poubelle/searchEType/{type}', [RechercheController::class, 'searchEType']);

            Route::get('/camion/searchMatricule/{matricule}', [CamionController::class, 'searchMatricule']);

    /** -------------  **************         fin recherche      **************************  ------------------**/

    /** -------------  **************         debut Calendrier      **************************  ------------------**/
            Route::get('/calendrier', [CalendrierController::class, 'calendrier']);
    /** -------------  **************         fin Calendrier      **************************  ------------------**/


/** -------------  **************           fin web         **************************  ------------------**/

/** -------------  **************           debut mobile         **************************  ------------------**/

/** -------------  **************           fin mobile         **************************  ------------------**/

/** ---------------------------------------------- debut Dashboard ----------------------------------------------------*/

            /** -------------  **************         debut dashborad responsable etablissement         **************************  ------------------**/
                    Route::get('/donnee-etablissement/{id}', [DashboardEtablissementController::class, 'donnee_etablissement']);
                    Route::get('/dashboard-etablissement/{id}', [DashboardEtablissementController::class, 'dashboard_etablissement']);
            /** -------------  **************         fin dashborad responsable etablissement      **************************  ------------------**/

            /** -------------  **************         debut dashborad gestionnaire      **************************  ------------------**/
                     Route::get('/dashboard', [CompteurController::class, 'dashbordValeur']);
                /** -------------  **************         debut somme      **************************  ------------------**/
                    Route::get('/somme-total-dechet-zone-depot', [SommeDechetController::class, 'SommeDechetZoneDepot']);
                    Route::get('/somme-total-dechet-zone-travail', [SommeDechetController::class, 'SommeDechetZoneTravail']);
                    // Route::get('/somme-total-dechet-etablissement/{zone_travail_id}', [SommeDechetController::class, 'SommeDechetBlocEtablissement']);

                    Route::get('/prixdechets', [SommeDechetController::class, 'PrixDechets']);

                    Route::get('/somme-dechets-par-mois', [SommeDechetController::class, 'sommeDechetsparMois']);
                    Route::get('/somme-dechet-annees', [SommeDechetController::class, 'sommeDechetAnnees']);
                    Route::get('/somme-dechets-vendus', [SommeDechetController::class, 'sommeDechetsVendus']);

                    /** -------------------------------------------Dashboard -----------------------------------------*/
                /** -------------  **************         fin somme      **************************  ------------------**/
            /** -------------  **************         fin dashborad gestionnaire        **************************  ------------------**/



            /** -------------  **************         debut map      **************************  ------------------**/
                Route::get('/region-map', [RegionController::class, 'RegionMap']);
            /** -------------  **************         fin map      **************************  ------------------**/

/** ----------------------------------------------fin Dashboard ----------------------------------------------------*/

            /** -------------  **************         debut authentifiaction      **************************  ------------------**/
                Route::post('/register' , [AuthController::class , 'register']);
                Route::post('/login',[AuthController::class, 'login']);
                // Route::get('/logout',[AuthController::class, 'logout']);
                Route::get('/allUser',[AuthController::class, 'allUser']);
                Route::get('/profile',[AuthController::class, 'profile']);

                Route::post('/update/{id}',[AuthController::class , 'update']);
                Route::post('/qrlogin/{test}',[AuthController::class , 'qrlogin']);
                Route::post('/updatePassword/{id}',[AuthController::class , 'updatePassword']);
                Route::post('/forgotPassword',[AuthController::class , 'send']);



                Route::post('/send-ouvrier',[AuthOuvrierController::class,'send']);

            /** -------------  **************         fin authentifiaction      **************************  ------------------**/

                //  Route::get('/ip', function(){
                //     $clientIP = request()->ip();
                //     return $clientIP;
                // });



                Route::get('/google-map', [RegionController::class, 'GoogleMap']);
                Route::get('/google-map/{id}', [RegionController::class, 'GoogleMapId']);
                Route::get('/google-map-camion', [RegionController::class, 'GoogleMapCamion']);
                Route::get('/google-map-camion/{id}', [RegionController::class, 'GoogleMapCamionId']);

                Route::get('/all-client-dechets', [AuthClientDechetController::class, 'allClientDechets']);
                Route::get('/all-ouvriers', [AuthOuvrierController::class, 'allOuvriers']);
                Route::get('/all-responsable-etablissements', [AuthResponsableEtablissementController::class, 'allResponsableEtablissement']);
                Route::get('/all-gestionnaires', [AuthGestionnaireController::class, 'allGestionnaire']);



                Route::apiResource('contact-us', ContactsController::class);




