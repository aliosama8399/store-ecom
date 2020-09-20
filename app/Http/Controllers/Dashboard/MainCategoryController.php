<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MainCategoryController extends Controller
{
    public function index()
    {
        $maincategories = Category::with('mainparent')->orderBy('id', 'DESC')->paginate(PAGENATE);
        return view('dashboard.categories.index', compact('maincategories'));

    }

    public function create()
    {
        $maincategories= Category::select('parent_id','id')->get();
        return view('dashboard.categories.create',compact('maincategories'));

    }


    public function store(MainCategoryRequest $request)
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
            if ($request->type == 1) {
             //   $request -> except('parent_id');
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

            if ($request->has('photo')) {
                $filename = uploadImage('maincategories', $request->photo);
                Category::where('id', $id)->update(['photo' => $filename]);

            }


            $maincategory->update($request->except('_token', 'id', 'photo'));
            $maincategory->name = $request->name;

            $maincategory->save();


            DB::commit();

            return redirect()->route('admin.maincategories')->with(['success' => __('messages.success')]);


        } catch (\Exception $e) {
            return $e;
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
            $image = Str::after($maincategory->photo, 'assets/');
            $image = base_path('public/assets/' . $image);
            unlink($image); //delete from folder
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
