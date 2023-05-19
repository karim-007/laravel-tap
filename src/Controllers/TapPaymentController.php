<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Karim007\LaravelTap\Facade\TapPayment;

class TapPaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        $inv = uniqid();
        $data['requestorReferenceId'] = $inv;
        $data['amount'] = 10;
        $data['invoiceNumber'] = $inv;
        $data['additionalInformation'] = "Far far away, behind the word mountains";
        $data['callBackUrl'] = config("tap.callbackURL");

        return TapPayment::tPayment($data);
    }

    public function callBack(Request $request)
    {
        if ($request->status == 'completed'){
            $response = TapPayment::validatePayment($request->transactionId);
            //$response = TapPayment::validatePayment($request->transactionId, 1); //last parameter is your account number for multi account its like, 1,2,3,4,cont..
            if (!$response){ //if validatePayment payment not found call checkTransaction
                $response = TapPayment::checkTransaction($request->requestorReferenceId);
                //$response = TapPayment::checkTransaction($request->paymentID,1); //last parameter is your account number for multi account its like, 1,2,3,4,cont..
            }
            if (isset($response['status']) && $response['status'] == "completed") {
                /*
                 * for refund need to store
                 * paymentID and trxID
                 * */
                return TapPayment::success('Thank you for your payment', $response['coreTransactionId']);
            }
            return TapPayment::failure($response['statusMessage']);
        }else if ($request->status == 'cancel'){
            return TapPayment::cancel('Your payment is canceled');
        }else{
            return TapPayment::failure('Your transaction is failed');
        }
    }

}
