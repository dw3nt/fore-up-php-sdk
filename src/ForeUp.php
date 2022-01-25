<?php

namespace Dw3nt\ForeUpSdk;

use \GuzzleHttp\Client;

class ForeUp
{
    private $token;
    private $httpClient;
    private $baseUri = "https://api.foreupsoftware.com/api_rest/index.php/";

    public function __construct($config = [])
    {  
        $data = $this->createNewToken([
            'email' => array_key_exists("email", $config) ? $config["email"] : "",
            'password' => array_key_exists("password", $config) ? $config["password"] : ""
        ]);

        $this->token = $data['data']['id'];
    }

    public function customers() 
    {
        return new \Dw3nt\ForeUpSdk\Objects\Customer($this);
    }

    public function request($method, $uri, $params = []) 
    {
        $client = $this->getHttpClient();
        return $client->request($method, $this->baseUri . $uri, $params);
    }

    private function getHttpClient()
    {
        if (!$this->httpClient) {
            $this->httpClient = new Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-authorization' => 'Bearer ' . $this->token
                ]
            ]);
        }

        return $this->httpClient;
    }

    private function createNewToken($bodyData)
    {
        $client = new Client();
        $url = $this->baseUri . "tokens";
        $response = $client->request('POST', $url, [
            'form_params' => $bodyData
        ]);
        return json_decode($response->getBody(), true);
    }
}