<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Pagination bergaya Bootstrap 5 (selaras tema admin).
        Paginator::useBootstrapFive();

        // Bagikan identitas pemilik ruang (penulis tunggal) ke seluruh tampilan.
        try {
            $owner = Schema::hasTable('users') ? User::oldest('id')->first() : null;
        } catch (\Throwable $e) {
            $owner = null;
        }

        View::share('owner', $owner);
    }
}
