<?php

namespace App\Http\Controllers;

class TentangController extends Controller
{
    /**
     * Tampilkan halaman "Tentang Saya".
     */
    public function index()
    {
        return view('tentang.index');
    }
}
