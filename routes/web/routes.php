<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->as('pages:')->group(static function (): void {
        Route::view('/', 'pages.welcome')->name('home');

        Route::prefix('auth')->as('auth:')->group(static function (): void {
            Route::view('register', 'pages.auth.register')->name('register');
            Route::view('login', 'pages.auth.login_client')->name('login');

        });

        Route::middleware(['auth', 'permission:edit-posts'])->group(static function (): void {
            Route::view('dashboard', 'pages.index')->name('dashboard');
            Route::prefix('pings')->as('pings:')->group(base_path(
                path: 'routes/web/abonement.php',
            ));
        });

    });
}
