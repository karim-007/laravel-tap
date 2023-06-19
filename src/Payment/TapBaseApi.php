<?php

namespace Karim007\LaravelTap\Payment;

class TapBaseApi
{

    /**
     * @var string $baseUrl
     */
    protected $baseUrl;
    protected $baseUrl2;

    public function __construct()
    {
        $this->baseUrl();
    }

    /**
     * bkash Base Url
     * if sandbox is true it will be sandbox url otherwise it is host url
     */
    private function baseUrl()
    {
        if (config("tap.sandbox")) {
            $this->baseUrl = 'https://auth-sandbox.tadlbd.com';
            $this->baseUrl2 = 'https://merchant-pg-sandbox.tadlbd.com';
        } else {
            $this->baseUrl = 'https://auth-prod.tadlbd.com';
            $this->baseUrl2 = 'https://merchant-pg-prod.tadlbd.com';
        }
    }
}
