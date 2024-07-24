<?php

namespace App\Services;

use MVolaphp\Telma as MVola;
use MVolaphp\Money;
use MVolaphp\Objects\{Phone, PayIn, KeyValue};
use MVolaphp\Exception;

class MVolaService
{
    protected $mvola;

    public function __construct()
    {
        $credentials = [
            'client_id' => env('MVOLA_CLIENT_ID'),
            'client_secret' => env('MVOLA_CLIENT_SECRET'),
            'merchant_number' => env('MVOLA_MERCHANT_NUMBER'),
            'production' => env('MVOLA_PRODUCTION'),
            'partner_name' => env('MVOLA_PARTNER_NAME'),
            'lang' => env('MVOLA_LANG'),
        ];

        $cache = storage_path('app/mvola_cache');

        // Create the cache directory if it doesn't exist
        if (!is_dir($cache)) {
            mkdir($cache, 0755, true);
        }

        try {
            $this->mvola = new MVola($credentials, $cache);
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function pay($amount, $payerPhone, $description)
    {
        $payDetails = new PayIn();
        $money = new Money('MGA', $amount);
        $payDetails->amount = $money;

        $debit = new KeyValue();
        $debit->addPairObject(new Phone($payerPhone));
        $payDetails->debitParty = $debit;

        $payDetails->descriptionText = $description;

        $meta = new KeyValue();
        $meta->add('partnerName', env('MVOLA_PARTNER_NAME'));
        $payDetails->metadata = $meta;

        $this->mvola->setCallbackUrl(env('MVOLA_CALLBACK_URL'));

        try {
            $response = $this->mvola->payIn($payDetails);
            return $response;
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
