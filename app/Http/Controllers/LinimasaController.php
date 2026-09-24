<?php

namespace App\Http\Controllers;

class LinimasaController extends Controller
{
    /**
     * Tampilkan linimasa publik (halaman utama).
     */
    public function index()
    {
        return view('linimasa.index');
    }
}
