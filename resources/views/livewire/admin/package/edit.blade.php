<?php

use Livewire\Volt\Component;
use App\Models\Permission;
use App\Models\Role;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public Role $role;

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

    public function mount(): void
    {
        $this->fill($this->role);
        $this->my_permissions = $this->role->permissions->pluck('id')->all();

    }

    public function save()
    {
        $data = $this->validate();

        $this->role->update($data);
        // Sync selection
        $this->role->permissions()->sync($this->my_permissions);
        $this->success('Role updated.', redirectTo: '/advanced/roles');
    }

    public function with(): array
    {
        return [
            'permissions' => Permission::all(), // Available permissions
        ];
    }
}; ?>


<div>
    <x-header title="Update {{ $role->name }}" separator />
    <div class="grid gap-5 lg:grid-cols-2">
        <div>
            <x-form wire:submit="save">
                <x-input label="Nom de la tarification" wire:model="name" />
                <x-input label="Prix / mois" wire:model="price" />
                <x-input label="Maximun d'utilisateur" wire:model="max_user" />
                <x-input label="Nombre d'éleves maximun" wire:model="max_student"  type="number" chevron/>
                <x-choices-offline label="Les Modules" wire:model="my_permissions" :options="$permissions" searchable />
                <x-textarea
                label="Description"
                wire:model="description"
                placeholder="Your story ..."
                hint="Max 1000 chars"
                rows="5" />
                <x-slot:actions>
                    <x-button label="Cancel" link="/advanced/roles" />
                    {{-- The important thing here is `type="submit"` --}}
                    {{-- The spinner property is nice! --}}
                    <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
                </x-slot:actions>
            </x-form>
        </div>
        <div>
            {{-- Get a nice picture from `StorySet` web site --}}
            <img src="https://flow.mary-ui.com/images/edit-form.png" width="300" class="mx-auto" />
        </div>
    </div>
</div>
