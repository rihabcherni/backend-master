<?php

    use App\Http\Controllers\Auth\Gestionnaire\AuthGestionnaireController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\API\GestionPoubelleEtablissements\Bloc_etablissementsController;
    use App\Http\Controllers\API\GestionPoubelleEtablissements\Etage_etablissementsControlller;

    use App\Http\Controllers\API\TransportDechet\DepotController;
    use App\Http\Controllers\API\TransportDechet\Zone_depotController;
    use App\Http\Controllers\API\TransportDechet\CamionController;

    use App\Http\Controllers\API\ProductionPoubelle\FournisseurController;
    use App\Http\Controllers\API\ProductionPoubelle\StockPoubelleController;
    use App\Http\Controllers\API\ProductionPoubelle\MateriauxPrimaireController;

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

    use App\Http\Controllers\ConversationController;
    use App\Http\Controllers\MessageController;
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


    Route::group(['prefix' => 'auth-gestionnaire'], function () {
        Route::post('/register' , [AuthGestionnaireController::class , 'registerGestionnaire']);
        Route::post('/login',[AuthGestionnaireController::class, 'loginGestionnaire']);

        Route::group(['middleware'=>['auth:sanctum']], function() {

                Route::group(['middleware' => 'auth:gestionnaire'], function() {

                    Route::post('/logout',[AuthGestionnaireController::class, 'logoutGestionnaire']);
                    Route::post('/modifier-profile-gestionnaire/{id}',[AuthGestionnaireController::class,'modifierProfileGetstionnaire']);
                    Route::post('/modifier-gestionnaire-password/{email}',[AuthGestionnaireController::class,'modifierPasswordGestionnaire']);
                    Route::post('/send',[AuthGestionnaireController::class,'send']);
                    Route::post('/sendImage',[AuthGestionnaireController::class,'sendImage']);
                    Route::post('/destroyImage',[AuthGestionnaireController::class,'destroyImage']);
                    Route::post('/updateImage',[AuthGestionnaireController::class,'updateImage']);
                    Route::get('/profile' , function(){
                        return auth()->guard('gestionnaire')->user();
                    });

                    Route::get('/conversation' , [ConversationController::class , 'index']);
                    Route::post('/conversation' , [ConversationController::class , 'store']);
                    Route::post('/conversation/read' , [ConversationController::class , 'makeConversationAsReaded']);
                    Route::post('/message' , [MessageController::class , 'store']);
                });

                Route::get('/checkingAuthGestionnaire' , function(){
                    return response()->json(['message'=>'gestionnaire vous avez connect??','status'=>200],200);
                });
         });
});

