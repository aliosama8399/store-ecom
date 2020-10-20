<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributesController extends Controller
{

    public function index()
    {
        $attributes = Attribute::orderBy('id','DESC')->paginate(PAGENATE);

        return view('dashboard.attributes.index', compact('attributes'));

    }


    public function create()
    {
        return view('dashboard.attributes.create');

    }

    public function store(AttributeRequest $request)
    {

        try {


            $attribute = Attribute::create([]);
            $attribute->name = $request->name;
            $attribute->save();

            DB::commit();
            return redirect()->route('admin.attributes')->with(['success' => __('messages.success')]);

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route('admin.attributes')->with(['error' => __('messages.error')]);

        }
    }










}
