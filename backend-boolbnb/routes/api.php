<?php

use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\FilterController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\StatisticController;
use App\Models\Apartment;
use App\Models\Category;
use App\Models\Service;
use App\Models\Session as ModelsSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use function PHPSTORM_META\map;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Filter routes
Route::get('apartments/filter', [FilterController::class, 'index']);

// Message routes
Route::post('/messages', [MessageController::class, 'store']);

// Statistic routes
Route::post('/views', [ViewController::class, 'store']);

// Apartments routes
Route::get('apartments/promoted', [ApartmentController::class, 'promoted']);
Route::get('apartments/random', [ApartmentController::class, 'random']);
Route::apiResource('apartments', ApartmentController::class);


// Categories route
Route::get('/categories',  function () {
    $categories = Category::all();
    return response()->json($categories);
});

// Services route
Route::get('/services',  function () {
    $services = Service::all();
    return response()->json($services);
});

// User route
Route::get('/user', function () {
    $user = ModelsSession::select('user_id')->get();
    $userTarget = User::where('id', '=', $user[0]['user_id'])->get();
    //$user = Session::all();
    return response()->json($userTarget);
});
