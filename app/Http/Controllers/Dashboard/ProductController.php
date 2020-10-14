<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralProductRequest;
use App\Http\Requests\ProductImagesRequest;
use App\Http\Requests\ProductPriceRequest;
use App\Http\Requests\StockRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::select('id', 'slug', 'price', 'created_at')->paginate(PAGENATE);

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

    public function getPrice($product_id)
    {
        $product = Product::find($product_id);
//        return view('dashboard.products.price.create')->with('id', $product_id);
        return view('dashboard.products.price.create', compact('product'));
    }

    public function storePrice(ProductPriceRequest $request)
    {
        try {
            DB::beginTransaction();

            Product::whereId($request->product_id)->update($request->except(['_token', 'product_id']));
            DB::commit();
            return redirect()->route('admin.products')->with(['success' => __('messages.success')]);

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route('admin.products')->with(['error' => __('messages.error')]);

        }


    }

    public function getStock($product_id)
    {
        $product = Product::find($product_id);
//        return view('dashboard.products.price.create')->with('id', $product_id);
        return view('dashboard.products.stock.create', compact('product'));

    }

    public function storeStock(StockRequest $request)
    {
        try {
            DB::beginTransaction();

            Product::whereId($request->product_id)->update($request->except(['_token', 'product_id']));
            DB::commit();
            return redirect()->route('admin.products')->with(['success' => __('messages.success')]);

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route('admin.products')->with(['error' => __('messages.error')]);

        }

    }

    public function getImages($product_id)
    {
        return view('dashboard.products.images.create')->withId($product_id);

    }

    public function storeImages(Request $request)
    {
        $file = $request->file('dzfile');
        $filename = uploadImage('products', $file);

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function storeImagesDB(ProductImagesRequest $request)
    {

        try {
           if ($request->has('document') && count($request->document) > 0) {
                foreach ($request->document as $image) {
                    Image::create([
                        'product_id' => $request->product_id,
                        'photo' => $image,
                    ]);
                }
            }

            return redirect()->route('admin.products')->with(['success' => __('messages.success')]);


        }catch (\Exception $e){
            return redirect()->route('admin.products')->with(['error' => __('messages.error')]);

        }



    }
}
