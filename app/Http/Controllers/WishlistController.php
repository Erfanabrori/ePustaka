<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Buku;
use App\Models\User;

class WishlistController extends Controller
{
    public function index()
    {
        $user = User::find(session('user_id'));
        $wishlist = Wishlist::with('buku')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.wishlist', compact('wishlist', 'user'));
    }

    public function store(Request $request)
    {
        // Cek apakah sudah ada di wishlist
        $exists = Wishlist::where('user_id', session('user_id'))
            ->where('buku_id', $request->buku_id)
            ->first();

        if ($exists) {
            return back()->with('error', 'Buku sudah ada di wishlist!');
        }

        Wishlist::create([
            'user_id' => session('user_id'),
            'buku_id' => $request->buku_id
        ]);

        return back()->with('success', 'Buku ditambahkan ke wishlist!');
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::findOrFail($id);

        if ($wishlist->user_id == session('user_id')) {
            $wishlist->delete();
            return back()->with('success', 'Buku dihapus dari wishlist!');
        }

        abort(403);
    }
}
