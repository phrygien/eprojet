<?php

use Livewire\Volt\Component;
use App\Models\Permission;
use App\Models\Role;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    #[Rule('required')]
    public string $name = '';

    #[Rule('required')]
    public string $price = '';

    // Optional
    #[Rule('sometimes')]
    public ?string $description = null;

    #[Rule('required')]
    public string $max_user = '';

    #[Rule('required')]
    public string $max_student = '';

    #[Rule('required')]
    public array $my_permissions = [];

    public function save()
    {
        $data = $this->validate();
        $role = Role::create($data);
        // Sync selection
        $role->permissions()->sync($this->my_permissions);
        $this->success('Role Created.', redirectTo: '/advanced/roles');
    }

    public function with(): array
    {
        return [
            'permissions' => Permission::all(), // Available permissions
        ];
    }

}; ?>

<div>
    <x-header title="Crée Role" subtitle="Nouvelle Plans de Tarification les abonnements" separator />
    <div class="grid gap-5 lg:grid-cols-2">
        <div>
            <x-form wire:submit="save">
                <x-input label="Role Name" wire:model="name" />
                <x-input label="Price" wire:model="price" />
                <x-input label="User Max" wire:model="max_user" />
                <x-input label="Student Max" wire:model="max_student"  type="number" chevron/>
                <x-choices-offline label="My Permissions" wire:model="my_permissions" :options="$permissions" searchable />
                <x-textarea
                label="Role Description"
                wire:model="description"
                placeholder="Your story ..."
                hint="Max 1000 chars"
                rows="5" />
                <x-slot:actions>
                    <x-button label="Annuler" link="/advanced/roles" />
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
