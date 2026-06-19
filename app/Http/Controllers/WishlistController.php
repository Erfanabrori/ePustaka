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
        $user = User::findRaw(session('user_id'));
        if (!$user) return redirect('/login');

        $wishlists = Wishlist::forUser($user->id);

        return view('user.wishlist', compact('wishlists', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required'
        ]);

        // cek apakah buku sudah ada di wishlist
        $exists = Wishlist::existsForUserBook(session('user_id'), $request->buku_id);

        if ($exists) {
            return back()->with('error', 'Buku sudah ada di wishlist!');
        }

        Wishlist::create([
            'user_id' => session('user_id'),
            'buku_id' => $request->buku_id
        ]);

        return back()->with('success', 'Buku berhasil ditambahkan ke wishlist!');
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::findRaw($id);

        if (!$wishlist) abort(404);

        if ($wishlist->user_id == session('user_id')) {
            $wishlist->delete();
            return back()->with('success', 'Wishlist berhasil dihapus!');
        }

        abort(403);
    }
}
