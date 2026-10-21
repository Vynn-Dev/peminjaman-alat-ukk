<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\DetailPeminjaman;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peminjaman = Peminjaman::with('user', 'details.alat')
            ->latest()
            ->get();

        // Peminjam hanya bisa melihat pengajuan peminjamannya sendiri
        if (auth()->user()->role === 'peminjam') {
            $peminjaman = $peminjaman->where('user_id', auth()->id());
        }

        return view('peminjaman.index', compact('peminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alat = Alat::orderBy('nama_alat')->get();

        return view('peminjaman.create', compact('alat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pinjam' => ['required', 'date', 'after_or_equal:today'],
            'tanggal_kembali' => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
            'alat_id' => ['required', 'exists:alats,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $alat = Alat::findOrFail($request->alat_id);

        // Cek stok sebelum mengajukan
        if ($request->jumlah > $alat->stok) {
            return back()
                ->withInput()
                ->withErrors([
                    'jumlah' => "Stok {$alat->nama_alat} hanya tersisa {$alat->stok} unit."
                ]);
        }

        $peminjaman = Peminjaman::create([
            'user_id' => auth()->id(),
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'pending',
        ]);

        DetailPeminjaman::create([
            'peminjaman_id' => $peminjaman->id,
            'alat_id' => $alat->id,
            'jumlah' => $request->jumlah,
        ]);

        $this->log('Mengajukan peminjaman ' . $alat->nama_alat . ' sebanyak ' . $request->jumlah);

        return redirect('/peminjaman')
            ->with('success', 'Peminjaman berhasil diajukan');
    }

    /**
     * Approve peminjaman (hanya petugas).
     */
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'pending') {
            return redirect('/peminjaman')
                ->with('error', 'Peminjaman ini sudah diproses');
        }

        // Pastikan stok masih cukup sebelum disetujui
        foreach ($peminjaman->details as $detail) {
            $alat = Alat::find($detail->alat_id);
            if ($alat->stok < $detail->jumlah) {
                return redirect('/peminjaman')
                    ->with('error', "Stok {$alat->nama_alat} tidak cukup untuk disetujui");
            }
        }

        $peminjaman->status = 'disetujui';
        $peminjaman->disetujui_oleh = auth()->id();
        $peminjaman->save();

        foreach ($peminjaman->details as $detail) {
            $alat = Alat::find($detail->alat_id);
            $alat->stok -= $detail->jumlah;
            $alat->save();
        }

        $this->log('Menyetujui peminjaman #' . $peminjaman->id);

        return redirect('/peminjaman')
            ->with('success', 'Peminjaman disetujui');
    }

    /**
     * Tolak peminjaman (hanya petugas).
     */
    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'pending') {
            return redirect('/peminjaman')
                ->with('error', 'Peminjaman ini sudah diproses');
        }

        $peminjaman->status = 'ditolak';
        $peminjaman->disetujui_oleh = auth()->id();
        $peminjaman->save();

        $this->log('Menolak peminjaman #' . $peminjaman->id);

        return redirect('/peminjaman')
            ->with('success', 'Peminjaman ditolak');
    }

    /**
     * Catat aktivitas ke tabel log_aktivitas.
     */
    private function log($aktivitas)
    {
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => $aktivitas,
        ]);
    }
}
