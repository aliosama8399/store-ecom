<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralProductRequest;
use App\Http\Requests\OptionsRequest;
use App\Http\Requests\ProductImagesRequest;
use App\Http\Requests\ProductPriceRequest;
use App\Http\Requests\StockRequest;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Option;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OptionsController extends Controller
{

    public function index()
    {
        $options = Option::with(['product' => function ($prod) {
            $prod->select('id');
        }
            , 'attribute' => function ($attr) {
                $attr->select('id');
            }])->select('id', 'product_id', 'attribute_id', 'price')->paginate(PAGENATE);

        return view('dashboard.options.index', compact('options'));

    }


    public function create()
    {
        $data = [];
        $data['products'] = Product::active()->select('id')->get();
        $data['attributes'] = Attribute::select('id')->get();
        return view('dashboard.options.create', $data);

    }

    public function store(OptionsRequest $request)
    {

        try {
            DB::beginTransaction();


            $option = Option::create($request->except('_token'));
            $option->name = $request->name;
            $option->save();

            DB::commit();
            return redirect()->route('admin.options')->with(['success' => __('messages.success')]);

        } catch (\Exception $e) {

            DB::rollBack();
            return redirect()->route('admin.options')->with(['error' => __('messages.error')]);

        }
    }

    public function edit($option_id)
    {
        $data = [];
        $data['option'] = Option::find($option_id);
        if (!$data['option'])
            return redirect()->route('admin.options')->with(['error' => __('admin/maincategories.exists')]);

        $data['products'] = Product::active()->select('id')->get();
        $data['attributes'] = Attribute::select('id')->get();
        return view('dashboard.options.edit', $data);

    }

    public function update($option_id,OptionsRequest $request)
    {
        try {
            DB::beginTransaction();
            $option = Option::find($option_id);
            if (!$option)
                return redirect()->route('admin.options')->with(['error' => __('admin/maincategories.exists')]);
            $option->update($request->except('_token', 'id'));
            $option->name = $request->name;
            $option->save();
            DB::commit();
            return redirect()->route('admin.options')->with(['success' => __('messages.success')]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.options')->with(['error' => __('messages.error')]);

        }


    }

}
