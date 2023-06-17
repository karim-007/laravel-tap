<?php

namespace Karim007\LaravelTap\Traits;
trait Helpers
{

    protected function getUrlToken($url,$refresh_token=null, $account=null)
    {
        $grand_type = "password";
        $username = config("tap.username$account");
        $password = config("tap.password$account");

        $url = $this->baseUrl.$url."?grant_type=$grand_type&username=$username&password=$password";

        $auth_token = 'Basic '.config("tap.auth_token$account");
        $header = array(
            'Content-Type: application/json',//x-www-form-urlencoded
            "Authorization: $auth_token",
        );
        $url = curl_init($url);
        curl_setopt($url,CURLOPT_HTTPHEADER, $header);
        curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

        $resultdata = curl_exec($url);
        curl_close($url);
        return json_decode($resultdata);
    }

    protected function getUrl($url, $method, $account=null)
    {
        $response = $this->getToken($account);
        if (isset($response->access_token)){
            $url = curl_init($this->baseUrl.$url);
            $header = array(
                'Content-Type:application/json',
                "authorization: Bearer $response->access_token",
            );
            curl_setopt($url, CURLOPT_HTTPHEADER, $header);
            curl_setopt($url, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            $resultdata = curl_exec($url);
            curl_close($url);
            return json_decode($resultdata, true);
        }
        return  response()->json(['status'=>'Unauthorized','message'=>'Your provided credential are invalid']);

    }


    protected function getToken($account=null)
    {
        return $this->getUrlToken('/oauth/token',null, $account);
    }
}
