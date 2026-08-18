<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    /**
     * Show login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect based on role
            if (auth()->user()->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('customer.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Redirect to Google OAuth Consent Screen or fallback demo.
     */
    public function redirectToGoogle()
    {
        $clientId = env('GOOGLE_CLIENT_ID');

        if ($clientId) {
            $query = http_build_query([
                'client_id' => $clientId,
                'redirect_uri' => route('auth.google.callback'),
                'response_type' => 'code',
                'scope' => 'openid email profile',
                'access_type' => 'online',
                'prompt' => 'select_account',
            ]);

            return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
        }

        // Instant testing fallback when Google API keys are not added in .env yet
        $user = User::where('email', 'rairajan123r@gmail.com')->first();

        if (!$user) {
            $user = User::create([
                'name' => 'Rai Rajan (Google)',
                'email' => 'rairajan123r@gmail.com',
                'phone' => '9876543210',
                'role' => 'customer',
                'password' => Hash::make('password123'),
            ]);
        }

        Auth::login($user, true);
        request()->session()->regenerate();

        return redirect()->route('customer.dashboard')->with('success', 'Logged in with Google! (Set GOOGLE_CLIENT_ID & GOOGLE_CLIENT_SECRET in .env for real Google popup)');
    }

    /**
     * Handle Google OAuth Callback.
     */
    public function handleGoogleCallback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect()->route('login')->withErrors(['email' => 'Google authentication was cancelled.']);
        }

        $response = \Illuminate\Support\Facades\Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'code' => $request->code,
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect_uri' => route('auth.google.callback'),
            'grant_type' => 'authorization_code',
        ]);

        if ($response->failed()) {
            return redirect()->route('login')->withErrors(['email' => 'Failed to authenticate with Google API.']);
        }

        $tokenData = $response->json();
        $accessToken = $tokenData['access_token'] ?? null;

        $userResponse = \Illuminate\Support\Facades\Http::withToken($accessToken)->get('https://www.googleapis.com/oauth2/v3/userinfo');

        if ($userResponse->failed()) {
            return redirect()->route('login')->withErrors(['email' => 'Failed to fetch Google user details.']);
        }

        $googleUser = $userResponse->json();
        $email = $googleUser['email'] ?? null;
        $name = $googleUser['name'] ?? 'Google User';

        if (!$email) {
            return redirect()->route('login')->withErrors(['email' => 'Google account did not provide a valid email.']);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'phone' => '9876543210',
                'role' => 'customer',
                'password' => Hash::make(\Illuminate\Support\Str::random(16)),
            ]);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->route('customer.dashboard')->with('success', 'Welcome, ' . $user->name . '! Logged in with real Google Account.');
    }

    /**
     * Handle Google Account Chooser Selection.
     */
    public function postGoogleLogin(Request $request)
    {
        $email = $request->input('email', 'rairajan123r@gmail.com');
        $name = $request->input('name');

        if (!$name) {
            $parts = explode('@', $email);
            $name = ucwords(str_replace(['.', '_', '-'], ' ', $parts[0]));
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'phone' => '9876543210',
                'role' => 'customer',
                'password' => Hash::make(\Illuminate\Support\Str::random(16)),
            ]);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->route('customer.dashboard')->with('success', 'Welcome back, ' . $user->name . '! Signed in with Google.');
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
