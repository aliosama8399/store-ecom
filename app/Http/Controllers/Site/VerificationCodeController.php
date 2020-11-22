<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerificationRequest;
use App\Http\Services\VerificationServices;
use Illuminate\Http\Request;

class VerificationCodeController extends Controller
{
    public $verficationService;

    public function __construct(VerificationServices $vf)
    {
        $this->verficationService = $vf;
    }

    public function verify(VerificationRequest $request)
    {
        $check = $this->verficationService->checkOTPCode($request->code);
        if (!$check) {
            return redirect()->route('get.verification.form')->withErrors(['code'=>'you enter wrong code']);
        } else {
           $this ->verficationService->remveOTPCode($request->code);
            return redirect()->route('home');
        }
    }

    public function getVerifiedPage()
    {
        return view('auth.verification');

    }
}
