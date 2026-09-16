<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show split login/register card.
     */
    public function showLoginForm(Request $request): View
    {
        $initialTab = $request->query('tab', 'login');

        return view('auth.login', compact('initialTab'));
    }

    /**
     * Process user login.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Migrate session cart items to user
            $sessionId = session()->getId();
            CartItem::where('session_id', $sessionId)
                ->whereNull('user_id')
                ->update(['user_id' => Auth::id()]);

            return redirect()->intended(route('home'))->with('success', '¡Bienvenido de vuelta a Kinetic Sports!');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email')->with('tab', 'login');
    }

    /**
     * Process user registration.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        // Migrate session cart items to user
        $sessionId = session()->getId();
        CartItem::where('session_id', $sessionId)
            ->whereNull('user_id')
            ->update(['user_id' => $user->id]);

        return redirect()->route('home')->with('success', '¡Cuenta creada exitosamente! Disfruta de tu 15% de descuento con el cupón KINETIC15.');
    }

    /**
     * Log user out.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('info', 'Has cerrado sesión.');
    }
}
