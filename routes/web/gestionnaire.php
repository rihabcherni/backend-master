<?php

    use App\Http\Controllers\Auth\Gestionnaire\AuthGestionnaireController;
    use Illuminate\Support\Facades\Route;

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

                });

                Route::get('/checkingAuthGestionnaire' , function(){
                    return response()->json(['message'=>'gestionnaire vous avez connecté','status'=>200],200);
                });
         });
});

