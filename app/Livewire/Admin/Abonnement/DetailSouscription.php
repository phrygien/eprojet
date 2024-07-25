<?php

namespace App\Livewire\Admin\Abonnement;

use App\Models\Abonnement;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Mary\Traits\Toast;

class DetailSouscription extends Component
{
    use Toast;
    public Abonnement $abonnement;

    #[Validate('required')]
    public $domain_name;

    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $email;

    public $user_id;

    public function mount(Abonnement $abonnement): void
    {
        $this->abonnement = $abonnement;
        $this->domain_name = $abonnement->domain_name;
        $this->name = $abonnement->user->name;
        $this->email = $abonnement->user->email;
        $this->user_id = $abonnement->user_id;
    }

    public function render()
    {
        return view('livewire.admin.abonnement.detail-souscription');
    }

    public function save(): void
    {

        $this->validate();

        //verification si id tenant déjà existe dans la base de données
        $tenant = Tenant::find($this->domain_name);
        if (!$tenant) {
            $tenant = Tenant::create([
                'id' => $this->domain_name,
                'name' => $this->name,
                'email' => $this->email,
                'user_id' => $this->user_id,
            ]);

            $tenant->domains()->create([
                'domain' => $this->domain_name.'.'.config('app.domain'),
            ]);

            $this->abonnement->update([
                'is_active' => true,
                'statut' => 1,
                'debut' => now(),
                'fin' => now()->addMonth(),
            ]);


            $this->success('Souscription activé !');

            $this->redirect(
                url: route('pages:abonnements'),
            );
        }else{

            $this->warning('Domaine non disponible !');
        }

    }
}
