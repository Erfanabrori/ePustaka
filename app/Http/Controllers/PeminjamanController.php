<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;

class PeminjamanController extends Controller
{
    public function index()
    {
        $user = User::findRaw(session('user_id'));
        $role = session('role');

        if (!$user) {
            return redirect('/login');
        }

        if ($role == 'admin') {
            $data = Peminjaman::allWithRelations();
        } else {
            $data = Peminjaman::forUser($user->id);
        }

        return view('peminjaman.index', compact('data', 'user', 'role'));
    }

    public function create(Request $request)
    {
        $buku = Buku::allRaw();
        $selected = $request->buku_id;

        return view('peminjaman.tambah', compact('buku', 'selected'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
        ]);

        $buku = Buku::findRaw($request->buku_id);
        if (!$buku) abort(404);

        // 🔥 CEK STOK
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis');
        }

        // 🔥 KURANGI STOK
        Buku::updateRaw($request->buku_id, [
            'judul_buku' => $buku->judul_buku,
            'isbn' => $buku->isbn,
            'tahun_terbit' => $buku->tahun_terbit,
            'jumlah_halaman' => $buku->jumlah_halaman,
            'penerbit_id' => $buku->penerbit_id,
            'tempat_terbit' => $buku->tempat_terbit,
            'edisi' => $buku->edisi,
            'deskripsi' => $buku->deskripsi,
            'stok' => $buku->stok - 1
        ]);

        // 🔥 SIMPAN PEMINJAMAN
        Peminjaman::insertRaw([
            'user_id' => session('user_id'),
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => now()
        ]);

        return redirect('/peminjaman')->with('success', 'Peminjaman berhasil');
    }

    public function kembali(int $id)
    {
        $data = Peminjaman::findRaw($id);
        if (!$data) abort(404);
        $user = User::findRaw(session('user_id'));

        if (!$user) {
            return redirect('/login');
        }

        if ($user->role != 'admin' && $data->user_id != $user->id) {
            abort(403);
        }

        // 🔥 CEK JANGAN DOUBLE KEMBALI
        if ($data->tanggal_kembali) {
            return back()->with('error', 'Buku sudah dikembalikan');
        }

        // 🔥 TAMBAH STOK
        $buku = Buku::findRaw($data->buku_id);
        if ($buku) {
            Buku::updateRaw($data->buku_id, [
                'judul_buku' => $buku->judul_buku,
                'isbn' => $buku->isbn,
                'tahun_terbit' => $buku->tahun_terbit,
                'jumlah_halaman' => $buku->jumlah_halaman,
                'penerbit_id' => $buku->penerbit_id,
                'tempat_terbit' => $buku->tempat_terbit,
                'edisi' => $buku->edisi,
                'deskripsi' => $buku->deskripsi,
                'stok' => $buku->stok + 1
            ]);
        }

        // 🔥 UPDATE STATUS KEMBALI
        Peminjaman::updateRaw($id, [
            'user_id' => $data->user_id,
            'buku_id' => $data->buku_id,
            'tanggal_pinjam' => $data->tanggal_pinjam,
            'tanggal_kembali' => now()
        ]);

        return redirect('/peminjaman')->with('success', 'Buku dikembalikan');
    }

    public function riwayat()
    {
        $user = User::findRaw(session('user_id'));

        $riwayat = Peminjaman::forUser($user->id);

        return view('user.riwayat', compact('riwayat', 'user'));
    }

    public function laporan(Request $request)
    {
        $data = Peminjaman::report($request->bulan, $request->tahun);
        $users = \App\Models\User::allByRoleRaw('user');

        return view('admin.laporan', compact('data', 'users'));
    }

    public function cetakLaporan(Request $request)
    {
        $data = Peminjaman::report($request->bulan, $request->tahun);

        return view('admin.laporan_cetak', compact('data'));
    }
}
