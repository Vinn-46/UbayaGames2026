<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'username' => ['required'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        $user = Auth::user();

        // cek role user
        if ($user->role === 'Sekretariat') {
            return redirect()->route('teamlist.sekre');
        }

        if ($user->role === 'Kontingen') {
            return redirect()->route('teamlist');
        }

        // fallback
        return redirect('/');
    }

    return back()->withErrors([
        'username' => 'Username atau password salah!',
    ])->onlyInput('username');
}
}