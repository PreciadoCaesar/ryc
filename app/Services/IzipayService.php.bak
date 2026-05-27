<?php

namespace App\Services;

require_once base_path('vendor/lyracom/rest-php-sdk/src/autoload.php');

use Lyra\Client;

class IzipayService
{
    protected Client $client;

    public function __construct()
    {
        Client::setDefaultEndpoint(config('izipay.endpoint'));
        Client::setDefaultUsername(config('izipay.username'));
        Client::setDefaultPassword(config('izipay.password'));
        Client::setDefaultPublicKey(config('izipay.public_key'));
        Client::setdefaultSHA256Key(config('izipay.sha256_key'));

        $this->client = new Client();
    }

    public function getPublicKey(): string
    {
        return $this->client->getPublicKey();
    }

    public function getClientEndpoint(): string
    {
        return $this->client->getClientEndpoint();
    }

    public function generateFormToken(array $params): string
    {
        $store = [
            'amount' => $params['amount'],
            'currency' => 'PEN',
            'orderId' => $params['orderId'],
            'customer' => [
                'email' => $params['email'],
                'reference' => $params['customerId'] ?? '',
                'billingDetails' => [
                    'firstName' => $params['firstName'] ?? '',
                    'lastName' => $params['lastName'] ?? '',
                    'phoneNumber' => $params['phone'] ?? '',
                    'identityType' => $params['identityType'] ?? 'DNI',
                    'identityCode' => $params['identityCode'] ?? '',
                ],
            ],
        ];

        $response = $this->client->post('V4/Charge/CreatePayment', $store);

        if (($response['status'] ?? '') !== 'SUCCESS') {
            $error = $response['answer']['errorMessage'] ?? 'Error desconocido';
            throw new \Exception("Izipay: {$error}");
        }

        return $response['answer']['formToken'];
    }

    public function verifyHash(): bool
    {
        try {
            return $this->client->checkHash();
        } catch (\Throwable) {
            return false;
        }
    }
}
