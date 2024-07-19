<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;
use App\Models\User;
use App\Models\Abonnement;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    use Toast;

    public function mount()
    {
        $user = Auth::user();
        $users = User::where('id', $user->id)->first();
        $roles = $users->roles;
    }

    public function renew()
    {
        $this->success('Action Saved !');
    }

    public function desabonnee()
    {
        $this->success('Data Saved !');
    }

    public function with(): array
    {
        return [
            'abonnements' => DB::table('abonnements')
            ->join('users', 'abonnements.user_id', '=', 'users.id')
            ->join('roles', 'abonnements.role_id', '=', 'roles.id')
            ->select('abonnements.*', 'users.name', 'roles.name as role_name', 'roles.price')
            ->where('user_id', Auth::user()->id)->get(),
        ];
    }

}; ?>

<div>
    <x-header title="Mes abonnements" subtitle="Votres abonnement encours"></x-header>
    <div class="space-y-2">
        <div class="grid gap-3 lg:grid-cols-3 md:grid-cols-1">

            @foreach ( $abonnements as $abonnement )
            <div
            class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-between">
                <div>
                    <a href="###" wire:navigate
                        class="text-xl font-bold hover:underline hover:text-amber-500">{{ $abonnement->role_name }}</a>
                        <p class="font-semibold text-gray-500">Prix / mois : {{ $abonnement->price }} Ar</p>
                        <p><span>Numéro abonnement : {{ $abonnement->numero_abonnement }}</span></p>
                </div>
                <div class="text-xs text-gray-500">
                    20/03/2022
                </div>
            </div>
            <div class="flex items-end justify-between mt-4 space-x-1">
                <p class="text-xs">Statut: @if ($abonnement->statut == 1)
                    <span class="font-semibold text-green-500"> Actif</span></p>
                    @else
                    <span class="font-semibold text-red-500"> Pending</span></p>
                @endif
                <div>
                    @if ($abonnement->statut == 1)
                    <x-button class="btn-primary btn-sm" icon="o-heart" wire:click='renew' title="Renouveler" />
                    @endif
                    <x-button label="" class="btn-sm" icon="o-hand-thumb-down" wire:click='desabonnee' title="Desabonner" />
                </div>
            </div>
        </div>

            @endforeach
        </div>
    </div>
</div>
