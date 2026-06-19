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
            'totalBuku' => \App\Models\Buku::allRaw()->count(),
            'totalPeminjaman' => \App\Models\Peminjaman::countAll(),
            'totalUser' => \App\Models\User::countRaw(),
        ];

        // Untuk user biasa, hitung peminjaman mereka
        if ($role !== 'admin' && $userId) {
            $data['peminjamanSaya'] = \App\Models\Peminjaman::countByUser($userId);
        }

        return view('dashboard', compact('data', 'role'));
    }
}
