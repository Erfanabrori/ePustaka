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
        $user = User::find(session('user_id'));
        $role = session('role');

        if (!$user) {
            return redirect('/login');
        }

        if ($role == 'admin') {
            $data = Peminjaman::with('buku', 'user')->get();
        } else {
            $data = Peminjaman::with('buku')
                ->where('user_id', $user->id)
                ->get();
        }

        return view('peminjaman.index', compact('data', 'user', 'role'));
    }

    public function create(Request $request)
    {
        $buku = Buku::all();
        $selected = $request->buku_id;

        return view('peminjaman.tambah', compact('buku', 'selected'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
        ]);

        Peminjaman::create([
            'user_id' => session('user_id'),
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => now()
        ]);

        return redirect('/peminjaman')->with('success', 'Peminjaman berhasil');
    }

    public function kembali(int $id)
    {
        $data = Peminjaman::findOrFail($id);
        $user = User::find(session('user_id'));

        if (!$user) {
            return redirect('/login');
        }

        if ($user->role != 'admin' && $data->user_id != $user->id) {
            abort(403);
        }

        $data->update([
            'tanggal_kembali' => now()
        ]);

        return redirect('/peminjaman')->with('success', 'Buku dikembalikan');
    }

    public function riwayat()
    {
        $user = User::find(session('user_id'));

        $riwayat = Peminjaman::with('buku')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.riwayat', compact('riwayat', 'user'));
    }

    public function laporan(Request $request)
    {
        $query = Peminjaman::with('buku', 'user');

        if ($request->bulan) {
            $query->whereMonth('tanggal_pinjam', $request->bulan);
        }
        if ($request->tahun) {
            $query->whereYear('tanggal_pinjam', $request->tahun);
        }

        $data = $query->orderBy('tanggal_pinjam', 'desc')->get();
        $users = User::where('role', 'user')->get();

        return view('admin.laporan', compact('data', 'users'));
    }

    public function cetakLaporan(Request $request)
    {
        $query = Peminjaman::with('buku', 'user');

        if ($request->bulan) {
            $query->whereMonth('tanggal_pinjam', $request->bulan);
        }
        if ($request->tahun) {
            $query->whereYear('tanggal_pinjam', $request->tahun);
        }

        $data = $query->orderBy('tanggal_pinjam', 'desc')->get();

        return view('admin.laporan_cetak', compact('data'));
    }
}
