<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subcategories = Category::child()->orderBy('id','DESC')->paginate(PAGENATE);
        return view('dashboard.subcategories.index', compact('subcategories'));

    }

    public function create()
    {
        $maincategories = Category::parent()->orderBy('id','DESC')->get();

        return view('dashboard.subcategories.create',compact('maincategories'));

    }


    public function store(SubCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else
                $request->request->add(['is_active' => 1]);

            $subcategory = Category::create($request->except('_token'));
            $subcategory->name = $request->name;
            $subcategory->save();

            DB::commit();
            return redirect()->route('admin.subcategories')->with(['success' => __('messages.success')]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.subcategories')->with(['error' => __('messages.error')]);

        }
    }


    public function edit($id)
    {
        $category = Category::orderBy('id', 'DESC')->find($id);

        if (!$category)
            return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود ']);

        $categories = Category::parent()->orderBy('id','DESC') -> get();


        return view('dashboard.subcategories.edit', compact('category','categories'));

    }

    public function update($id, SubCategoryRequest $request)
    {
        try {


            DB::beginTransaction();


            $subcategory = Category::find($id);
            if (!$subcategory)
                return redirect()->route('admin.subcategories')->with(['error' => __('admin/validation.exists1')]);

            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else
                $request->request->add(['is_active' => 1]);


            $subcategory->update($request->all());
            $subcategory->name = $request->name;
            $subcategory->save();


            DB::commit();

            return redirect()->route('admin.subcategories')->with(['success' => __('messages.success')]);


        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.subcategories')->with(['error' => __('messages.error')]);

        }
    }

    public function delete($id)
    {
        try {
            $subcategory = Category::orderBy('id', 'DESC')->find($id);
            if (!$subcategory)
                return redirect()->route('admin.subcategories')->with(['error' => __('admin/maincategories.exists')]);

            $subcategory->delete();
            return redirect()->route('admin.subcategories')->with(['success' => __('messages.success')]);

        } catch (\Exception $e) {
            return redirect()->route('admin.subcategories')->with(['error' => __('messages.error')]);

        }
    }
}
