<?php

declare(strict_types=1);

use App\Models\Abonnement;
use Illuminate\Support\Facades\Route;

Route::view('dashboard', 'pages.admin.dashboard')->name('dashboard');
Route::view('packages', 'pages.admin.packages.index')->name('packages');
Route::view('packages/create', 'pages.admin.packages.create')->name('packages.create');
Route::view('modules', 'pages.admin.packages.modules')->name('modules');
Route::view('users', 'pages.admin.packages.users')->name('users');
Route::view('abonnements', 'pages.admin..abonnements.index')->name('abonnements');
Route::get('abonnements/{id}/valider_souscription', function (Abonnement $abonnement, $id) {
    $abonnement = Abonnement::find($id);
    return view('pages.admin.abonnements.souscription', compact('abonnement'));
})->name('abonnement.souscription');
Route::view('settings', 'pages.admin.settings')->name('settings');
