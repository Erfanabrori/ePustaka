<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;

class PeminjamanController extends Controller
{
    // LIST DATA
    public function index()
    {
        $user = User::find(session('user_id'));
        $role = session('role');

        if (!$user) {
            return redirect('/login');
        }

        if ($role == 'admin') {
            $data = Peminjaman::with('itemBuku', 'user')->get();
        } else {
            $data = Peminjaman::with('itemBuku')
                ->where('user_id', $user->id)
                ->get();
        }

        return view('peminjaman.index', compact('data', 'user', 'role'));
    }

    // FORM PINJAM
    public function create(Request $request)
    {
        $buku = Buku::all();

        $selected = $request->item_buku_id;

        return view('peminjaman.tambah', compact('buku', 'selected'));
    }

    // SIMPAN
    public function store(Request $request)
    {
        $request->validate([
            'item_buku_id' => 'required|exists:item_buku,id',
        ]);

        Peminjaman::create([
            'user_id' => session('user_id'),
            'item_buku_id' => $request->item_buku_id,
            'tanggal_pinjam' => now()
        ]);

        return redirect('/peminjaman')->with('success', 'Peminjaman berhasil');
    }

    // KEMBALIKAN
    public function kembali($id)
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

    // RIWAYAT TRANSAKSI USER
    public function riwayat()
    {
        $user = User::find(session('user_id'));

        $riwayat = Peminjaman::with('itemBuku')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.riwayat', compact('riwayat', 'user'));
    }
}
