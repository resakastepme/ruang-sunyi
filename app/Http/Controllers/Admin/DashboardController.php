<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Tampilkan dasbor "Ruang Tulis" admin.
     */
    public function index()
    {
        return view('admin.index');
    }
}
