<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::view('mes-abonnements', 'pages.pings.abonnements.mes-abonnement')->name('mes_abonnements');
Route::view('/payment/abonnement', 'pages.pings.abonnements.payment')->name('payment.abonnement');
