<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function index()
    {
        $products=Product::select('id','slug','price','created_at')->paginate(PAGENATE);

        return view('dashboard.products.general.index', compact('products'));

    }


    public function create()
    {
        $data = [];
        $data['brands'] = Brand::active()->select('id')->get();
        $data['tags'] = Tag::select('id')->get();
        $data['categories'] = Category::active()->select('id')->get();
        return view('dashboard.products.general.create', $data);

    }

    public function store(GeneralProductRequest $request)
    {

        try {
            DB::beginTransaction();
            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else
                $request->request->add(['is_active' => 1]);


            $product = Product::create($request->only('slug', 'brand_id', 'is_active'));
            $product->name = $request->name;
            $product->description = strip_tags($request->description);
            $product->short_description = strip_tags($request->short_description);
            $product->save();
            $product->categories()->attach($request->categories);

            DB::commit();
            return redirect()->route('admin.products')->with(['success' => __('messages.success')]);

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route('admin.products')->with(['error' => __('messages.error')]);

        }
    }
}