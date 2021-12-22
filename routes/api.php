<?php

use App\Http\Controllers\PhotoController;
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
    Route::get("photos", [PhotoController::class, "index"])->name("photos.index");
    Route::post("photos", [PhotoController::class, "store"])->name("photos.store");
    Route::delete("photo/{photo}", [PhotoController::class, "destroy"])->name("photos.destroy");
});
