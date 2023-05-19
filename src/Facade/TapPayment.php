<?php

namespace Karim007\LaravelTap\Facade;
use Illuminate\Support\Facades\Facade;

/**
 * @method static tPayment($request_data_json, $account=1)
 * @method static validatePayment($transactionId, $account=1)
 * @method static checkTransaction($requestorReferenceId, $account=1)
 * @method static success($message,$transId)
 * @method static cancel($message,$transId=null)
 * @method static failure($message,$transId=null)
 */
class TapPayment extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tappayment';
    }
}
