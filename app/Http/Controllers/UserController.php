<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\VigenereHelper;


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
        User::insertRaw([
            'name' => $request->name,
            'email' => $request->email,
            'password' => VigenereHelper::encrypt($request->password),
            'role' => 'user'
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

        User::updateRaw($id, [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $user->role
        ]);

        if ($request->password) {
            User::updatePasswordRaw($id, VigenereHelper::encrypt($request->password));
        }

        return redirect('/user');
    }

    public function destroy($id)
    {
        $u = User::findRaw($id);
        if (!$u) abort(404);
        User::deleteRaw($id);
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
