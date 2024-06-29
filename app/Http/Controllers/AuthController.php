<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{

    // register
    public function register(Request $request): JsonResponse
    {
        $attributes = $request->validate([
            'name' => ['required'],
            // 'email' => ['required', 'email', 'unique:users,email'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:3']
        ]);
    
    
        $user = User::create($attributes);
    
        Auth::login($user);
    
        return response()->json(['message' => 'user created']);
    }

    // login user
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();


            return response()->json(['message' => "welcome back"]);
        }

        return response()->json(['email' => 'The provided credentials do not match our records.'], 401);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();
        // Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['message' => 'user is loged out']);
    }
}
