<?php

use Livewire\Volt\Component;
use App\Models\Abonnement;
use App\Models\Role;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

new class extends Component {
    use Toast;
    use WithPagination;

    public string $search = '';

    public bool $drawer = false;

    public int $role_id = 0;

    public $statut;

    public array $sortBy = ['column' => 'created_at', 'direction' => 'asc'];

    // Clear filters
    public function clear(): void
    {
        $this->reset();
        $this->resetPage();
        $this->success('Filters cleared.', position: 'toast-bottom');
    }

    // Delete action
    public function delete($id): void
    {
        Abonnement::find($id)->delete();
        $this->success("Will delete #$id", 'It is fake.', position: 'toast-bottom');
    }

    public function updated($property): void
    {
        if (! is_array($property) && $property != "") {
            $this->resetPage();
        }
    }

    // update payment statut
    public function paid($id): void
    {
        $abonnement = Abonnement::find($id);
        $abonnement->update([
            'statut' => 1,
            'is_active' => true,
            'debut' => Carbon::now()->format('Y-m-d'),
            'fin' => Carbon::now()->addMonths($abonnement->duree)->format('Y-m-d')
        ]);
        $this->success('Abonnement Activé !');
    }

    // Table headers
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'numero_abonnement', 'label' => 'Numero Abonnement', 'class' => 'w-64'],
            ['key' => 'role.name', 'label' => 'Pack', 'class' => 'w-64'],
            ['key' => 'user.name', 'label' => 'Client', 'class' => 'w-64'],
            ['key' => 'user.email', 'label' => 'Email', 'class' => 'w-64'],
            ['key' => 'duree', 'label' => 'Duré de la souscription (mois)', 'class' => 'w-64'],
            ['key' => 'amount_total', 'label' => 'Montant total à payer', 'class' => 'w-64'],
            ['key' => 'statut', 'label' => 'Statut Payment', 'class' => 'w-64'],
            ['key' => 'is_active', 'label' => 'Etat', 'class' => 'w-64'],

        ];
    }

    public function abonnements(): LengthAwarePaginator
    {
        return Abonnement::query()
            ->with(['role', 'user'])
            ->when($this->search, fn(Builder $q) => $q->where('numero_abonnement', 'like', "%$this->search%"))
            ->when($this->role_id, fn(Builder $q) => $q->where('role_id', $this->role_id))
            ->when($this->statut, fn(Builder $q) => $q->where('statut', $this->statut))
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10); // No more `->get()`
    }

    public function with(): array
    {
        $status = [
            [
                'id' => 1,
                'name' => 'Payé',
            ],
            [
                'id' => 0,
                'name' => 'Non Payé',
            ]
        ];
        return [
            'abonnements' => $this->abonnements(),
            'headers' => $this->headers(),
            'roles' => Role::all(),
            'status' => $status
        ];
    }

}; ?>

<div>
    <!-- HEADER -->
    <x-header title="Abonnements" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
            <x-button label="Créer" link="/advanced/permissions/create" responsive icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$headers" :rows="$abonnements" :sort-by="$sortBy" with-pagination link="permissions/{id}/edit">
            @scope('cell_is_active', $abonnement)
                @if ($abonnement->is_active == 1)
                    <span class="badge badge-success">Actif</span>
                @endif
                @if ($abonnement->is_active == 0)
                    <span class="badge badge-warning">En attente</span>
                @endif
                @if ($abonnement->is_active == 2)
                    <span class="badge badge-error">Expiré</span>
                @endif
            @endscope
            @scope('cell_statut', $abonnement)
            @if ($abonnement->statut == 1)
                <span class="badge badge-success">Payé</span>
            @endif
            @if ($abonnement->statut == 0)
                <span class="badge badge-warning">Non Payé</span>
            @endif
            @endscope

            @scope('actions', $abonnement)
            <x-button icon="o-trash" wire:click="paid({{ $abonnement['id'] }})" wire:confirm="Vous etes sure?" spinner class="text-red-500 btn-ghost btn-sm" />
            @endscope
        </x-table>
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Filters" right separator with-close-button class="lg:w-1/3">
        <div class="grid gap-5">
            <x-input placeholder="Numero abonnement" wire:model.live.debounce="search" icon="o-magnifying-glass" @keydown.enter="$wire.drawer = false" />
            <x-select placeholder="Plan" wire:model.live="role_id" :options="$roles" icon="o-flag" placeholder-value="0" />
            <x-select placeholder="Statut payment" wire:model.live="statut" :options="$status" icon="o-flag" placeholder-value="" />
        </div>
        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer>
</div>
