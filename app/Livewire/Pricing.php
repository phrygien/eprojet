<?php

namespace App\Livewire;

use App\Models\Role;
use Livewire\Component;

class Pricing extends Component
{
    public $pricings = [];

    public function mount(): void
    {
        $this->pricings = Role::all();
    }

    public function render()
    {
        return view('livewire.pricing');
    }
}
