<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Penerbit;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('penerbit');

        // FIX SEARCH SESUAI DB
        if ($request->search) {
            $query->where('judul_buku', 'like', '%' . $request->search . '%');
        }

        $data = $query->get();

        $role = session('role');

        return view('buku.index', compact('data', 'role'));
    }

    // FIX: kirim data penerbit ke view
    public function create()
    {
        $penerbit = Penerbit::all();
        return view('buku.tambah', compact('penerbit'));
    }

    // FIX: jangan pakai all() langsung (biar aman)
    public function store(Request $request)
    {
        Buku::create([
            'judul_buku'      => $request->judul_buku,
            'isbn'            => $request->isbn,
            'tahun_terbit'    => $request->tahun_terbit,
            'jumlah_halaman'  => $request->jumlah_halaman,
            'penerbit_id'     => $request->penerbit_id,
            'tempat_terbit'   => $request->tempat_terbit,
            'edisi'           => $request->edisi,
            'deskripsi'       => $request->deskripsi,
        ]);

        return redirect('/buku');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $penerbit = Penerbit::all();

        return view('buku.edit', compact('buku', 'penerbit'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $buku->update([
            'judul_buku'      => $request->judul_buku,
            'isbn'            => $request->isbn,
            'tahun_terbit'    => $request->tahun_terbit,
            'jumlah_halaman'  => $request->jumlah_halaman,
            'penerbit_id'     => $request->penerbit_id,
            'tempat_terbit'   => $request->tempat_terbit,
            'edisi'           => $request->edisi,
            'deskripsi'       => $request->deskripsi,
        ]);

        return redirect('/buku');
    }

    public function destroy($id)
    {
        Buku::findOrFail($id)->delete();
        return redirect('/buku');
    }
}
