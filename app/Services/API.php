<?php

namespace App\Services;

class API{

    public function getToken(){

        $consumerKey = env('MVOLA_V2_CONSUMER_KEY');
        $consumerSecret = env('MVOLA_V2_CONSUMER_SECRET');

        $base_url = env('MVOLA_V2_URL_TOKEN'); //"https://devapi.mvola.mg/token";
        $secret_key = base64_encode($consumerKey.":".$consumerSecret);

        $resp 	= null;
        $curl = curl_init($base_url);
        curl_setopt($curl, CURLOPT_URL, $base_url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
           "Content-Type: application/x-www-form-urlencoded",
           "Authorization: Basic ".$secret_key,
           "Cache-Control: no-cache",
           "Accept: */*",
           "Connection: keep-alive"
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = "grant_type=client_credentials&scope=EXT_INT_MVOLA_SCOPE";

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        return $resp;

    }

    public function sendRequestPayement($debitTelephone, $amount, $label, $datetime, $numTransaction){

        $base_url = env('MVOLA_V2_URL_PAYEMENT');
        $version = env('MVOLA_V2_URL_VERSION');
        $language = env('MVOLA_V2_URL_LANGUAGE');
        $currency = env('MVOLA_V2_URL_CURRENCY');
        $creditTelephone = env('MVOLA_V2_TEL_A_CREDITER');
        $callback = env('MVOLA_V2_URL_CALL_BACK');

        $token = $this->getToken();
        $token = json_decode($token, true);
        $token = $token["access_token"];

        $resp 	= null;
        $curl = curl_init($base_url);
        curl_setopt($curl, CURLOPT_URL, $base_url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
           "Content-Type: application/json",
           "Authorization: Bearer ".$token,
           "Cache-Control: no-cache",
           "Accept: */*",
           "Connection: keep-alive",
           "Version: ".$version,
           "X-CorrelationID: ".$numTransaction,
           "UserLanguage: ".$language,
           "UserAccountIdentifier: msidsdn;0".$creditTelephone,
           "partnerName: JIRAMA",
           "X-Callback-URL: ".$callback
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = '{
            "amount": "'.$amount.'",
            "currency": "'.$currency.'",
            "descriptionText": "'.$label.'",
            "requestDate": "'.$datetime.'",
            "debitParty": [
              {
                "key": "msisdn",
                "value": "0'.$debitTelephone.'"
              }
            ],
            "creditParty": [
              {
                "key": "msisdn",
                "value": "0'.$creditTelephone.'"
              }
            ],
            "metadata": [
              {
                "key": "partnerName",
                "value": "JIRAMA"
              }
            ],
            "requestingOrganisationTransactionReference": "'.$numTransaction.'",
            "originalTransactionReference": "'.$numTransaction.'"
          }';

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        return $resp;

    }

    public function checkPayement($serverCorrelationId){
      $base_url = env('MVOLA_V2_URL_CHECK_TRANSACTION');
      $version = env('MVOLA_V2_URL_VERSION');
      $language = env('MVOLA_V2_URL_LANGUAGE');
      $currency = env('MVOLA_V2_URL_CURRENCY');
      $creditTelephone = env('MVOLA_V2_TEL_A_CREDITER');
      $callback = env('MVOLA_V2_URL_CALL_BACK');

      $token = $this->getToken();
      $token = json_decode($token, true);
      $token = $token["access_token"];

      $resp 	= null;
      $curl = curl_init($base_url.$serverCorrelationId);
      curl_setopt($curl, CURLOPT_URL, $base_url.$serverCorrelationId);
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

      $headers = array(
          "Content-Type: application/json",
          "Authorization: Bearer ".$token,
          "Cache-Control: no-cache",
          "Version: ".$version,
          "X-CorrelationID: ".uniqid(),
          "UserLanguage: ".$language,
          "UserAccountIdentifier: msidsdn;0".$creditTelephone,
          "partnerName: EPING"
      );
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

      $data = '';
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

      $resp = curl_exec($curl);
      curl_close($curl);

      return $resp;
    }
}

