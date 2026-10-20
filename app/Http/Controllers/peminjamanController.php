<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\alat;
use App\Models\detailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class peminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $peminjaman = Peminjaman::with('user')->get();

    return view('peminjaman.index', compact('peminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alat = Alat::all();

    return view('peminjaman.create', compact('alat'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'tanggal_pinjam' => 'required',
        'tanggal_kembali' => 'required',
        'alat_id' => 'required',
        'jumlah' => 'required'
    ]);

    $peminjaman = Peminjaman::create([
        'user_id' => auth()->id(),
        'tanggal_pinjam' => $request->tanggal_pinjam,
        'tanggal_kembali' => $request->tanggal_kembali,
        'status' => 'pending'
    ]);

    DetailPeminjaman::create([
        'peminjaman_id' => $peminjaman->id,
        'alat_id' => $request->alat_id,
        'jumlah' => $request->jumlah
    ]);

    return redirect('/peminjaman')
        ->with('success', 'Peminjaman berhasil diajukan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function approve($id)
{
    $peminjaman = Peminjaman::findOrFail($id);

    $peminjaman->status = 'disetujui';

    $peminjaman->disetujui_oleh = auth()->id();

    $peminjaman->save();

    foreach ($peminjaman->details as $detail) {

        $alat = Alat::find($detail->alat_id);

        $alat->stok -= $detail->jumlah;

        $alat->save();
    }

    return redirect('/peminjaman')
        ->with('success', 'Peminjaman disetujui');
}
}