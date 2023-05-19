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
        $data['paymentMode'] = "iFrame";
        $data['invoiceNumber'] = $inv;
        $data['additionalInformation'] = "Far far away, behind the word mountains";
        $data['popUpCloseTimeOut'] = 15;
        $data['callBackUrl'] = config("tap.callbackURL");

        $response =  TapPayment::TPayment($data);
        if (isset($response['bkashURL'])) return redirect()->away($response['bkashURL']);
        else return redirect()->back()->with('error-alert2', $response['statusMessage']);
    }

    public function callBack(Request $request)
    {
        //callback request params
        // paymentID=TR00117B1674409647770&status=success&apiVersion=1.2.0-beta
        //using paymentID find the account number for sending params

        if ($request->status == 'success'){
            $response = TapPayment::executePayment($request->paymentID);
            //$response = BkashPaymentTokenize::executePayment($request->paymentID, 1); //last parameter is your account number for multi account its like, 1,2,3,4,cont..
            if (!$response){ //if executePayment payment not found call queryPayment
                $response = TapPayment::queryPayment($request->paymentID);
                //$response = BkashPaymentTokenize::queryPayment($request->paymentID,1); //last parameter is your account number for multi account its like, 1,2,3,4,cont..
            }

            if (isset($response['statusCode']) && $response['statusCode'] == "0000" && $response['transactionStatus'] == "Completed") {
                /*
                 * for refund need to store
                 * paymentID and trxID
                 * */
                return TapPayment::success('Thank you for your payment', $response['trxID']);
            }
            return TapPayment::failure($response['statusMessage']);
        }else if ($request->status == 'cancel'){
            return TapPayment::cancel('Your payment is canceled');
        }else{
            return TapPayment::failure('Your transaction is failed');
        }
    }

}
