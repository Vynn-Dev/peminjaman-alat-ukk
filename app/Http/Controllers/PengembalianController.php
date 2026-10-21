<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    /**
     * Denda keterlambatan per hari (Rupiah).
     */
    private const DENDA_PER_HARI = 5000;

    public function store(Request $request, $id)
    {
        $request->validate([
            'kondisi_setelah_kembali' => ['required', 'in:baik,rusak ringan,rusak berat'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'disetujui') {
            return redirect('/peminjaman')
                ->with('error', 'Peminjaman ini belum disetujui');
        }

        // Hitung denda jika pengembalian melewati tanggal_kembali
        $tanggalKembali = Carbon::parse($peminjaman->tanggal_kembali)->startOfDay();
        $telat = $tanggalKembali->lt(now()->startOfDay())
            ? $tanggalKembali->diffInDays(now()->startOfDay())
            : 0;

        $denda = $telat * self::DENDA_PER_HARI;

        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_pengembalian' => now()->toDateString(),
            'kondisi_setelah_kembali' => $request->kondisi_setelah_kembali,
            'catatan' => $request->catatan,
            'denda' => $denda,
            'status' => 'selesai',
        ]);

        $peminjaman->status = 'selesai';
        $peminjaman->save();

        foreach ($peminjaman->details as $detail) {
            $alat = Alat::find($detail->alat_id);

            $alat->stok += $detail->jumlah;

            // Jika alat rusak saat dikembalikan, update kondisi alat
            if ($request->kondisi_setelah_kembali !== 'baik') {
                $alat->kondisi = $request->kondisi_setelah_kembali;
            }

            $alat->save();
        }

        LogAktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Mencatat pengembalian peminjaman #' . $peminjaman->id
                . ' (denda Rp ' . number_format($denda, 0, ',', '.') . ')',
        ]);

        return redirect('/peminjaman')
            ->with('success', 'Alat berhasil dikembalikan');
    }
}
