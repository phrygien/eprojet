<?php

use Livewire\Volt\Component;
use App\Services\API;
use App\Models\Abonnement;
use App\Models\Transaction;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $this->amount = intval($abonnement->amount_total);
        $this->phone = "343500004";//$abonnement->user->phone;
        $this->description = $abonnement->role->name;
        $this->fill($this->abonnement);
    }

    public function newDateMvola(){
        $milliseconds = microtime(true);
    	$timestamp = floor($milliseconds);
		$uuuu = preg_replace("/\d+\./", "", "$milliseconds");
		$u = substr($uuuu, 0, 3);
		return date("Y-m-d\TH:i:s", $timestamp). ".{$u}Z";
    }

    // submit payement
    public function getPaiement(){

        DB::beginTransaction();
        $num_transaction = Transaction::genererNumeroTransaction();
        try{

            $partenaire_id = 1;
            $abonnementId = $this->abonnementId;
            $numero_tel_telma = $this->phone;
            $clien_id = Auth::user()->id;

            $montantInfoPayement = 0;
            $num_transaction = Transaction::genererNumeroTransaction();
            //recuperation de la commande
            $abonnement = Abonnement::where('id', $abonnementId)->where('statut', 0)->where('is_active', 0)->first();

            if($abonnement){
                //verification du montant
                $montant_detail = $this->amount;
                if($montant_detail == 0 || $montant_detail == null){
                    $this->warning("Veuillez verifier votre achat, le détail de votre commande est incorrect");
                }else{

                    if($abonnement->role->price == $montant_detail){

                        $paiement = new Transaction();
                        $paiement->numero_transaction = $num_transaction;
                        $paiement->date_transac = now();
                        $paiement->num_transac_partenaire = null;
                        $paiement->partenaire_id = $partenaire_id;
                        $paiement->abonnement_id = $abonnementId;
                        $paiement->user_id = $clien_id;
                        $paiement->montant = $abonnement->role->price;
                        $paiement->status = 0;
                        $paiement->save();

                        $montantInfoPayement = intval($abonnement->role->price);
                        //--------------//
                        //   using api  //
                        //--------------//

                        $api = new API();
                        $dt = $this->newDateMvola();

                        $infopaiemet = $api->sendRequestPayement($numero_tel_telma, $montantInfoPayement, "Paiement Mvola", $dt, $num_transaction);

                        $infopaiemet = json_decode($infopaiemet, true);

                        if(!isset($infopaiemet["errorCode"]) && isset($infopaiemet["status"])){
                            if($infopaiemet["status"]=="pending"){

                                $paiement->mpgw_token = $infopaiemet['serverCorrelationId'];
                                $paiement->commentaire = "paiement effectue avec succes";
                                $paiement->save();

                                DB::commit();
                                 // Appel à ipn() pour vérifier le statut du paiement
                                // $this->ipn(new Request([
                                //     'transactionStatus' => $infopaiemet['status'],
                                //     'serverCorrelationId' => $infopaiemet['serverCorrelationId'],
                                //     'transactionReference' => $num_transaction,
                                //     'requestDate' => $dt,
                                //     'debitParty' => [['value' => $numero_tel_telma]],
                                //     'creditParty' => [['value' => env('MVOLA_V2_TEL_A_CREDITER')]]
                                // ]));
                                $this->success('paiement effectue avec succes');
                            }else{
                                $paiement->status = -1;
                                $paiement->commentaire = "information envoyée invalide niveau telma";
                                $paiement->save();
                                DB::commit();
                               $this->warning('not_valid');
                            }
                        }else{
                            $paiement->status = -1;
                            $paiement->commentaire = "information envoyée invalide niveau telma";
                            $paiement->save();
                            DB::commit();
                            $this->warning('not_valid');
                        }

                    }else{
                        DB::commit();
                        $this->warning('montant incorrect');
                    }
                }

            }else{
                DB::commit();
                $this->warning('abonnement introuvable');
            }

        }catch(\Exception $e){
            DB::rollBack();
            $this->error('erreur payment');
        }
    }


    function ipn(Request $request){

        DB::beginTransaction();

        $req = $request->all();

        $transactionStatus = $req['transactionStatus'];
        $serverCorrelationId = $req['serverCorrelationId'];
        $transactionReference = $req['transactionReference'];
        $requestDate = $req['requestDate'];
        $debitTel = $req['debitParty'][0]["value"];
        $creditTel = $req['creditParty'][0]["value"];

        $transaction = Transaction::where("mpgw_token", $serverCorrelationId)->first();
        dd($transactionStatus);
        if($serverCorrelationId != null){
            if($transactionStatus == "completed"){
                //recuperation de la commande
                $abonnement = Abonnement::where('id', $abonnement_id)->first();
                $abonnement_id = $transaction->abonnement_id;


                dd($abonnement);
                //mise a jour de la transaction
                $transaction->status = 1;
                $transaction->num_transac_partenaire = $transactionReference;
                $transaction->commentaire = "paiement success";
                $transaction->save();

                //mise a jour de la commande
                $abonnement->statut = 1;
                $abonnement->is_active = 1;
                $abonnement->date_debut = now();
                $abonnement->date_fin =now()->addMonths(1);
                $abonnement->save();

                DB::commit();

                return dd($abonnement);
                // return redirect(env('LINK_ESPACE_CLIENT')."/app/retourfacture?retour=".$transaction->commande_id);

            }else{
                //echec de la transaction
                $transaction->status = -1;
                $transaction->commentaire = "echec paiement telma";
                $transaction->save();
                DB::commit();
                return redirect(env('LINK_ESPACE_CLIENT')."/app/facture?reload=1");
            }
        }else{
            DB::rollBack();
            return redirect(env('LINK_ESPACE_CLIENT')."/app/facture?reload=1");
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
                                                Prix : {{ $abonnement->role->price }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <a href="/products/2" wire:navigate="">
                                    <div class="flex items-center gap-3 py-3 mary-hideable">
                                        <div class="badge badge-neutral">
                                            {{ $abonnement->duree }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <hr class="my-5">

                        <div class="flex items-center justify-between mx-3">
                            <div>Montant total à payer</div>
                            <div class="text-lg font-black">{{ $abonnement->amount_total }} MGA</div>
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
                                    Payment
                                </div>
                            </div>
                        </div>
                        <hr class="mt-3">
                    </div>
                    <div>
                        <x-form wire:submit="getPaiement">
                            <x-input label="Your Phone" wire:model="phone" disabled />
                            <x-input label="Montant" wire:model="amount" disabled />
                            <x-input label="Description" wire:model="description" disabled />
                            <x-input label="" wire:model="abonnementId" hidden />

                            <x-slot:actions>
                                <x-button label="Cancel" />
                                <x-button label="Payer" class="btn-primary" type="submit" spinner="getPaiement" />
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
