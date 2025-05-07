<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();


    // Redirection basée sur le rôle de l'utilisateur
    $role = Auth::user()->role; // Récupérer le rôle de l'utilisateur

    return match ($role) {
        'admin' => redirect()->route('dashboard'),  // Redirection vers le dashboard de l'admin
        'agriculteur' => redirect()->route('produits.index'), // Redirection vers le dashboard de l'agriculteur
        // default => redirect()->route('home'),  // Redirection par défaut
    };    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
