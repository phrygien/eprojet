<?php

namespace App\Livewire\Pricings;

use App\Models\Role as Pricing;
use Livewire\Component;

class Souscription extends Component
{
    public Pricing $pricing;

    public function mount(Pricing $pricing): void
    {
        $this->pricing = $pricing;
    }

    public function render()
    {
        return view('livewire.pricings.souscription');
    }
}
