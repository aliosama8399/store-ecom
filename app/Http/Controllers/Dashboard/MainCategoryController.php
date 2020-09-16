<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainCategoryController extends Controller
{
    public function index()
    {
        $maincategories = Category::parent()->orderBy('id','DESC')->paginate(PAGENATE);
        return view('dashboard.categories.index', compact('maincategories'));

    }

    public function create()
    {
        return view('dashboard.categories.create');

    }


    public function store(MainCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else
                $request->request->add(['is_active' => 1]);

            $maincategory = Category::create($request->except('_token'));
            $maincategory->name = $request->name;
            $maincategory->save();

            DB::commit();
            return redirect()->route('admin.maincategories')->with(['success' => __('messages.success')]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.maincategories')->with(['error' => __('messages.error')]);

        }
    }


    public function edit($id)
    {
        $maincategory = Category::find($id);
        if (!$maincategory)
            return redirect()->route('admin.maincategories')->with(['error' => __('admin/maincategories.exists')]);

        return view('dashboard.categories.edit', compact('maincategory'));

    }

    public function update($id, MainCategoryRequest $request)
    {
        try {


            DB::beginTransaction();


            $maincategory = Category::find($id);
            if (!$maincategory)
                return redirect()->route('admin.maincategories')->with(['error' => __('admin/validation.exists1')]);

            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else
                $request->request->add(['is_active' => 1]);


            $maincategory->update($request->all());
            $maincategory->name = $request->name;
            $maincategory->save();


            DB::commit();

            return redirect()->route('admin.maincategories')->with(['success' => __('messages.success')]);


        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.maincategories')->with(['error' => __('messages.error')]);

        }
    }

    public function delete($id)
    {
        try {
            $maincategory = Category::find($id);
            if (!$maincategory)
                return redirect()->route('admin.maincategories')->with(['error' => __('admin/maincategories.exists')]);
            $maincategory->translations()->delete();

            $maincategory->delete();
            return redirect()->route('admin.maincategories')->with(['success' => __('messages.success')]);

        } catch (\Exception $e) {
            return redirect()->route('admin.maincategories')->with(['error' => __('messages.error')]);

        }
    }

    public function changestatus()
    {

    }


}
