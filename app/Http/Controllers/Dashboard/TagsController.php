<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagsController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('id', 'DESC')->paginate(PAGENATE);
        return view('dashboard.tags.index', compact('tags'));

    }

    public function create()
    {
        return view('dashboard.tags.create');

    }


    public function store(TagRequest $request)
    {
        try {
            DB::beginTransaction();

            $tag = Tag::create($request->only('slug'));
            $tag->name = $request->name;
            $tag->save();

            DB::commit();
            return redirect()->route('admin.tags')->with(['success' => __('messages.success')]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.tags')->with(['error' => __('messages.error')]);

        }
    }


    public function edit($id)
    {
        $tag = Tag::find($id);
        if (!$tag)
            return redirect()->route('admin.tags')->with(['error' => __('admin/tags.exists')]);

        return view('dashboard.tags.edit', compact('tag'));

    }

    public function update($id, TagRequest $request)
    {
        try {




            $tag = Tag::find($id);
            if (!$tag)
                return redirect()->route('admin.tags')->with(['error' => __('admin/tags.exists')]);

            DB::beginTransaction();



            $tag->update($request->except('id','_token'));
            $tag->name = $request->name;
            $tag->save();


            DB::commit();

            return redirect()->route('admin.tags')->with(['success' => __('messages.success')]);


        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.tags')->with(['error' => __('messages.error')]);

        }
    }

    public function delete($id)
    {
        try {
            $tag = Tag::find($id);
            if (!$tag)
                return redirect()->route('admin.tags')->with(['error' => __('admin/tags.exists')]);


            $tag->translations()->delete();

            $tag->delete();
            return redirect()->route('admin.tags')->with(['success' => __('messages.success')]);

        } catch (\Exception $e) {
            return redirect()->route('admin.tags')->with(['error' => __('messages.error')]);

        }
    }

}
