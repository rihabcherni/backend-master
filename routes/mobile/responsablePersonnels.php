<?php
    use Illuminate\Support\Facades\Route;

    use App\Http\Controllers\Auth\ResponsablePersonnel\ResponsablePersonnelController;

    use App\Http\Controllers\ConversationController;
    use App\Http\Controllers\MessageController;

    Route::group(['prefix' => 'auth-responsable-personnel'], function () {
        Route::post('/register' , [ResponsablePersonnelController::class , 'registerResponsableCommercial']);
        Route::post('/login',[ResponsablePersonnelController::class, 'loginResponsableCommercial']);
        Route::post('/qrlogin/{email}',[AuthOuvrierController::class, 'qrlogin']);

            Route::group(['middleware'=>['auth:sanctum']], function() {
                Route::post('/logout',[ResponsablePersonnelController::class, 'logoutResponsableCommercial']);
                        Route::post('/modifier-profile-responsable-commercial/{id}',[ResponsablePersonnelController::class,'modifierProfileResponsableCommercial']);
                        Route::post('/modifier-responsable-commercial-password/{email}',[ResponsablePersonnelController::class,'modifierPasswordResponsableCommercial']);
                        Route::post('/sendImage',[ResponsablePersonnelController::class,'sendImage']);
                        Route::post('/destroyImage',[ResponsablePersonnelController::class,'destroyImage']);
                        Route::post('/updateImage',[ResponsablePersonnelController::class,'updateImage']);

                        Route::get('/conversation' , [ConversationController::class , 'index']);
                        Route::post('/conversation' , [ConversationController::class , 'store']);
                        Route::post('/conversation/read' , [ConversationController::class , 'makeConversationAsReaded']);
                        Route::post('/message' , [MessageController::class , 'store']);

                        Route::get('/allClient',[AuthClientDechetController::class,'allClientDechets']);
                Route::get('/profile' , function(){
                    return auth()->guard('responsable_commercial')->user();
                });
            });
    });
