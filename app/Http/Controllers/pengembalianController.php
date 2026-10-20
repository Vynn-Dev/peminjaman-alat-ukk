<?php

namespace App\Http\Controllers;

use App\Models\pengembalian;
use App\Models\peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;

class pengembalianController extends Controller
{
    public function store($id)
{
    $peminjaman = Peminjaman::findOrFail($id);

    Pengembalian::create([
        'peminjaman_id' => $peminjaman->id,
        'tanggal_pengembalian' => now(),
        'status' => 'dikembalikan'
    ]);

    $peminjaman->status = 'dikembalikan';

    $peminjaman->save();

    foreach ($peminjaman->details as $detail) {

        $alat = Alat::find($detail->alat_id);

        $alat->stok += $detail->jumlah;

        $alat->save();
    }

    return redirect('/peminjaman')
        ->with('success', 'Alat berhasil dikembalikan');
}
}
