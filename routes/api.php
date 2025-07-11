<?php

use Illuminate\Http\Request;
use App\Http\Controllers\TagController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
route::get('tag/{tag}/{key}', [TagController::class,'tagAccess']);

//Banking Payment Notification
//Route::POST('BPN', [IntegracaoBBController::class,'notificacaoPagamento']);