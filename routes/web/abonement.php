<?php

declare(strict_types=1);

use App\Models\Abonnement;
use Illuminate\Support\Facades\Route;

Route::view('mes-abonnements', 'pages.pings.abonnements.mes-abonnement')->name('mes_abonnements');

Route::get('/abonement/{id}/payment', function (Abonnement $abonnement, $id) {
    $abonnement = Abonnement::find($id);
    return view('pages.pings.abonnements.payment', compact('abonnement'));
})->name('payment.abonnement');

/**
 * manage tenant and domaine
 */
Route::view('accee_plateforme', 'pages.pings.abonnements.accee')->name('accee_plateforme');
Route::view('accee/init', 'pages.pings.abonnements.init')->name('accee.init');
