<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeminjamanController;


Route::get('/', [AuthController::class, 'formLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'formRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);


Route::middleware(['cek.login'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Buku bisa diakses semua user (admin & user biasa)
    Route::get('/buku', [BukuController::class, 'index']);

    // Route buku admin (tambah, edit, hapus)
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

    Route::get('/profil', function () {
        // Hanya user biasa yang bisa akses profil
        if (session('role') === 'admin') {
            return redirect('/dashboard');
        }
        $user = \App\Models\User::find(session('user_id'));
        return view('profil', compact('user'));
    });

    Route::post('/profil/update', function (Request $request) {
        // Hanya user biasa yang bisa update profil
        if (session('role') === 'admin') {
            return redirect('/dashboard');
        }

        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $user = \App\Models\User::find(session('user_id'));
        $user->update([
            'password' => bcrypt($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    });

    // MENU USER (Riwayat Transaksi, Komentar, Wishlist)
    Route::middleware(['cek.role.user'])->group(function () {
        Route::get('/riwayat', [PeminjamanController::class, 'riwayat']);
        Route::get('/komentar', [KomentarController::class, 'index']);
        Route::post('/komentar', [KomentarController::class, 'store']);
        Route::get('/komentar/hapus/{id}', [KomentarController::class, 'destroy']);
        Route::get('/wishlist', [WishlistController::class, 'index']);
        Route::post('/wishlist/tambah', [WishlistController::class, 'store']);
        Route::get('/wishlist/hapus/{id}', [WishlistController::class, 'destroy']);
    });

});


Route::middleware(['cek.login', 'cek.role'])->group(function () {

    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/tambah', [UserController::class, 'create']);
    Route::post('/user/simpan', [UserController::class, 'store']);
    Route::get('/user/edit/{id}', [UserController::class, 'edit']);
    Route::post('/user/update/{id}', [UserController::class, 'update']);
    Route::get('/user/hapus/{id}', [UserController::class, 'destroy']);
    Route::get('/user/cetak/{id}', [UserController::class, 'cetakKartu']);
    Route::get('/user/cetak-semua', [UserController::class, 'cetakSemuaKartu']);
    Route::get('/laporan', [PeminjamanController::class, 'laporan']);
    Route::get('/laporan/cetak', [PeminjamanController::class, 'cetakLaporan']);

});
