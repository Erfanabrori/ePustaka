<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function formLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = \App\Models\User::findByEmailRaw($request->email);

        if ($user && Hash::check($request->password, $user->password)) {

            session([
                'user_id' => $user->id,
                'nama' => $user->name,
                'role' => $user->role
            ]);

            return redirect('/dashboard');
        }

        return back()->with('error', 'Login gagal');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }

    public function formRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user'
        ]);

        return redirect('/')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}
