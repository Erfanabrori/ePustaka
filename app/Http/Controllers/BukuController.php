<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Penerbit;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $data = Buku::fetchForIndex($request->search);

        $role = session('role');

        return view('buku.index', compact('data', 'role'));
    }

    // FIX: kirim data penerbit ke view
    public function create()
    {
        $penerbit = Penerbit::allRaw();
        return view('buku.tambah', compact('penerbit'));
    }

    // FIX: jangan pakai all() langsung (biar aman)
    public function store(Request $request)
    {
        Buku::insertRaw([
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
        $buku = Buku::findRaw($id);
        if (!$buku) abort(404);
        $penerbit = Penerbit::allRaw();

        return view('buku.edit', compact('buku', 'penerbit'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findRaw($id);
        if (!$buku) abort(404);

        Buku::updateRaw($id, [
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
        $b = Buku::findRaw($id);
        if (!$b) abort(404);
        Buku::deleteRaw($id);
        return redirect('/buku');
    }

    // CETAK BARCODE SATU BUKU
    public function cetakBarcode($id)
    {
        $buku = Buku::findRaw($id);
        if (!$buku) abort(404);
        return view('admin.barcode', compact('buku'));
    }

    // CETAK SEMUA BARCODE
    public function cetakSemuaBarcode()
    {
        $buku = Buku::allRaw();
        return view('admin.barcode_semua', compact('buku'));
    }
}
