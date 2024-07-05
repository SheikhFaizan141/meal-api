<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MealController;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

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

Route::middleware('auth:sanctum')->get('/admin', function (Request $request): JsonResponse {
    if (Gate::denies('admin')) {
        return response()->json(['message' => 'not authorized to make request'], 403);
    }

    return response()->json(['message' => 'redirect to admin panel']);
});


Route::middleware('auth:sanctum')->get('/admin/meals', function (): JsonResponse {
    if (Gate::denies('admin')) {
        return response()->json(['message' => 'not authorized to make request'], 403);
    }


    $meal = Meal::latest()->paginate(10);
    if ($meal->isEmpty()) {
        return response()->json($data = []);
    }


    return response()->json($meal);
});


Route::middleware('auth:sanctum')->post('/admin/meal', function (Request $request): JsonResponse {
    if (!Gate::allows('admin')) {
        return response()->json(["message" => "don't have proper permission to do this task"], 403);
    }

    // make slug 
    $request['slug'] = Str::slug($request->slug);

    $attributes = $request->validate([
        'name' => 'required',
        'slug' => ['required', Rule::unique('meals', 'slug')],
        'featured_img' =>  ['required', 'image', 'mimes:png,jpg', 'max:4000'],
        'title' => ['required', 'max:255', ''],
        'description' => 'required',
        'is_veg' => ['required', 'boolean'],
        'price' => 'required'
    ]);

    // add meal to file
    $attributes['featured_img'] = request()->file('featured_img')->store('featured-images');

    
    $meal = Meal::create($attributes);

    return response()->json($meal);
});
