<?php

use Livewire\Volt\Component;
use App\Models\Permission;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public Permission $permission;

    #[Rule('required')]
    public string $name = '';

    public function mount(): void
    {
        $this->fill($this->permission);
    }

    public function save()
    {
        $data = $this->validate();
        $this->permission->update($data);
        $this->success('Permission updated.', redirectTo: '/advanced/permissions');
    }
}; ?>

<div>
    <x-header title="Mise a jour {{ $permission->name }}" separator />
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
