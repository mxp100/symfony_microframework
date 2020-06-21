<?php


namespace App\Services;


use GuzzleHttp\Client;

class PaymentService
{
    public function checkPayment()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://ya.ru');
        return $res->getStatusCode() == 200;
    }
}