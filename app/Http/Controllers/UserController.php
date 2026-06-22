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
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $fotoName = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $folder = public_path('uploads/profiles');
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $fotoName = uniqid('foto_') . '.' . $file->getClientOriginalExtension();
            $file->move($folder, $fotoName);
        }

        User::insertRaw([
            'name' => $request->name,
            'email' => $request->email,
            'password' => VigenereHelper::encrypt($request->password),
            'role' => 'user',
            'foto' => $fotoName,
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

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $fotoName = $user->foto;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $folder = public_path('uploads/profiles');
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $newFotoName = uniqid('foto_') . '.' . $file->getClientOriginalExtension();
            $file->move($folder, $newFotoName);

            if ($fotoName && file_exists($folder . '/' . $fotoName)) {
                @unlink($folder . '/' . $fotoName);
            }
            $fotoName = $newFotoName;
        }

        User::updateRaw($id, [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $user->role,
            'foto' => $fotoName,
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
