<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use Illuminate\Http\Request;

class LoginLogController extends Controller
{
    public function index(Request $request)
    {
        $query = LoginLog::query();

        // 🔍 FILTRO POR FECHA (SOLO DESDE SI SE USA)
        if ($request->filled('from') && !$request->filled('to')) {
            $query->whereDate('login_at', $request->from);
        }

        // 🔍 FILTRO NORMAL (SI USA AMBOS)
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereDate('login_at', '>=', $request->from);
            $query->whereDate('login_at', '<=', $request->to);
        }

        // 🔍 SOLO HASTA (por si acaso)
        if (!$request->filled('from') && $request->filled('to')) {
            $query->whereDate('login_at', '<=', $request->to);
        }

        // 🔥 ORDEN + PAGINACIÓN
        $logs = $query->latest()->paginate(10)->withQueryString();

        return view('admin.login-logs.index', compact('logs'));
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();

            return back()->withErrors([
                'email' => '❌ Este usuario está inactivo, contacte al administrador'
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        // ❌ NO GUARDAR LOG AQUÍ

        return redirect()->intended(route('dashboard'));
    }
}