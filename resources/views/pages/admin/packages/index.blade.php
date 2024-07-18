<x-layouts.admin title="Packages">
    <x-header title="Packages" separator subtitle="Packs diponible pour les abonnements">
        <x-slot:actions>
            <x-button label="Ajouter Package" icon="o-plus" link="{{ route('pages:advanced:packages.create') }}" class="btn-primary" />
        </x-slot:actions>
    </x-header>
    <div class="space-y-4">
        <livewire:admin.package.list-package lazy />
    </div>
</x-layouts.admin>
