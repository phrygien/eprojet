<?php

declare(strict_types=1);

use App\Models\Abonnement;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('dashboard', 'pages.admin.dashboard')->name('dashboard');
Route::view('roles', 'pages.admin.packages.index')->name('roles');
Route::view('roles/create', 'pages.admin.packages.create')->name('roles.create');
Route::get('roles/{id}/edit', function (Role $role, $id) {
    $role = Role::find($id);
    return view('pages.admin.packages.edit', compact('role'));
})->name('pricings.souscription');
Route::view('modules', 'pages.admin.packages.modules')->name('modules');
Route::view('users', 'pages.admin.packages.users')->name('users');
Route::view('abonnements', 'pages.admin..abonnements.index')->name('abonnements');
Route::get('abonnements/{id}/valider_souscription', function (Abonnement $abonnement, $id) {
    $abonnement = Abonnement::find($id);
    return view('pages.admin.abonnements.souscription', compact('abonnement'));
})->name('abonnement.souscription');
Route::view('settings', 'pages.admin.settings')->name('settings');
