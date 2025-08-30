<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    public function redirect(string $provider)
    {
        abort_unless(in_array($provider, ['google','facebook']), 404);
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName() ?: $socialUser->getNickname() ?: 'User'.Str::random(6),
                'password' => bcrypt(Str::random(32)),
            ]
        );

        if ($user->roles()->count() === 0) {
            $user->assignRole('User'); // default role
        }

        auth()->login($user, true);

        return redirect()->route('home');
    }
}
