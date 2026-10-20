<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\kategori;
use Illuminate\Http\Request;

class alatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alat = Alat::with('kategori')->get();
        return view('alat.index', compact('alat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('alat.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'kode_alat' => 'required',
        'nama_alat' => 'required',
        'merk' => 'required',
        'stok' => 'required|integer',
        'kondisi' => 'required',
        'kategori_id' => 'required',
        'foto' => 'nullable|image|mimes:jpg,png,jpeg'
    ]);

    $foto = null;

    if ($request->hasFile('foto')) {

        $foto = time().'.'.$request->foto->extension();

        $request->foto->move(public_path('foto_alat'), $foto);
    }

    Alat::create([
        'kode_alat' => $request->kode_alat,
        'nama_alat' => $request->nama_alat,
        'merk' => $request->merk,
        'stok' => $request->stok,
        'kondisi' => $request->kondisi,
        'foto' => $foto,
        'kategori_id' => $request->kategori_id
    ]);

    return redirect('/alat')
        ->with('success', 'Alat berhasil ditambahkan');
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
    public function edit(Alat $alat)
    {
        $kategori = Kategori::all();
        return view('alat.edit', compact('alat', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alat $alat)
    {
         $request->validate([
        'kode_alat' => 'required',
        'nama_alat' => 'required',
        'merk' => 'required',
        'stok' => 'required|integer',
        'kondisi' => 'required',
        'kategori_id' => 'required'
    ]);

    $data = [
        'kode_alat' => $request->kode_alat,
        'nama_alat' => $request->nama_alat,
        'merk' => $request->merk,
        'stok' => $request->stok,
        'kondisi' => $request->kondisi,
        'kategori_id' => $request->kategori_id
    ];

    if ($request->hasFile('foto')) {

        $foto = time().'.'.$request->foto->extension();

        $request->foto->move(public_path('foto_alat'), $foto);

        $data['foto'] = $foto;
    }

    $alat->update($data);

    return redirect('/alat')
        ->with('success', 'Alat berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alat $alat)
    {
          $alat->delete();

        return redirect('/alat')
        ->with('success', 'Alat berhasil dihapus');
    }
}
