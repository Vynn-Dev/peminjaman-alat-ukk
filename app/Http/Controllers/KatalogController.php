<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;

class KatalogController extends Controller
{
    public function index()
    {
        $alat = Alat::with('kategori')
            ->orderBy('nama_alat')
            ->get();

        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('katalog.index', compact('alat', 'kategori'));
    }
}
