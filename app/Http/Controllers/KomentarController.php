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
        $user = User::find(session('user_id'));
        $komentar = Komentar::with('buku')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $buku = Buku::all();

        return view('user.komentar', compact('komentar', 'buku', 'user'));
    }

    public function store(Request $request)
    {
        Komentar::create([
            'user_id' => session('user_id'),
            'buku_id' => $request->buku_id,
            'komentar' => $request->komentar,
            'rating' => $request->rating
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $komentar = Komentar::findOrFail($id);

        if ($komentar->user_id == session('user_id')) {
            $komentar->delete();
            return back()->with('success', 'Komentar dihapus!');
        }

        abort(403);
    }
}
