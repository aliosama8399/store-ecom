<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{


    public function create()
    {
        $data=[];
        $data['brands']=Brand::active()->select('id')->get();
        $data['tags']=Tag::select('id')->get();
        $data['catecories']=Category::active()->select('id')->get();
        return view('dashboard.products.general.create',$data);

    }
    public function store(GeneralProductRequest $request)
    {

        try {
            DB::beginTransaction();
            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else
                $request->request->add(['is_active' => 1]);

            $filename = "";
            if ($request->has('photo')) {
                $filename = uploadImage('maincategories', $request->photo);
            }

//if user choose main category then must delete parent id
            if ($request->type == CategoryType::MainCategory) {
                $request->request->add(['parent_id' => NULL]);

            }
//if user choose sub category then must add parent id

            $maincategory = Category::create($request->except('_token', 'photo'));
            $maincategory->name = $request->name;
            $maincategory->photo = $filename;
            $maincategory->save();

            DB::commit();
            return redirect()->route('admin.maincategories')->with(['success' => __('messages.success')]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.maincategories')->with(['error' => __('messages.error')]);

        }
    }
}
