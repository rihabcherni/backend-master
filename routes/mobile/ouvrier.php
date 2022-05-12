<?php
    use Illuminate\Support\Facades\Route;

    use App\Http\Controllers\API\Dashboard\RegionController;
    use App\Http\Controllers\Auth\Ouvrier\AuthOuvrierController;

    Route::group(['prefix' => 'auth-ouvrier'], function () {
        Route::post('/register' , [AuthOuvrierController::class , 'registerOuvrier']);
        Route::post('/login',[AuthOuvrierController::class, 'loginOuvrier']);
        Route::post('/qrlogin/{email}',[AuthOuvrierController::class, 'qrlogin']);

        Route::group(['middleware'=>['auth:sanctum']], function() {
                Route::group(['middleware' => 'auth:ouvrier'], function() {
                    Route::post('/logout',[AuthOuvrierController::class, 'logoutOuvrier']);
                    Route::post('/modifier-profile-ouvrier/{id}',[AuthOuvrierController::class,'modifierProfileOuvrier']);
                    Route::post('/modifier-ouvrier-password/{email}',[AuthOuvrierController::class,'modifierPasswordOuvrier']);
                    Route::post('/sendImage',[AuthOuvrierController::class,'sendImage']);
                    Route::post('/destroyImage',[AuthOuvrierController::class,'destroyImage']);
                    Route::post('/updateImage',[AuthOuvrierController::class,'updateImage']);
                    Route::get('/camion',[RegionController::class, 'OuvrierCamion']);
                    Route::get('/conversation' , [ConversationController::class , 'index']);
                    Route::post('/conversation' , [ConversationController::class , 'store']);
                    Route::post('/conversation/checkConversation' , [ConversationController::class , 'checkConversation']);
                    Route::post('/conversation/read' , [ConversationController::class , 'makeConversationAsReaded']);
                    Route::post('/message' , [MessageController::class , 'store']);
                    Route::get('/profile' , function(){
                        return auth()->guard('ouvrier')->user();
                    });
                });
        });
    });
