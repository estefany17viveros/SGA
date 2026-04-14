<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\LoginLog;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar vista de login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Procesar login
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 🔐 Autenticar usuario
        $request->authenticate();

        // 👤 Usuario autenticado
        $user = Auth::user();

        // 🔴 VALIDAR SI ESTÁ INACTIVO
        if (!$user->is_active) {
            Auth::logout();

            return back()->withErrors([
                'email' => '❌ Este usuario está inactivo, contacte al administrador'
            ])->onlyInput('email');
        }

        // 🔄 regenerar sesión
        $request->session()->regenerate();

       

        // 🚀 Redirigir
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Cerrar sesión
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}