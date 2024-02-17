<?php

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


// Login
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();


        return response()->json(['message' => "welcome back"]);
    }

    return response()->json(['email' => 'The provided credentials do not match our records.'], 401);
});


Route::post('/signup', function (Request $request) {
    $attributes = $request->validate([
        'name' => ['required'],
        // 'email' => ['required', 'email', 'unique:users,email'],
        'email' => ['required', 'email', Rule::unique('users', 'email')],
        'password' => ['required', 'min:3']
    ]);


    $user = User::create($attributes);

    Auth::login($user);

    return response()->json(['message' => 'user created']);
});

Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    // Auth::logout();

    $request->session()->invalidate();
 
    $request->session()->regenerateToken();
    
    return response()->json(['message' => 'user is loged out']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->get('/admin', function);