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
    <x-header title="Mes abonnements" subtitle="Liste abonnement effectué par vous"></x-header>
    <div class="space-y-2">
        <div class="grid gap-3 lg:w-full md:grid-cols-1">

            @foreach ( $abonnements as $abonnement )
            <div
            class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-between">
                <div>
                    <a href="###" wire:navigate
                        class="text-xl font-bold hover:underline hover:text-amber-500">{{ $abonnement->role_name }}</a>
                        <p class="font-semibold text-gray-500">Prix plan : {{ $abonnement->price }} Ar</p>
                        <p class="font-2xl text-gray-500">Montant total payé : {{ $abonnement->amount_total }} Ar</p>
                        <p><span>Numéro abonnement : {{ $abonnement->numero_abonnement }}</span></p>
                </div>
                <div class="text-xs text-gray-500">
                   Periode ({{ $abonnement->duree }} mois ) : {{ \Carbon\Carbon::parse( $abonnement->debut)->format('j-F-Y') }}  <span class="text-amber-700"> - {{ \Carbon\Carbon::parse( $abonnement->fin)->format('j-F-Y') }}</span>
                </div>
            </div>
            <div class="flex items-end justify-between mt-4 space-x-1">
                <p class="text-xs">Statut paiement :
                    @if ($abonnement->statut == 1)
                        <span class="font-semibold text-green-500"> Payé</span></p>
                        @else
                        <span class="font-semibold text-red-500"> Non payé</span>
                    @endif
                </p>

                <p class="text-xs">

                    Etat abonnement : @if ($abonnement->is_active == 1)
                    <span class="font-semibold text-green-500"> Actif</span>
                    @endif
                    @if ($abonnement->is_active == 0)
                        <span class="font-semibold text-amber-500"> En entente</span></p>
                    @endif
                    @if ($abonnement->is_active == 2)
                        <span class="font-semibold text-red-500"> Expiré</span></p>
                    @endif
                </p>
                <div>
                    @if ($abonnement->statut != 1)
                    <x-button class="btn-primary btn-sm" icon="o-banknotes" link="/pings/abonement/{{ $abonnement->id }}/payment" title="Payer maintenant" label="Payer maintenant" />
                    @endif
                    <x-button label="" class="btn-sm text-red-500" icon="o-hand-thumb-down" wire:click='desabonnee' title="Desabonner" />
                </div>
            </div>
        </div>

            @endforeach
        </div>
    </div>
</div>
