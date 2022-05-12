<?php

    use App\Http\Controllers\API\ClientDechet\ClientDechetController;
    use App\Http\Controllers\Auth\ClientDechet\AuthClientDechetController;
    use Illuminate\Support\Facades\Route;

    use App\Http\Controllers\ConversationController;
    use App\Http\Controllers\MessageController;

    Route::group(['prefix' => 'auth-client-dechet'], function () {

        Route::post('/register' , [AuthClientDechetController::class , 'registerClientDechet']);
        Route::post('/login',[AuthClientDechetController::class, 'loginClientDechet']);
        Route::group(['middleware'=>['auth:sanctum']], function() {
                Route::group(['middleware' => 'auth:client_dechet'], function() {
                    Route::post('/logout',[AuthClientDechetController::class, 'logoutClientDechet']);

                    Route::post('/modifier-profile-client-dechet/{id}',[AuthClientDechetController::class,'modifierProfileClientDechet']);
                    Route::post('/modifier-client-dechet-password/{email}',[AuthClientDechetController::class,'modifierPasswordClientDechet']);
                    Route::post('/send',[AuthClientDechetController::class,'send']);

                    Route::get('/commande-client',[ClientDechetController::class,'ClientCommande']);

                    Route::get('/conversation' , [ConversationController::class , 'index']);
                    Route::post('/conversation' , [ConversationController::class , 'store']);
                    Route::post('/conversation/read' , [ConversationController::class , 'makeConversationAsReaded']);
                    Route::post('/message' , [MessageController::class , 'store']);

                    Route::get('/profile' , function(){
                        return auth()->guard('client_dechet')->user();
                    });
                });
        });
});

