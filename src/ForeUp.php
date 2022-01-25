<?php

namespace Dw3nt\ForeUpSdk;

use \GuzzleHttp\Client;

class ForeUp
{
    private $token;
    private $httpClient;
    private $baseUri = "https://api.foreupsoftware.com/api_rest/index.php/";

    public function __construct()
    {  
        $data = $this->createNewToken([
            'email' => $this->getSdkEnv("FORE_UP_USER"),
            'password' => $this->getSdkEnv("FORE_UP_PASSWORD")
        ]);

        $this->token = $data['data']['id'];
    }

    public function getHttpClient()
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

    public function createNewToken($bodyData)
    {
        $client = new Client();
        $url = $this->baseUri . "tokens";
        $response = $client->request('POST', $url, [
            'form_params' => $bodyData
        ]);
        return json_decode($response->getBody(), true);
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

    public function getSdkEnv($key = "") 
    {
        $env = file_get_contents(__DIR__ . "/../.env");
        $data = explode("\n", $env);
        $keys = array_map(fn ($line) => explode('=', $line)[0], $data);
        $values = array_map(fn ($line) => explode('=', $line)[1], $data);
        $data = array_combine($keys, $values);

        if (array_key_exists($key, $data)) {
            return $data[$key];
        }

        return "";
    }
}