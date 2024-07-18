<x-layouts.admin title="Plans de Tarification de e-ping">
    <x-header title="Plans de Tarification de e-ping" separator subtitle="Packs diponible pour les abonnements">
        <x-slot:actions>
            <x-button label="Ajouter Plans de Tarification" icon="o-plus" link="{{ route('pages:advanced:packages.create') }}" class="btn-primary" />
        </x-slot:actions>
    </x-header>
    <div class="space-y-4">
        <livewire:admin.package.list-package lazy />
    </div>
</x-layouts.admin>
