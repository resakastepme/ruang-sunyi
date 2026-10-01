<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;

class LegalController extends Controller
{
    /**
     * Email kontak yang ditampilkan pada halaman legal.
     * GANTI dengan email kontak yang kamu inginkan untuk publik/audit.
     */
    private const CONTACT_EMAIL = 'resa.komara.akbari@gmail.com';

    private function lastUpdated(): string
    {
        return Carbon::parse('2026-10-01')->format('F j, Y');
    }

    public function privacy()
    {
        return view('legal.privacy', [
            'contactEmail' => self::CONTACT_EMAIL,
            'lastUpdated'  => $this->lastUpdated(),
        ]);
    }

    public function tos()
    {
        return view('legal.tos', [
            'contactEmail' => self::CONTACT_EMAIL,
            'lastUpdated'  => $this->lastUpdated(),
        ]);
    }
}
