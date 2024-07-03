<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MealController;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

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



Route::get('meal', [MealController::class, 'index'])->name('home');

Route::get('meal/{meal}', [MealController::class, 'show'])
    ->missing(fn () => response()->json([], 404));

// register
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

// Login
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Dashboard routes will go here

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->get('/admin', function);

Route::middleware(['auth:sanctum'])->get('admin', function(Request $request) {
    $user = auth()->user();

    if ($user->first_name !== 'test') {
        return response()->json(['not' => 'not authorized to make request'], 401);
    }

    return response()->json(['valid user' => 'redirect to admin panel']);
});