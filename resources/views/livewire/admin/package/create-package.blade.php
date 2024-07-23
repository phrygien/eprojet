<div>
    <x-form wire:submit="save">
        {{--  Basic section  --}}
        <div class="lg:grid grid-cols-5">
            <div class="col-span-2">
                <x-header title="Basic" subtitle="Basic info from pack" size="text-2xl" />
            </div>
            <div class="col-span-3 grid gap-3">
                <x-input label="Nom Pack" wire:model="name" />
                <x-input label="Description" wire:model="description" />
                <x-input label="Prix Pack" wire:model="price" prefix="AR" inline />
                <x-input label="Max Utilisateurs" wire:model="max_user" type="number" />
                <x-input label="Max Eleves" wire:model="max_student" type="number" />
            </div>
        </div>

        {{--  Details section --}}
        <hr class="my-5" />

        <div class="lg:grid grid-cols-5">
            <div class="col-span-2">
                <x-header title="Modules" subtitle="More about the permission for this pack" size="text-2xl" />
            </div>
            <div class="col-span-3 grid gap-3">
                <x-choices-offline
                    label="Permissions"
                    wire:model="allpermissions"
                    :options="$allpermissions"
                    searchable />
                {{-- @foreach ($allpermissions as $permission)
                <label>
                    <input type="checkbox" wire:model="permissions" value="{{ $permission->id }}">
                    {{ $permission->name }}
                </label>
            @endforeach --}}
            </div>
        </div>

        <x-slot:actions>
            <x-button label="Annuler" link="/users" />
            <x-button label="Valider" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
    </x-form>

    {{-- <x-form wire:submit="save">
        <x-input label="Nom Pack" wire:model="name" />
        <x-input label="Description" wire:model="description" />
        <x-input label="Prix Pack" wire:model="price" prefix="AR" inline />
        <x-input label="Max Utilisateurs" wire:model="max_user" type="number" />
        <x-input label="Max Eleves" wire:model="max_student" type="number" />
        <div>
            <h4>Permissions</h4>
            @foreach ($allpermissions as $permission)
                <label>
                    <input type="checkbox" wire:model="permissions" value="{{ $permission->id }}">
                    {{ $permission->name }}
                </label>
            @endforeach
            @error('permissions') <span class="error">{{ $message }}</span> @enderror
        </div>
        <x-slot:actions>
            <x-button label="Cancel" link="/users" />
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
    </x-form> --}}
</div>
