<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Buat / perbarui akun admin tunggal.
     *
     * Password di-hash otomatis oleh cast 'hashed' pada model User.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'resa.komara.akbari@gmail.com'],
            [
                'name' => 'Resa Komara Akbari',
                'password' => 'resasidewa123',
            ]
        );
    }
}
