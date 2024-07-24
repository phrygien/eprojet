<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Abonnement;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
class MVolaCallbackController extends Controller
{
    public function handleCallback(Request $request)
    {
        Log::info('MVola Callback received', $request->all());

        // Traite le callback ici
        $transactionStatus = $request->input('status');
        $transactionId = $request->input('transactionId');
        $abonnementId = $request->input('abonnementId');

        if ($transactionStatus === 'success') {
            $abonnement = Abonnement::find($abonnementId);
            if ($abonnement) {
                $abonnement->statut = 'payé';
                $abonnement->save();
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
