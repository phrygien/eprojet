<?php

namespace App\Livewire\Admin\Package;

use App\Models\Role;
use Livewire\Component;

class ListPackage extends Component
{
    public $roles;

    protected $listeners = ['roleUpdated' => 'refreshRoles'];

    public function mount(): void
    {
        $this->refreshRoles();
    }

    public function render()
    {
        return view('livewire.admin.package.list-package');
    }

    public function refreshRoles(): void
    {
        $this->roles = Role::with('permissions')->get();
    }
}
