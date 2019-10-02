<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Models\Area;
use App\Models\AreaRequest;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Image;


class AreaRequestController extends Controller

{
    public function __construct()
    {
        $this->locales = Language::all();
        $this->settings = Setting::query()->first();
        view()->share([
            'locales' => $this->locales,
            'settings' => $this->settings,

        ]);
    }

    public function index()
    {
        $items = AreaRequest::all();
        return view('admin.area_request.home', [
            'items' => $items,
]);
    }

    public function create($id)
    {
        $item = AreaRequest::where('id',$id)->first();
        if ($item){
            return view('admin.area_request.create',compact('item'));
        }
        return $this->index();
    }


    public function store(Request $request)
    {
        $newArea= new Area();
        $newArea->block_id = $request->block_id;
        $newArea->address = $request->address;
        $newArea->latitude = $request->latitude;
        $newArea->longitude = $request->longitude;
        $newArea->save ();

        if ($newArea)
        {
            AreaRequest::where('id',$request->id)->delete();
        }
        return redirect()->back()->with('status', __('common.create'));
    }

    public function destroy($id)
    {
        AreaRequest::query()->findOrFail($id);
        $delete = AreaRequest::query()->where('id', $id)->delete();
        if ($delete){
            return "success";
        }
        return "fail";
    }

}