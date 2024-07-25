<?php

declare(strict_types=1);

use App\Models\Abonnement;
use Illuminate\Support\Facades\Route;

Route::view('mes-abonnements', 'pages.pings.abonnements.mes-abonnement')->name('mes_abonnements');

Route::get('/abonement/{id}/payment', function (Abonnement $abonnement, $id) {
    $abonnement = Abonnement::find($id);
    return view('pages.pings.abonnements.payment', compact('abonnement'));
})->name('payment.abonnement');
