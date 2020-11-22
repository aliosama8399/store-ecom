<?php

namespace App\Http\Services;


use App\Models\User;
use App\Models\User_verfication;
use Illuminate\Support\Facades\Auth;
use Request;

class VerificationServices
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    public function setVerificationCode($data)
    {
        $code = mt_rand(100000, 999999);
        $data['code'] = $code;
        User_verfication::whereNotNull('user_id')->where(['user_id' => $data['user_id']])->delete();
        return User_verfication::create($data);

    }

    public function getSMSVerifyMessageByAppName($code)
    {
        $message = "IS Your verfication code";
        return $code . $message;
    }

    public function checkOTPCode($code)
    {
        if (Auth::guard()->check()) {
            $verfication = User_verfication::where('user_id', Auth::id())->first();

            if ($verfication->code == $code) {
                User::whereId(Auth::id())->update(['email_verified_at' => now()]);
                return true;
            } else
                return false;


        }
    }

    public function remveOTPCode($code)
    {
        User_verfication::where('code', $code)->delete();
    }
}
