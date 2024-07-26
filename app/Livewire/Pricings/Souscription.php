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

    #[Validate('required|max:12|min:1')]
    public $dure = 1;

    #[Validate('required')]
    public int $amount_total;

    public $name;
    public $price;
    public $max_user;
    public $max_student;
    public $description;

    public function mount(Pricing $pricing): void
    {
        $this->pricing = $pricing;
        $this->amount_total = $this->pricing->price * $this->dure;
        $this->fill($pricing);
    }

    public function generateDomainName(){
        do {
            $domainName = strtolower(Str::random(8));
        } while (Abonnement::where('domain_name', $domainName)->exists());
        $this->domain_name = $domainName;
    }

    public function render()
    {
        $mois = [
            [
                'id' => 1,
                'name' => '1 Mois',
            ],
            [
                'id' => 2,
                'name' => '2 Mois',
            ],
            [
                'id' => 3,
                'name' => '3 Mois',
            ],
            [
                'id' => 4,
                'name' => '4 Mois',
            ],
            [
                'id' => 5,
                'name' => '5 Mois',
            ],
            [
                'id' => 6,
                'name' => '6 Mois',
            ],
            [
                'id' => 7,
                'name' => '7 Mois',
            ],
            [
                'id' => 8,
                'name' => '8 Mois',
            ],
            [
                'id' => 9,
                'name' => '9 Mois',
            ],
            [
                'id' => 10,
                'name' => '10 Mois',
            ],
            [
                'id' => 11,
                'name' => '11 Mois',
            ],
            [
                'id' => 12,
                'name' => '12 Mois',
            ]
        ];
        return view('livewire.pricings.souscription', [
            'mois' => $mois
        ]);
    }

    public function updatedDure($value)
    {
        $this->amount_total = $this->pricing->price * $value;
    }
    public function save()
    {
        $this->validate();
        $user = Auth::user();

        //verification si le client ont une abonnement en cours
        $abonnement = Abonnement::where('user_id', $user->id)->where('is_active', true)->first();
        if ($abonnement) {
            $this->warning('Vous avez deja une abonnement actif !');
            return;
        }

        //verification si un abonnement dans la meme pricing est deja existant actif
        $abonnement = Abonnement::where('user_id', $user->id)->where('role_id', $this->pricing->id)->where('is_active', true)->first();
        if ($abonnement) {
            $this->warning('Vous avez deja une souscription active sur ce plan !');
            return;
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
            'duree' => $this->dure,
            'amount_total' => $this->amount_total,
            'is_active' => false,
        ]);

        $this->myModal2 = false;
        $this->success('Souscription effectuee avec succes !');
    }
}
