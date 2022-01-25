<?php

namespace Dw3nt\ForeUpSdk\Objects;

use Dw3nt\ForeUpSdk\ForeUp;

class AbstractObject 
{
    protected $client;

    public function __construct(ForeUp $client)
    {
        $this->client = $client;
    }
}