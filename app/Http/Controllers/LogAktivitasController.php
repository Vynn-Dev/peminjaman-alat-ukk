<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\logaktivitas;

class LogAktivitasController extends Controller
{
    public function index()
    {
        $log = logaktivitas::with('user')
            ->latest()
            ->get();

        return view('logaktivitas.index', compact('log'));
    }
}
