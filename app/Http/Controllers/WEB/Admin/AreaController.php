<?php

namespace App\Http\Controllers\WEB\Admin;

use App\User;
use App\Models\Area;
use App\Models\AreaPoints;
use App\Models\AreaUsers;
use App\Models\AreaRequest;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Image;


class AreaController extends Controller

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
        $items = Area::all();
        return view('admin.area.home', [
            'items' => $items,
        ]);
    }

    public function show($id)
    {
        $item = Area::findOrFail($id);
         $employees = User::where('type',2)->get();
        $x = "";
        foreach($item->points as $one){
            $x .= $one->latitude.",".$one->longitude.";";
        }
       $points =  rtrim($x,';');
        return view('admin.area.details',compact('item','points','employees'));
    }

    public function create()
    {
        $employees = User::where('type',2)->get();
        
                return view('admin.area.create',[
            'employees'=>$employees,
        ]);

    }


    public function store(Request $request)
    {
        // dd($request->all());
           
        $roles = [
          'address' => 'required',
           'points'     => 'required',
           'employees'     => 'required',
        ];
        $this->validate($request, $roles);
        $points = explode(';',rtrim($request->points,';'));
        $employees = $request->employees;
        $area= new Area();
        $area->address = $request->address;
        $area->latitude = explode(',',$points[0])[0];
        $area->longitude = explode(',',$points[0])[1];
        $done = $area->save();
        if($done){
            foreach($points as $one){
                $point = new AreaPoints();
                $point->area_id = $area->id;
                $point->latitude = explode(',',$one)[0];
                $point->longitude = explode(',',$one)[1];
                $point->save();
            }
            foreach($employees as $one){
                $emp = new AreaUsers();
                $emp->area_id = $area->id;
                $emp->user_id = $one;
                $emp->save();
            }
        }
        return redirect()->back()->with('status', __('common.create'));

    }
 
 
 
    public function update(Request $request, $id)
    {
 $roles = [
          'address' => 'required',
           'points'     => 'required',
           'employees'     => 'required',
        ];
        $this->validate($request, $roles);
        $points = explode(';',rtrim($request->points,';'));
        $employees = $request->employees;

        $area = Area::findOrFail($id);

        $area->address = $request->address;
        $area->latitude = explode(',',$points[0])[0];
        $area->longitude = explode(',',$points[0])[1];
        $done = $area->save();
        if($done){
            AreaPoints::where('area_id',$id)->delete();
            foreach($points as $one){
                $point = new AreaPoints();
                $point->area_id = $id;
                $point->latitude = explode(',',$one)[0];
                $point->longitude = explode(',',$one)[1];
                $point->save();
            }
            AreaUsers::where('area_id',$id)->delete();
            foreach($employees as $one){
                $emp = new AreaUsers();
                $emp->area_id = $id;
                $emp->user_id = $one;
                $emp->save();
            }
        }
        

        return redirect()->back()->with('status', __('common.update'));

    }

    public function destroy($id)
    {
        Area::query()->findOrFail($id);
        $delete = Area::query()->where('id', $id)->delete();
        if ($delete){
            return "success";
        }
        return "fail";
    }

}