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
 
Route::post('/register', [PassportAuthController::class, 'register'])->name('register');
Route::post('/login', [PassportAuthController::class, 'login'])->name('login');
  
Route::middleware('auth:api')->group(function () {
    Route::get('/user', [PassportAuthController::class, 'userInfo'])->name('user');    
    Route::post('/logout', [PassportAuthController::class, 'logout'])->name('logout');

    
    Route::resource('region', RegionController::class);
    Route::resource('university', UniversityController::class);
    Route::resource('city', CityController::class);
    
    Route::resource('student', StudentController::class);
    
});

// route group prefix student
Route::group(['prefix' => 'student'], function() {
    Route::post('/check', [StudentController::class, 'studentCheck'])->name('studentCheck');
    Route::post('/register', [StudentController::class, 'store'])->name('studentRegister');
});



// route group prefix api
Route::group(['prefix' => 'public'], function () {
    Route::get('/total_resume', [PublicController::class, 'index'])->name('totalResume');
    Route::get('/region', [RegionController::class, 'index'])->name('regionIndex');

    Route::get('/university', [UniversityController::class, 'index'])->name('universityIndex');
    Route::get('/university/{city}', [UniversityController::class, 'indexCity'])->name('universityIndexCity');
    Route::get('/city', [CityController::class, 'index'])->name('cityIndex');
    Route::get('/city/{region}', [CityController::class, 'indexRegion'])->name('cityIndexRegion');
    
});






