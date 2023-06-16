<?php

namespace Karim007\LaravelTap\Payment;

use Karim007\LaravelTap\Traits\Helpers;

class TapBaseApi
{
    use Helpers;

    /**
     * @var string $baseUrl
     */
    protected $baseUrl;

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
        } else {
            $this->baseUrl = 'https://auth-prod.tadlbd.com';
        }
    }

    /**
     * bkash Request Headers
     *
     * @return array
     */
    protected function headers()
    {
        return [
            "Content-Type"     => "application/json",
            "X-KM-IP-V4"       => $this->getIp(),
            "X-KM-Api-Version" => "v-0.2.0",
            "X-KM-Client-Type" => "PC_WEB",
        ];
    }
}
