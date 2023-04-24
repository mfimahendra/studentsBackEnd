<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PassportAuthController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PublicController;


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
 
Route::post('/register', [PassportAuthController::class, 'register']);
Route::post('/login', [PassportAuthController::class, 'login']);
  
Route::middleware('auth:api')->group(function () {
    Route::get('/user', [PassportAuthController::class, 'userInfo']);    
    Route::post('/logout', [PassportAuthController::class, 'logout']);

    
    Route::resource('region', RegionController::class);
    Route::resource('university', UniversityController::class);
    Route::resource('city', CityController::class);
    
    Route::resource('student', StudentController::class);
    
});

// route group prefix student
Route::group(['prefix' => 'student'], function() {
    Route::post('/check', [StudentController::class, 'studentCheck']);
});



// route group prefix api
Route::group(['prefix' => 'public'], function () {
    Route::get('/total_resume', [PublicController::class, 'index']);
    Route::get('/region', [RegionController::class, 'index']);

    Route::get('/university', [UniversityController::class, 'index']);
    Route::get('/university/{city}', [UniversityController::class, 'indexCity']);
    Route::get('/city', [CityController::class, 'index']);
    Route::get('/city/{region}', [CityController::class, 'indexRegion']);
});






