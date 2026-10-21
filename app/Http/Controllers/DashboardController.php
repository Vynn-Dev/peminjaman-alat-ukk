<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        return match (auth()->user()->role) {
            'admin' => $this->admin(),
            'petugas' => $this->petugas(),
            default => $this->peminjam(),
        };
    }

    private function admin()
    {
        $stats = [
            'kategori' => Kategori::count(),
            'alat' => Alat::count(),
            'stok' => Alat::sum('stok'),
            'peminjaman' => Peminjaman::count(),
            'pending' => Peminjaman::where('status', 'pending')->count(),
        ];

        $peminjamanTerbaru = Peminjaman::with('user', 'details.alat')
            ->latest()
            ->take(5)
            ->get();

        $logTerbaru = LogAktivitas::with('user')
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard.admin', compact('stats', 'peminjamanTerbaru', 'logTerbaru'));
    }

    private function petugas()
    {
        $stats = [
            'pending' => Peminjaman::where('status', 'pending')->count(),
            'dipinjam' => Peminjaman::where('status', 'disetujui')->count(),
            'selesai' => Peminjaman::where('status', 'selesai')->count(),
        ];

        $pendingQueue = Peminjaman::with('user', 'details.alat')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $dipinjam = Peminjaman::with('user', 'details.alat')
            ->where('status', 'disetujui')
            ->orderBy('tanggal_kembali')
            ->get();

        return view('dashboard.petugas', compact('stats', 'pendingQueue', 'dipinjam'));
    }

    private function peminjam()
    {
        $stats = [
            'pending' => Peminjaman::where('user_id', auth()->id())->where('status', 'pending')->count(),
            'dipinjam' => Peminjaman::where('user_id', auth()->id())->where('status', 'disetujui')->count(),
            'selesai' => Peminjaman::where('user_id', auth()->id())->where('status', 'selesai')->count(),
        ];

        $peminjamanSaya = Peminjaman::with('details.alat')
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        $alatTersedia = Alat::where('kondisi', '!=', 'rusak berat')
            ->orderBy('nama_alat')
            ->get();

        return view('dashboard.peminjam', compact('stats', 'peminjamanSaya', 'alatTersedia'));
    }
}
