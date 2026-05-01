<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $role = session('role');
        $userId = session('user_id');

        $data = [
            'totalBuku' => \App\Models\Buku::count(),
            'totalPeminjaman' => \App\Models\Peminjaman::count(),
            'totalUser' => \App\Models\User::count(),
        ];

        // Untuk user biasa, hitung peminjaman mereka
        if ($role !== 'admin' && $userId) {
            $data['peminjamanSaya'] = \App\Models\Peminjaman::where('user_id', $userId)->count();
        }

        return view('dashboard', compact('data', 'role'));
    }
}
