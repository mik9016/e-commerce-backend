<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ItemController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('items', ItemController::class);
Route::middleware(['cors'])->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'checkout']);
    Route::post('/test', function(Request $request){
        Log::info($request);
        $response = ["message" => "OK"];
        return $response;
    });
});
