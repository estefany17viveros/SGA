<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [

            'current_password' => ['required', 'current_password'],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',

                // Mayúscula
                'regex:/[A-Z]/',

                // Minúscula
                'regex:/[a-z]/',

                // Mínimo 5 números
                'regex:/(\d.*){5,}/',

                // Carácter especial
                'regex:/[@$!%*#?&]/',
            ],

        ], [
            // Mensajes personalizados
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',

            'password.regex' => 'La contraseña debe contener al menos: 1 mayúscula, 1 minúscula, 5 números y 1 carácter especial.',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}