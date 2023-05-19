<?php

namespace Karim007\LaravelTap\Payment;

use Karim007\LaravelTap\Traits\Helpers;

class TapPayment extends TapBaseApi
{
    use Helpers;

    public function tPayment($data, $account=1, $paymentMode="iFrame")
    {
        if ($account == 1) $account=null;
        else $account="_$account";
        $response = $this->getToken($account);
        if (isset($response->access_token)){
            $data['token'] =$response->access_token;
            $data['authAPIKey'] = config("tap.authAPIKey$account");
            $data['popUpCloseTimeOut'] = 60;
            $data['paymentMode'] = $paymentMode;
            return view('tap::tap-payment',compact('data'))->render();
        }
        return  response()->json(['status'=>'Unauthorized','message'=>'Your provided credential are invalid']);
    }

    public function validatePayment($transactionId, $account=1)
    {
        if ($account == 1) $account=null;
        else $account="_$account";
        return $this->getUrl('/transaction/check-status?transactionId='.$transactionId,'GET',$account);
    }

    public function checkTransaction($requestorReferenceId, $account=1)
    {
        if ($account == 1) $account=null;
        else $account="_$account";
        return $this->getUrl('/transaction/check-status-by-reference?requestorReferenceId='.$requestorReferenceId,'GET',$account);
    }

    public function success($message,$transId)
    {
        return view('tap::success',compact('message','transId'));
    }
    public function cancel($message,$transId=null)
    {
        return view('tap::failed',compact('message','transId'));
    }
    public function failure($message,$transId=null)
    {
        return view('tap::failed',compact('message','transId'));
    }

}