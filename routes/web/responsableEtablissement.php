<?php

    use App\Http\Controllers\API\ResponsableEtablissement\ResponsableController;
    use App\Http\Controllers\Auth\ResponsableEtablissement\AuthResponsableEtablissementController;
    use Illuminate\Support\Facades\Route;

    Route::group(['prefix' =>'auth-responsable-etablissement'], function () {
        Route::post('/register',[AuthResponsableEtablissementController::class,'registerResponsableEtablissement']);
        Route::post('/login',[AuthResponsableEtablissementController::class, 'loginResponsableEtablissement']);

        Route::group(['middleware'=>['auth:sanctum']], function() {
                    Route::group(['middleware' => 'auth:responsable_etablissement'], function() {
                        Route::post('/logout',[AuthResponsableEtablissementController::class, 'logoutResponsable']);
                        Route::post('/modifier-profile-client-dechet/{id}',[AuthResponsableEtablissementController::class,'modifierProfileResponsableEtablissement']);
                        Route::post('/modifier-client-dechet-password/{email}',[AuthResponsableEtablissementController::class,'modifierPasswordResponsableEtablissement']);
                        Route::post('/send',[AuthResponsableEtablissementController::class,'send']);
                        Route::get('/commande-responsable',[ResponsableController::class,'ResponsabelCommande']);

                        Route::get('/profile' , function(){
                            return auth()->guard('responsable_etablissement')->user();
                        });
                    });
                        Route::get('/checkingAuthResponsable' , function(){
                            return response()->json(['message'=>'Responsable etablissement vous avez connecté','status'=>200],200);
                        });
        });
    });
