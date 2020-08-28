<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingsRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            return $shippingmethod = Setting::where('key', 'free_shipping_label')->first();

        }

        return view('dashboard.settings.shippings.edit', compact('shippingmethod'));

    }

    public function updateShipping(ShippingsRequest $request, $id)
    {

        try {


            $shippingmethod = Setting::find($id);
            DB::beginTransaction();
            $shippingmethod->update(['plain_value' => $request->plain_value]);
            $shippingmethod->value = $request->value;
            $shippingmethod->save();
            DB::commit();
            return redirect()->back()->with(['success' => __('messages.success')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('messages.error')]);

            DB::rollBack();

        }
    }
}
