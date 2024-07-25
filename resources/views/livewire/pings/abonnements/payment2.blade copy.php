<?php

use Livewire\Volt\Component;
use App\Services\MVolaService;
use App\Models\Abonnement;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Log;
use Mary\Traits\Toast;
new class extends Component {
    use Toast;

    public Abonnement $abonnement;
    #[Rule('required')]
    public $amount;
    #[Rule('required')]
    public $phone;
    #[Rule('required')]
    public $description;
    #[Rule('required')]
    public $abonnementId;

    public $serverCorrelationId;

    public function mount(Abonnement $abonnement): void
    {
        $this->abonnement = $abonnement;
        $this->abonnementId = $abonnement->id;
        $this->amount = 10000;
        $this->phone = "0343500004";//$abonnement->user->phone;
        $this->description = $abonnement->role->name;
        $this->fill($this->abonnement);
    }

    // submit payement
    public function submitPayment()
    {
        $this->validate();

        try{
            $mvolaService = new MVolaService();
            $response = $mvolaService->pay($this->amount, $this->phone, $this->description);
            //dd($response);
            if ($response['status'] == 'pending') {
                $this->serverCorrelationId = $response['serverCorrelationId'];
                $this->checkTransactionStatus();
                //$this->success('Payment successful');
            } else {
                $this->error('Payment echoué');
            }
        }catch(\Exception $e){
            dd($e);
            Log::error('MVola Payment Error: ' . $e->getMessage());
           $this->error('Payment failed: ' . $e->getMessage());
        }
    }

    public function checkTransactionStatus()
    {
        try {
            $mvolaService = new MVolaService();
            $response = $mvolaService->checkTransactionStatus($this->serverCorrelationId);

            if ($response['status'] == 'success') {
                $abonnement = Abonnement::find($this->abonnementId);
                if ($abonnement) {
                    $abonnement->statut = 'payé';
                    $abonnement->save();
                }
                session()->flash('message', 'Payment successful: ' . print_r($response, true));
            } elseif ($response['status'] == 'failed') {
                session()->flash('error', 'Payment failed: ' . print_r($response, true));
            } else {
                // Si la transaction est toujours en attente, re-vérifie après un délai
                $this->dispatchBrowserEvent('pollTransactionStatus', ['timeout' => 5000]);
            }
        } catch (\Exception $e) {
            Log::error('MVola Transaction Status Error: ' . $e->getMessage());
            session()->flash('error', 'Payment status check failed: ' . $e->getMessage());
        }
    }

}; ?>

<div>
    <div class="w-full p-5 mx-auto drawer-content lg:p-10">
        <div class="grid gap-10 lg:grid-cols-8">

            <div class="lg:col-span-2">
                <img src="https://orange.mary-ui.com/images/checkout.png" width="300" class="mx-auto">
            </div>

            <div class="lg:col-span-3">
                <div class="p-5 rounded-lg card bg-base-100">
                    <div class="pb-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-2xl font-bold ">
                                    {{ $abonnement->role->name }}
                                </div>
                            </div>
                        </div>
                        <hr class="mt-3">
                    </div>
                    <div>
                        <div>
                            <div class="flex items-center justify-start gap-4 px-3 cursor-pointer hover:bg-base-200/50">
                                <div>
                                    <a href="/products/2" wire:navigate="">
                                        <div class="py-3">
                                            <div class="avatar">
                                                <div class="rounded-full w-11">
                                                    <img src="https://orange.mary-ui.com/storage/products/2.jpg">
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div
                                    class="flex-1 w-0 overflow-hidden truncate whitespace-nowrap text-ellipsis mary-hideable">
                                    <a href="/products/2" wire:navigate="">
                                        <div class="py-3">
                                            <div class="font-semibold truncate">
                                                Macbook Air 2020
                                            </div>

                                            <div class="text-sm text-gray-400 truncate">
                                                {{ $abonnement->role->price }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <a href="/products/2" wire:navigate="">
                                    <div class="flex items-center gap-3 py-3 mary-hideable">
                                        <div class="badge badge-neutral">
                                            1
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <hr class="my-5">

                        <div class="flex items-center justify-between mx-3">
                            <div>Montant à payer</div>
                            <div class="text-lg font-black">{{ $abonnement->role->price }} MGA</div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="lg:col-span-3">
                <div class="p-5 rounded-lg card bg-base-100">
                    <div class="pb-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-2xl font-bold ">
                                    Payment Mvola
                                </div>
                            </div>
                        </div>
                        <hr class="mt-3">
                    </div>
                    <div>
                        <x-form wire:submit="submitPayment">
                            <x-input label="Your Phone" wire:model="phone" disabled />
                            <x-input label="Montant" wire:model="amount" disabled />
                            <x-input label="Description" wire:model="description" disabled />
                            <x-input label="" wire:model="abonnementId" hidden />

                            <x-slot:actions>
                                <x-button label="Cancel" />
                                <x-button label="Payer" class="btn-primary" type="submit" spinner="submitPayment" />
                            </x-slot:actions>
                        </x-form>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex mt-20">
            <a href="/support-us" wire:key="00780c6e001be6437dd1c8fe3e7c0f7a" class="normal-case btn btn-ghost"
                type="button" wire:navigate="">

                <!-- SPINNER LEFT -->

                <!-- ICON -->
                <span class="block">
                    <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"></path>
                    </svg>
                </span>

                <!-- LABEL / SLOT -->
                <span class="">
                    Source code
                </span>

                <!-- ICON RIGHT -->

                <!-- SPINNER RIGHT -->

            </a>

            <!--  Force tailwind compile tooltip classes   -->
            <span class="hidden">
                <span class="lg:tooltip lg:tooltip-left lg:tooltip-right lg:tooltip-bottom lg:tooltip-top"></span>
            </span> <a href="https://mary-ui.com" wire:key="7d3df731b46ee3bf901beda1a711ec22"
                class="btn normal-case btn-ghost !text-pink-500" type="button" target="_blank">

                <!-- SPINNER LEFT -->

                <!-- ICON -->
                <span class="block">
                    <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z">
                        </path>
                    </svg>
                </span>

                <!-- LABEL / SLOT -->
                <span class="">
                    Built with MaryUI
                </span>

                <!-- ICON RIGHT -->

                <!-- SPINNER RIGHT -->

            </a>

            <!--  Force tailwind compile tooltip classes   -->
            <span class="hidden">
                <span class="lg:tooltip lg:tooltip-left lg:tooltip-right lg:tooltip-bottom lg:tooltip-top"></span>
            </span>
        </div>
    </div>
</div>
