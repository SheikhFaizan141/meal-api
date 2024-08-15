<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;


class SocialAuthController extends Controller
{
    private $providers = ['github', 'google', 'microsoft'];

    public function authRedirect(Request $request)
    {
        // check is provider is valid 
        // $valid = in_array('g', $this->providers);

        // var_dump($valid);
        // Log::debug("message", [$valid]);

        $originalUrl = $request->input('redirect_to', Env::get('FRONTEND_URL'));
        $url = Socialite::driver('github')
            ->with(['state' => urlencode($originalUrl)])
            ->redirect()
            ->getTargetUrl();

        return response()->json(['url' => $url]);
    }

    public function authCallback(Request $request)
    {
        $user = Socialite::driver('github')->stateless()->user();

        Log::debug('An informational message.');

        $authUser = User::firstOrCreate([
            'email' => $user->email,
        ], [
            'first_name' => explode(' ', $user->name, 2)[0],
            'last_name' => explode(' ', $user->name, 2)[1] ?? ' ',
            'email' => $user->email,
            'password' => Str::password(8),
        ]);

        Auth::login($authUser, true);
        $redirectTo = urldecode($request->input('state', '/'));

        return redirect($redirectTo);
    }
}
