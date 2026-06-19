<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data = User::allRaw();
        return view('user.index', compact('data'));
    }

    public function create()
    {
        return view('user.tambah');
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/user');
    }

    public function edit($id)
    {
        $user = User::findRaw($id);
        if (!$user) abort(404);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findRaw($id);
        if (!$user) abort(404);

        $data = [
            'name' => $request->name,
            'email' => $request->email
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect('/user');
    }

    public function destroy($id)
    {
        $u = User::findRaw($id);
        if (!$u) abort(404);
        $u->delete();
        return redirect('/user');
    }

    // CETAK KARTU ANGGOTA SATU
    public function cetakKartu($id)
    {
        $user = User::findRaw($id);
        if (!$user) abort(404);
        return view('admin.kartu_anggota', compact('user'));
    }

    // CETAK SEMUA KARTU ANGGOTA
    public function cetakSemuaKartu()
    {
        $data = User::allByRoleRaw('user');
        return view('admin.kartu_semua', compact('data'));
    }
}
