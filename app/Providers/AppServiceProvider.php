<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\URL; // <-- Tambahkan baris ini

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
        // Paksa HTTPS jika aplikasi berjalan di production (Railway)
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        Event::listen(function (Login $event) {
            // Kita pastikan formatnya menggunakan cara standar Eloquent
            $user = $event->user;

            // Mengecek apakah user ini benar-benar instance dari Model User kita
            if ($user instanceof \App\Models\User) {
                $user->last_login_at = now();
                $user->save(); // Menggunakan save() jauh lebih aman dari update()
            }
        });
    }
}
