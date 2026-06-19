<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komentar;
use App\Models\Buku;
use App\Models\User;

class KomentarController extends Controller
{
    public function index()
    {
        $user = User::findRaw(session('user_id'));
        if (!$user) return redirect('/login');

        $komentar = Komentar::forUser($user->id);

        $buku = Buku::allRaw();
        $selectedBukuId = request('buku_id');

        return view('user.komentar', compact('komentar', 'buku', 'user', 'selectedBukuId'));
    }

    public function store(Request $request)
    {
        Komentar::create([
            'user_id' => session('user_id'),
            'buku_id' => $request->buku_id,
            'isi_komentar' => $request->komentar,
            'rating' => $request->rating ?? null
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $komentar = Komentar::findRaw($id);
        if (!$komentar) abort(404);

        if ($komentar->user_id != session('user_id')) {
            abort(403);
        }

        $buku = Buku::allRaw();
        return view('user.komentar.edit', compact('komentar', 'buku'));
    }

    public function update(Request $request, $id)
    {
        $komentar = Komentar::findRaw($id);
        if (!$komentar) abort(404);

        if ($komentar->user_id != session('user_id')) {
            abort(403);
        }

        $komentar->update([
            'buku_id' => $request->buku_id,
            'isi_komentar' => $request->komentar,
            'rating' => $request->rating ?? null
        ]);

        return redirect('/komentar')->with('success', 'Komentar berhasil diupdate!');
    }

    public function destroy($id)
    {
        $komentar = Komentar::findRaw($id);
        if (!$komentar) abort(404);

        if ($komentar->user_id == session('user_id')) {
            $komentar->delete();
            return back()->with('success', 'Komentar dihapus!');
        }

        abort(403);
    }

    // ADMIN METHODS
    public function adminIndex()
    {
        $data = Komentar::adminAll();
        return view('admin.komentar.index', compact('data'));
    }

    public function adminShow($id)
    {
        $komentar = Komentar::findWithRelations($id);
        if (!$komentar) abort(404);

        return view('admin.komentar.show', compact('komentar'));
    }

    public function adminDestroy($id)
    {
        $komentar = Komentar::findRaw($id);
        if (!$komentar) abort(404);
        $komentar->delete();
        return back()->with('success', 'Komentar berhasil dihapus!');
    }
}
