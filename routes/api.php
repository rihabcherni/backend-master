<?php

use App\Http\Controllers\API\ContactsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GestionCompte\GestionnaireController;
use App\Http\Controllers\API\GestionCompte\Client_dechetController;
use App\Http\Controllers\API\GestionCompte\OuvrierController;
use App\Http\Controllers\API\GestionCompte\ResponsableEtablissementController;

use App\Http\Controllers\API\GestionDechet\Commande_dechetController;
use App\Http\Controllers\API\GestionDechet\DechetController;
use App\Http\Controllers\API\GestionDechet\Detail_commande_dechetController;

use App\Http\Controllers\API\GestionPanne\MecanicienController;
use App\Http\Controllers\API\GestionPanne\Reparation_camionController;
use App\Http\Controllers\API\GestionPanne\Reparateur_poubelleController;
use App\Http\Controllers\API\GestionPanne\Reparation_poubelleController;

use App\Http\Controllers\API\GestionPoubelleEtablissements\Bloc_poubelleController;
use App\Http\Controllers\API\GestionPoubelleEtablissements\EtablissementController;
use App\Http\Controllers\API\GestionPoubelleEtablissements\Zone_travailController;
use App\Http\Controllers\API\GestionPoubelleEtablissements\PoubelleController;
use App\Http\Controllers\API\GestionPoubelleEtablissements\Commande_poubelleController;
use App\Http\Controllers\API\GestionPoubelleEtablissements\Detail_commande_poubelleController;

use App\Http\Controllers\API\ProductionPoubelle\FournisseurController;
use App\Http\Controllers\API\ProductionPoubelle\StockPoubelleController;
use App\Http\Controllers\API\ProductionPoubelle\MateriauxPrimaireController;

use App\Http\Controllers\API\TransportDechet\CamionController;
use App\Http\Controllers\API\TransportDechet\DepotController;
use App\Http\Controllers\API\TransportDechet\Zone_depotController;


use App\Http\Controllers\API\Ouvrier\ViderController;
use App\Http\Controllers\API\Dashboard\CompteurController;
use App\Http\Controllers\API\Dashboard\SommeDechetController;
use App\Http\Controllers\API\Dashboard\RechercheController;
use App\Http\Controllers\API\Dashboard\RegionController;
use App\Http\Controllers\API\Dashboard\DashboardEtablissementController;
use App\Http\Controllers\API\Dashboard\CalendrierController;
use App\Http\Controllers\API\GestionPoubelleEtablissements\Bloc_etablissementsController;
use App\Http\Controllers\API\GestionPoubelleEtablissements\Etage_etablissementsControlller;
use App\Http\Controllers\Auth\ClientDechet\AuthClientDechetController;
use App\Http\Controllers\Authentification\AuthController;
use App\Http\Controllers\Auth\Gestionnaire\AuthGestionnaireController;
use App\Http\Controllers\Auth\Ouvrier\AuthOuvrierController;
use App\Http\Controllers\Auth\ResponsableEtablissement\AuthResponsableEtablissementController;


/**--------------  **************           debut web       ************************** -------------------**/
    /**--------------  **************           debut crud       ************************** -------------------**/
        /** -------------------------------------------gestion Compte -----------------------------------------*/
                    /**                 administrateurs                        */
                Route::apiResource('gestionnaire', GestionnaireController::class);
                Route::delete('/gestionnaire/hard-delete/{id}', [GestionnaireController::class, 'hdelete']);
                Route::get('/gestionnaire/restore/{id}', [GestionnaireController::class, 'restore']);
                Route::get('/admin/restoreall', [GestionnaireController::class, 'restoreAll']);
                Route::get('/admin/trash', [GestionnaireController::class, 'gestionnairetrash']);
                    /**                 client                                  */
                Route::apiResource('client', Client_dechetController::class);

                    /**                  ouvrier                                */
                Route::apiResource('ouvrier', OuvrierController::class);

                    /**                  responsable etablissement              */
                Route::apiResource('responsable-etablissement', ResponsableEtablissementController::class);
        /** -------------------------------------------gestion Dechet -----------------------------------------*/
                    /**                  commandes                     */
                Route::apiResource('commande-dechet', Commande_dechetController::class);
                    /**                  dechets                       */
                Route::apiResource('dechets', DechetController::class);
                /**                  detail commande dechet         */
                Route::apiResource('detail-commande-dechets', Detail_commande_dechetController::class);
        /** -------------------------------------------gestion Panne -----------------------------------------*/
                /**                        reparateur poubelle             */
                Route::apiResource('reparateur-poubelle', Reparateur_poubelleController::class);
                /**                        mecanicien                  */
                Route::apiResource('mecanicien', MecanicienController::class);
                /**                        reparation poubelle            */
                Route::apiResource('reparation-poubelle', Reparation_poubelleController::class);
                /**                        reparation camion               */
                Route::apiResource('reparation-camion', Reparation_camionController::class);
        /** -------------------------------------------gestion Poubelle par etablissement -----------------------------------------------*/
                    /**                   zone-travail                        */
                Route::apiResource('zone-travail', Zone_travailController::class);
                        /**                  etablissement                      */
                Route::apiResource('etablissement', EtablissementController::class);

                        /**                bloc   etablissements                      */
                Route::apiResource('bloc-etablissement', Bloc_etablissementsController::class);


                        /**                etage etablissements                      */
                Route::apiResource('etage-etablissement', Etage_etablissementsControlller::class);

                        /**                  bloc-poubelle                      */
                Route::apiResource('bloc-poubelle', Bloc_poubelleController::class);
                        /**                    poubelle                        */
                Route::apiResource('poubelle', PoubelleController::class);
                                    /**                  detail commande poubelle                       */
                Route::apiResource('detail-commande-poubelle', Detail_commande_poubelleController::class);
                        /**                   commande dechet                       */
                Route::apiResource('commande-poubelle', Commande_poubelleController::class);
        /** -------------------------------------------transport poubelle -----------------------------------------*/
                    /**                       camion                            */
            Route::apiResource('camion', CamionController::class);
                    /**                        zone depot                       */
            Route::apiResource('zone-depot', Zone_depotController::class);
                    /**                       depot                            */
            Route::apiResource('depot', DepotController::class);
        /** -------------------------------------------production poubelle -----------------------------------------*/
                /**                   Fournisseur                         */
            Route::apiResource('fournisseurs', FournisseurController::class);
                /**                    Materiaux Primaires               */
            Route::apiResource('materiaux-primaires',MateriauxPrimaireController::class);
                /**                   Stock poubelle                  */
            Route::apiResource('stock-poubelle', StockPoubelleController::class);

    /**--------------  **************          fin crud          ************************** -------------------**/

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
            /** ------------------------------ debut ouvrier vider -----------------------------------------*/
                Route::get('/viderPoubelle/{ouvrier}/{poubelle}', [ViderController::class, 'ViderPoubelle']);
                Route::post('/viderPoubelleQr/{qr}', [ViderController::class, 'ViderPoubelleQr']);
                Route::get('/viderCamion/{depot}', [ViderController::class, 'ViderCamion']);
            /** ------------------------------- fin ouvrier vider -----------------------------------------*/
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




