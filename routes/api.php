<?php

use Illuminate\Http\Request;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CatracaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum','abilities:catraca')->get('/catraca', [CatracaController::class,'sendData']);*/

    
Route::group(['middleware' => []], function () {
    /*Route::get('catraca',function(){
        return response()->json(['message' => 'Catraca API is working'], 200);
    })->withoutMiddleware(\App\Http\Middleware\TrustHosts::class);*/
    Route::get('catraca', [CatracaController::class, 'sendData']);
    Route::post('catraca', [CatracaController::class, 'importData']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
route::get('tag/{tag}/{key}', [TagController::class,'tagAccess']);

//Banking Payment Notification
//Route::POST('BPN', [IntegracaoBBController::class,'notificacaoPagamento']);