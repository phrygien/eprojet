<?php

namespace App\Livewire\Admin\Abonnement;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AbonnementList extends Component
{
    use WithPagination;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public function mount(): void
    {
    }

    public function render()
    {
        $abonnements = DB::table('abonnements')
        ->join('users', 'users.id', '=', 'abonnements.user_id')
        ->join('roles', 'roles.id', '=', 'abonnements.role_id')
        ->select('abonnements.*', 'roles.name as pricing', 'users.name')
        ->orderBy(...array_values($this->sortBy))
        ->paginate(10);

        $headers = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'is_active', 'label' => 'Etat Abonnement'],
            ['key' => 'numero_abonnement', 'label' => 'Numero Abonnement'],
            ['key' => 'name', 'label' => 'Nom Client'],
            ['key' => 'debut', 'label' => 'Date Debut'],
            ['key' => 'pricing', 'label' => 'Plan'],
            ['key' => 'statut', 'label' => 'Status Payment']
        ];

        return view('livewire.admin.abonnement.abonnement-list', [
            'headers' => $headers,
            'abonnements' => $abonnements
        ]);
    }
}
