<div>
    <x-header title="Abonnement : {{ $abonnement->numero_abonnement }}" separator subtitle="Tous les abonnement disponible">
        <x-slot:actions>
        </x-slot:actions>
    </x-header>
    <x-form wire:submit="save">
        {{--  Basic section  --}}
        <div class="grid-cols-5 lg:grid">
            <div class="col-span-2">
                <x-header title="Domaine" subtitle="Basic info from domaine" size="text-2xl" />
            </div>
            <div class="grid col-span-3 gap-3">
                <x-input label="Nom du domaine" wire:model="domain_name" icon-right="o-globe-alt" readonly prefix="https://" />
            </div>
        </div>

        {{--  Details section --}}
        <hr class="my-5" />

        <div class="grid-cols-5 lg:grid">
            <div class="col-span-2">
                <x-header title="Details" subtitle="More about the user" size="text-2xl" />
            </div>
            <div class="grid col-span-3 gap-3">
                <x-input label="Nom et prenoms" wire:model="name" icon-right="o-user" readonly />
                <x-input label="Email" wire:model="email" icon-right="o-envelope" readonly />
            </div>
        </div>

        <x-slot:actions>
            <x-button label="Annuler" link="/advanced/abonnements" />
            <x-button label="Valider souscription" class="btn-primary" type="submit" spinner="save" icon="o-paper-airplane" />
        </x-slot:actions>
    </x-form>
</div>
