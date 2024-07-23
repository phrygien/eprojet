<?php

use Livewire\Volt\Component;
use App\Models\Permission;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    #[Rule('required')]
    public string $name = '';

    public function save()
    {
        $data = $this->validate();
        $permission = Permission::create($data);
        $this->success('Permission Created.', redirectTo: '/advanced/permissions');
    }

}; ?>

<div>
    <x-header title="Crée Permission" subtitle="Nouvelle Permisison pour les plan" separator />
    <div class="grid gap-5 lg:grid-cols-2">
        <div>
            <x-form wire:submit="save">
                <x-input label="Nom du permission" wire:model="name" />
                <x-slot:actions>
                    <x-button label="Annuler" link="/advanced/permissions" />
                    <x-button label="Enregistrer" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
                </x-slot:actions>
            </x-form>
        </div>
        <div>
            {{-- Get a nice picture from `StorySet` web site --}}
            <img src="https://flow.mary-ui.com/images/edit-form.png" width="300" class="mx-auto" />
        </div>
    </div>
</div>
