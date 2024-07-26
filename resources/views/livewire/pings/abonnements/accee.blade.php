<?php

use Livewire\Volt\Component;
use App\Models\Tenant;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

new class extends Component {
    use Toast;
    use WithPagination;

    public array $sortBy = ['column' => 'id', 'direction' => 'asc'];

    // Table headers
    public function headers(): array
    {
        return [
            // ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'id', 'label' => 'Itendtification plateforme', 'class' => 'w-64'],
            ['key' => 'domain', 'label' => 'Domain plateforme', 'class' => 'w-64'],
        ];
    }

    public function tenants(): LengthAwarePaginator
    {
        return Tenant::query()
        ->select('tenants.*', 'domains.domain')
        ->join('domains', 'domains.tenant_id', '=', 'tenants.id')
        ->with('domains')
        ->orderBy(...array_values($this->sortBy))
        ->paginate(10);
    }

    public function with(): array
    {
        return [
            'tenants' => $this->tenants(),
            'headers' => $this->headers(),
        ];
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="Ecole" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Initialiser votre école" link="/pings/accee/init" responsive icon="o-circle-stack" class="btn-warning" />
        </x-slot:actions>
    </x-header>
    <!-- TABLE  -->
    <x-card>
        <x-table :headers="$headers" :rows="$tenants" :sort-by="$sortBy" with-pagination link="permissions/{id}/edit">
            @scope('actions', $tenant)
            <x-button icon="o-trash" wire:click="delete({{ $tenant['id'] }})" wire:confirm="Vous etes sure?" spinner class="text-red-500 btn-ghost btn-sm" />
            @endscope
        </x-table>
    </x-card>
</div>
