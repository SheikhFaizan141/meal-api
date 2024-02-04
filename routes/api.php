<?php

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

use function PHPUnit\Framework\isNull;

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

Route::get('/meal', function (Request $request) {
    $page = $request->query('page');

    if (!is_null($page) ) {
        if (!is_numeric($page)) {
            return response()->json($data = [], $status = '404');
        } 
    } 

    $pagination = Meal::latest()->paginate(12);
    if ($pagination->isEmpty()) {
        return response()->json($data = [], $status = '404');
    }

    return response()->json($pagination);
});

Route::get('/meal/{id}', function (Meal $id) {
    return response()->json($id);
})->missing(fn () => response()->json([], 404));

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
