<x-layouts.admin title="Les Abonnements">
    <x-header title="Les abonnements" separator subtitle="Tous les abonnement disponible">
        <x-slot:actions>
        </x-slot:actions>
    </x-header>
    <div class="space-y-4">
        <x-card>
            <livewire:admin.abonnement.abonnement-list lazy />
        </x-card>
    </div>
</x-layouts.admin>
