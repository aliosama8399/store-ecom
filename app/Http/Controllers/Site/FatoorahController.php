<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Services\FatoorahServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FatoorahController extends Controller
{

    /**
     * FatoorahController constructor.
     */
    private $fatoorahServices;

    public function __construct(FatoorahServices $fatoorahServices)
    {
        $this->fatoorahServices = $fatoorahServices;
    }

    public function payOrder()
    {

     $data = [
            "CustomerName" => "ali osama",
            "NotificationOption" => "Lnk",
            "MobileCountryCode" => "965",
            "CustomerMobile" => "0113311606",
            "CustomerEmail" => "mail@company.com",
            "InvoiceValue" => 100,
            "DisplayCurrencyIso" => "kwd",
            "CallBackUrl" => env('success_url'),
            "ErrorUrl" => env('error_url'),
            "Language" => "en",
        ];

        return $this->fatoorahServices->sendPayment($data);
    }

    public function callBack(Request $request)
    {
        $data = [];
        $data['Key'] = $request->payementId;
        $data['KeyType'] = 'paymentId';

      return  $paymentData = $this->fatoorahServices->getPaymentStatus($data);
        // search where invoice id = $paymentData['Data]['InvoiceId];

    }

}
