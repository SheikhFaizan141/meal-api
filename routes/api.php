<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\SocialAuthController;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

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
    ->missing(fn() => response()->json([], 404));

// register
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

// Login
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);



Route::middleware(['web'])->group(function () {
    Route::get('/auth/redirect', [SocialAuthController::class, 'authRedirect']);
    Route::get('/auth/callback', [SocialAuthController::class, 'authCallback']);
});


// Dashboard routes will go here

Route::middleware('auth:sanctum')->post('/user', function (Request $request) {
    $user = auth()->user();
    return response()->json(['data' => $user]);
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


Route::middleware('auth:sanctum')->post('/admin/meals', function (Request $request): JsonResponse {
    if (!Gate::allows('admin')) {
        return response()->json(["message" => "don't have proper permission to do this task"], 403);
    }

    // make slug 
    $request['slug'] = Str::slug($request->slug);

    $attributes = $request->validate([
        'name' => 'required',
        'slug' => ['required', Rule::unique('meals', 'slug')],
        'featured_img' =>  ['required', 'image', 'mimes:png,jpg', 'max:4000'],
        'title' => ['required', 'max:255'],
        'description' => 'required',
        'is_veg' => ['required', 'boolean'],
        'price' => 'required'
    ]);

    // add meal to file
    $attributes['featured_img'] = $request->file('featured_img')->store('featured-images');


    $meal = Meal::create($attributes);

    return response()->json($meal);
});


Route::middleware('auth:sanctum')->patch('/admin/meals/{meal}', function (Request $request, Meal $meal): JsonResponse {
    if (!Gate::allows('admin')) {
        return response()->json(["message" => "don't have proper permission to do this task"], 403);
    }

    // make slug 
    $request['slug'] = Str::slug($request->slug);

    $attributes = $request->validate([
        'name' => 'required',
        'slug' => ['required', Rule::unique('meals', 'slug')->ignoreModel($meal)],
        'featured_img' => ['image', 'mimes:png,jpg', 'max:5600'],
        'title' => ['required', 'max:255'],
        'description' => ['required'],
        'is_veg' => ['required', 'boolean'],
        'price' => ['required']
    ]);


    if ($attributes['featured_img'] ?? false) {
        $attributes['featured_img'] = $request->file('featured_img')->store('featured_imgs');
    }

    $meal->update($attributes);

    return response()->json(['success', 'Post Updated!']);
});


Route::middleware('auth:sanctum')->delete('/admin/meals/{meal}', function (Meal $meal): JsonResponse {

    if (!Gate::allows('admin')) {
        return response()->json(["message" => "don't have proper permission to do this task"], 403);
    }

    $meal->delete();

    return response()->json(['message', 'post deleted!']);
});


Route::get('/test', function () {
    $user = User::latest()->first();

    // $user->append('is_admin')->toArray();
    // dd($user);

    return response()->json($user);
});
