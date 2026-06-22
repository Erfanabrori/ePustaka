<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\KomentarController;
use App\Helpers\VigenereHelper;


Route::get('/', [AuthController::class, 'formLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'formRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware(['cek.login'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Bisa diakses semua user
    Route::get('/buku', [BukuController::class, 'index']);

    // Khusus admin
    Route::middleware(['cek.role'])->group(function () {

        Route::get('/buku/tambah', [BukuController::class, 'create']);
        Route::post('/buku/simpan', [BukuController::class, 'store']);

        Route::get('/buku/edit/{id}', [BukuController::class, 'edit']);
        Route::put('/buku/update/{id}', [BukuController::class, 'update']);

        Route::get('/buku/hapus/{id}', [BukuController::class, 'destroy']);

        Route::get('/buku/cetak/{id}', [BukuController::class, 'cetakBarcode']);
        Route::get('/buku/cetak-semua', [BukuController::class, 'cetakSemuaBarcode']);
    });

    Route::get('/peminjaman', [PeminjamanController::class, 'index']);
    Route::get('/peminjaman/tambah', [PeminjamanController::class, 'create']);
    Route::post('/peminjaman/simpan', [PeminjamanController::class, 'store']);
    Route::get('/peminjaman/kembali/{id}', [PeminjamanController::class, 'kembali']);

    /*
    |--------------------------------------------------------------------------
    | PROFIL USER
    |--------------------------------------------------------------------------
    */

    Route::get('/profil', function () {
        $user = \App\Models\User::findRaw(session('user_id'));
        if (!$user) {
            return redirect('/logout');
        }

        return view('profil', compact('user'));
    });

    Route::post('/profil/update', function (Request $request) {
        $user = \App\Models\User::findRaw(session('user_id'));
        if (!$user) {
            return redirect('/logout');
        }

        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'min:6|confirmed';
        }

        $request->validate($rules);

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

        \App\Models\User::updateRaw($user->id, [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $user->role,
            'foto' => $fotoName,
        ]);

        if ($request->filled('password')) {
            \App\Models\User::updatePasswordRaw($user->id, VigenereHelper::encrypt($request->password));
        }

        return back()->with('success', 'Profil berhasil diubah!');
    });

    /*
    |--------------------------------------------------------------------------
    | MENU USER
    |--------------------------------------------------------------------------
    */

    Route::middleware(['cek.role.user'])->group(function () {

        Route::get('/riwayat', [PeminjamanController::class, 'riwayat']);

        Route::get('/komentar', [KomentarController::class, 'index']);
        Route::post('/komentar', [KomentarController::class, 'store']);
        Route::get('/komentar/edit/{id}', [KomentarController::class, 'edit']);
        Route::post('/komentar/update/{id}', [KomentarController::class, 'update']);
        Route::get('/komentar/hapus/{id}', [KomentarController::class, 'destroy']);
        Route::get('/wishlist', [WishlistController::class, 'index']);
        Route::post('/wishlist/tambah', [WishlistController::class, 'store']);
        Route::get('/wishlist/hapus/{id}', [WishlistController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| KHUSUS ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['cek.login', 'cek.role'])->group(function () {

    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/tambah', [UserController::class, 'create']);
    Route::post('/user/simpan', [UserController::class, 'store']);
    Route::get('/user/edit/{id}', [UserController::class, 'edit']);
    Route::post('/user/update/{id}', [UserController::class, 'update']);
    Route::get('/user/hapus/{id}', [UserController::class, 'destroy']);
    Route::get('/user/cetak/{id}', [UserController::class, 'cetakKartu']);
    Route::get('/user/cetak-semua', [UserController::class, 'cetakSemuaKartu']);

    Route::get('/admin/komentar', [KomentarController::class, 'adminIndex']);
    Route::get('/admin/komentar/{id}', [KomentarController::class, 'adminShow']);
    Route::get('/admin/komentar/hapus/{id}', [KomentarController::class, 'adminDestroy']);

    Route::get('/laporan', [PeminjamanController::class, 'laporan']);
    Route::get('/laporan/cetak', [PeminjamanController::class, 'cetakLaporan']);
});

