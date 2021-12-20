<?php

use App\Http\Controllers\FotoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware("api")->group(function () {
    // Route::get('fotos', FotosController::class);
    Route::post("fotos", [FotoController::class, "store"])->name("fotos.store");
    Route::delete("foto/{foto}", [FotoController::class, "destroy"])->name("fotos.destroy");
});
