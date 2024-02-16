<?php

use App\Http\Controllers\MealController;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


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















    

// Route::get('/search', function (Request $request) {
//     $meal = Meal::latest()->filter(request(['q']))->paginate(12);
//     return response()->json($meal);
// });


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
