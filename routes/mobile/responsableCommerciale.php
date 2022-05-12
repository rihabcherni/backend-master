<?php
    use Illuminate\Support\Facades\Route;

    use App\Http\Controllers\Auth\ResponsableCommercial\ResponsableCommercialController;
    Route::group(['prefix' => 'auth-responsable-commercial'], function () {
        Route::post('/register' , [ResponsableCommercialController::class , 'registerResponsableCommercial']);
        Route::post('/login',[ResponsableCommercialController::class, 'loginResponsableCommercial']);
        Route::post('/qrlogin/{email}',[AuthOuvrierController::class, 'qrlogin']);

            Route::group(['middleware'=>['auth:sanctum']], function() {
                Route::post('/logout',[ResponsableCommercialController::class, 'logoutResponsableCommercial']);
                        Route::post('/modifier-profile-responsable-commercial/{id}',[ResponsableCommercialController::class,'modifierProfileResponsableCommercial']);
                        Route::post('/modifier-responsable-commercial-password/{email}',[ResponsableCommercialController::class,'modifierPasswordResponsableCommercial']);
                        Route::post('/sendImage',[ResponsableCommercialController::class,'sendImage']);
                        Route::post('/destroyImage',[ResponsableCommercialController::class,'destroyImage']);
                        Route::post('/updateImage',[ResponsableCommercialController::class,'updateImage']);
                        Route::get('/conversation' , [ConversationController::class , 'index']);
                        Route::post('/conversation' , [ConversationController::class , 'store']);
                        Route::post('/conversation/checkConversation' , [ConversationController::class , 'checkConversation']);
                        Route::post('/conversation/read' , [ConversationController::class , 'makeConversationAsReaded']);
                        Route::post('/message' , [MessageController::class , 'store']);
                        Route::get('/allClient',[AuthClientDechetController::class,'allClientDechets']);
                Route::get('/profile' , function(){
                    return auth()->guard('responsable_commercial')->user();
                });
            });
    });
