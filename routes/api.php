<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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




// Route::post('/products', [ProductController::class, 'store']);

// Route::get('/products/search/{search}',[ProductController::class, 'search']);
//
// Route::get('/products/{product}',[ProductController::class, 'show']);
// Route::resource('products', ProductController::class);


// Route::middleware('auth:sanctum')->get('/products/search/{search}',function(Request $request){
//  return $request->user();
// });

//unprotected routes

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/products',[ProductController::class, 'index']);
Route::get('/products/{product}',[ProductController::class, 'show']);


//protected routes
Route::group(['middleware' => 'auth:sanctum'], function(){

    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);

});


