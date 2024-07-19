<?php

namespace App\Livewire\Pricings;

use App\Models\Abonnement;
use App\Models\Role as Pricing;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

class Souscription extends Component
{
    use Toast;

    public Pricing $pricing;
    public bool $myModal2 = false;

    #[Validate('required|max:10|min:4')]
    public string $domain_name;

    public function mount(Pricing $pricing): void
    {
        $this->pricing = $pricing;
    }

    public function generateDomainName(){
        do {
            $domainName = strtolower(Str::random(8));
        } while (Abonnement::where('domain_name', $domainName)->exists());
        $this->domain_name = $domainName;
    }

    public function render()
    {
        return view('livewire.pricings.souscription');
    }

    public function save()
    {
        $this->validate();
        $user = Auth::user();
        // verification si un domain est deja existant
        $domain = Abonnement::where('domain_name', $this->domain_name)->first();
        if ($domain) {
            $this->warning('Domaine non disponible !');
            return;
            $this->myModal2 = false;
        }

        //verification si un abonnement dans la meme pricing est deja existant mais non actif
        $abonnement = Abonnement::where('user_id', $user->id)->where('role_id', $this->pricing->id)->where('is_active', false)->first();
        if ($abonnement) {
            $this->warning('Vous avez deja une souscription non active sur ce plan !');
            return;
        }

        Abonnement::create([
            'numero_abonnement' => Str::upper( Str::random(8)),
            'user_id' => $user->id,
            'role_id' => $this->pricing->id,
            'debut' => now(),
            'fin' => now()->addYear(),
            'statut' => 0,
            'is_active' => false,
            'domain_name' => $this->domain_name,
        ]);

        $this->myModal2 = false;
        $this->success('Souscription effectuee avec succes !');
    }
}
