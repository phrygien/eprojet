{{-- <div>

    <div class="w-full p-5 mx-auto drawer-content lg:p-10">
        <!-- MAIN CONTENT -->
        <div class="grid gap-10 lg:grid-cols-2">

            <div>
                <img src="https://flow.mary-ui.com/images/empty-product.png" width="300"
                    class="mx-auto rounded-lg shadow-sm">
            </div>
            <div>

                <div class="text-2xl font-bold">
                    {{ $pricing->name }}
                </div>

                <div class="flex flex-wrap gap-3 mt-5">
                    <div class="badge badge-neutral">
                        {{ $pricing->price }} AR
                    </div>
                </div>

                <div class="flex gap-3 mt-8">
                    <x-button label="Placer ma démande" class="btn-warning" @click="$wire.myModal2 = true" icon="o-heart" />

                    <!--  Force tailwind compile tooltip classes   -->
                    <span class="hidden">
                        <span
                            class="lg:tooltip lg:tooltip-left lg:tooltip-right lg:tooltip-bottom lg:tooltip-top"></span>
                    </span>
                </div>

                <div class="my-8">
                    {{ $pricing->description }}
                </div>
            </div>
        </div>

    </div>

    <x-modal wire:model="myModal2" title="Êtes-vous sûr ?" blur persistent>
        <x-form wire:submit="save">
            <x-input label="Nom du domaine" wire:model="domain_name" icon="o-globe-alt" hint="ex: mon-ecole, monecole, (ou l'abreviation de votre école)">
                <x-slot:append>
                    <x-button label="generer domaine" icon="o-arrow-path" class="btn-primary rounded-s-none" wire:click="generateDomainName" />
                </x-slot:append>
            </x-input>
            <x-slot:actions>
                <x-button label="Annuler"  @click="$wire.myModal2 = false" />
                <x-button label="Comfirmer" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>

</div> --}}
<x-form wire:submit="save">
<div>
    <!-- Grid stuff from Tailwind -->
    <div class="grid gap-5 lg:grid-cols-2">
        <div>
            <x-card>
                <x-header title="{{ $pricing->name }}" subtitle="Basic info from pack" size="text-2xl" separator />
                <div class="grid gap-3">
                    <x-input label="Nom Pack" wire:model="name" readonly/>
                    <x-input label="Description" wire:model="description" readonly/>
                    <x-input label="Prix Pack" wire:model="price" prefix="AR" inline readonly/>
                    <x-input label="Max Utilisateurs" wire:model="max_user" type="number" readonly/>
                    <x-input label="Max Eleves" wire:model="max_student" type="number" readonly/>
                </div>
            </x-card>
        </div>
        <div>
            <x-card>
                <x-header title="Abonnement" subtitle="Basic info from abonnement" size="text-2xl" separator />
                <div class="grid gap-3">
                    <x-select label="Durée abonnement" icon-right="o-calendar" :options="$mois" wire:model.live="dure" />
                    <x-input label="Montant à payer" wire:model="amount_total" prefix="AR" inline readonly/>
                </div>
            </x-card>
        </div>
    </div>
</div>
<x-slot:actions>
    <x-button label="Annuler" />
    <x-button label="Valider souscription" class="btn-warning" type="submit" spinner="save" />
</x-slot:actions>
</x-form>
