<?php

use Livewire\Volt\Component;
use App\Models\Abonnement;
use App\Models\Tenant;
use Mary\Traits\Toast;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    use Toast;

    #[Rule('required|unique:tenants,id')]
    public $domain;

    public function mount(): void
    {

    }

    public function save()
    {
        $this->validate();

        $tenant = Tenant::create([
            'id' => $this->domain,
            'name' => $this->domain,
            'user_id' => Auth::user()->id,
        ]);

        //Creation domain for tenant
        $tenant->domains()->create([
            'domain' => $this->domain.'.'.config('app.domain'),
        ]);

        $this->success('Domain Created !');

        $this->redirect(
                url: route('pages:pings:accee_plateforme'),
            );
    }
}; ?>

<div>
    <x-header title="Domaine " separator />

    <!-- Grid stuff from Tailwind -->
    <div class="grid gap-5 lg:grid-cols-2">
        <div>
            <x-form wire:submit="save">
                <x-input label="Domain Name" wire:model="domain" placeholder="Enter Domain Name" icon="o-globe-alt" hint="c'est le nom de votre école, ou l'abreviation ou autres (text) pour vous identifier sur e-ping" />
                <x-slot:actions>
                    <x-button label="Annuler" />
                    <x-button label="Valider" class="btn-warning" type="submit" spinner="save" />
                </x-slot:actions>
            </x-form>
        </div>
        <div>
            {{-- Get a nice picture from `StorySet` web site --}}
            <img src="https://flow.mary-ui.com/images/edit-form.png" width="300" class="mx-auto" />
        </div>
    </div>
</div>
