<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/auth/redirect', function (Request $request) {
//     $originalUrl = $request->input('redirect_to', Env::get('FRONTEND_URL'));
//     $url = Socialite::driver('github')
//         ->with(['state' => urlencode($originalUrl)])
//         ->redirect()
//         ->getTargetUrl();

//     return response()->json(['url' => $url]);
// });


// Route::get('/auth/callback', function (Request $request) {
//     $user = Socialite::driver('github')->stateless()->user();

//     Log::debug('An informational message.');

//     $authUser = User::firstOrCreate([
//         'email' => $user->email,
//     ], [
//         'first_name' => explode(' ', $user->name, 2)[0],
//         'last_name' => explode(' ', $user->name, 2)[1] ?? ' ',
//         'email' => $user->email,
//         'password' => Str::password(8),
//     ]);

//     Auth::login($authUser, true);
//     $redirectTo = urldecode($request->input('state', '/'));

//     return redirect($redirectTo);
// });
