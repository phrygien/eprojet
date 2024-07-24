<?php

use Livewire\Volt\Component;
use App\Services\MVolaService;
use App\Models\Abonnement;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Log;
use Mary\Traits\Toast;
new class extends Component {
    use Toast;

    #[Rule('required')]
    public $amount;
    #[Rule('required')]
    public $phone;
    #[Rule('required')]
    public $description;
    #[Rule('required')]
    public $abonnementId;

    // submit payement
    public function submitPayment()
    {
        $this->validate();

        try{
            $mvolaService = new MVolaService();
            $response = $mvolaService->pay($this->amount, $this->phone, $this->description);
            dd($response);
            if ($responsa['status'] == 'success') {
                $this->success('Payment successful');
            } else {
                $this->error('Payment failed');
            }
        }catch(\Exception $e){
            Log::error('MVola Payment Error: ' . $e->getMessage());
           $this->error('Payment failed: ' . $e->getMessage());
        }
    }
}; ?>

<div>
    <x-form wire:submit="submitPayment">
        <x-input label="Your Phone" wire:model="phone" />
        <x-input label="Montant" wire:model="amount" />
        <x-input label="Description" wire:model="description" />
        <x-input label="Abonnement ID" wire:model="abonnementId" />

        <x-slot:actions>
            <x-button label="Cancel" />
            <x-button label="Payer" class="btn-primary" type="submit" spinner="submitPayment" />
        </x-slot:actions>
    </x-form>
</div>
