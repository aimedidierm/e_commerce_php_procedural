<?php

class Payment
{
    public function pay($phone, $amount)
    {
        $postData = json_encode(['amount' => $amount, 'number' => $phone]);
        define('BASE_URL', 'https://payments.paypack.rw/api');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => BASE_URL . '/transactions/cashin?Idempotency-Key=OldbBsHAwAdcYalKLXuiMcqRrdEcDGRv',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->getToken(),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
        // { "ref": "cfb424e5-9943-421e-a2aa-7c151cb4da5e", "status": "pending", "amount": 100, "provider": "mtn", "kind": "CASHIN", "created_at": "2023-09-09T14:08:54.253042025Z" }
    }
    private function getToken()
    {
        $clientId = "";
        $clientPassword = "";
        $postData = json_encode(['client_id' => $clientId, 'client_secret' => $clientPassword]);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => BASE_URL . '/auth/agents/authorize',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response)->access;
    }
}
