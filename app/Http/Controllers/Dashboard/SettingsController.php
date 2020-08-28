<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function editShipping($type)
    {
        if ($type === 'free') {
           $shippingmethod = Setting::where('key', 'free_shipping_label')->first();
        } elseif ($type === 'inner') {
            $shippingmethod = Setting::where('key', 'local_label')->first();
        } elseif ($type === 'outer') {
            $shippingmethod = Setting::where('key', 'outer_label')->first();
        } else {
            return  $shippingmethod = Setting::where('key', 'free_shipping_label')->first();

        }

        return view('dashboard.settings.shippings.edit',compact('shippingmethod'));

    }

    public function updateShipping(Request $request, $id)
    {
        return $request;
    }
}
