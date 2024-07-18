<?php

namespace App\Livewire\Admin\Package;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Mary\Traits\Toast;

class CreatePackage extends Component
{
    use Toast;

    public $allpermissions = [];
    public $permissions = [];

    #[Validate(['required'])]
    public string $name;

    #[Validate(['required'])]
    public string $description;

    #[Validate(['required'])]
    public $price;

    #[Validate(['required'])]
    public string $max_user;

    #[Validate(['required'])]
    public string $max_student;

    public function mount(): void
    {
        $this->allpermissions = Permission::all();
    }
    public function render()
    {
        return view('livewire.admin.package.create-package');
    }

    public function save()
    {
        $this->validate();
        $package = new Role();
        $package->name = $this->name;
        $package->description = $this->description;
        $package->price = $this->price;
        $package->max_user = $this->max_user;
        $package->max_student = $this->max_student;
        $package->save();
        $package->permissions()->sync($this->permissions);

        $this->reset();

        $this->success('Pack Created !');
    }
}
