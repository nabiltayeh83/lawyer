<?php

namespace App\Http\Controllers\WEB\SubAdmin;


use App\Models\City;
use App\Models\Setting;
use App\Subadmin;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NewPostNotification;

use Illuminate\Validation\Rule;
use Mockery\Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class OwnerController extends Controller
{

    public function image_extensions(){

        return array('jpg','png','jpeg','gif','bmp','pdf');

    }


    public function __construct()
    {
        $this->settings = Setting::query()->first();
        view()->share([
            'settings' => $this->settings,
        ]);
    }

    public function index_owner(Request $request)
    {
        $owner_id = auth('subadmin')->id();
        $items = Subadmin::query()->where('id',$owner_id);
        if ($request->has('email')) {
            if ($request->get('email') != null)
                $items->where('email', 'like', '%' . $request->get('email') . '%');
        }

        if ($request->has('mobile')) {
            if ($request->get('mobile') != null)
                $items->where('mobile', 'like', '%' . $request->get('mobile') . '%');
        }
        $items = $items->orderBy('id', 'desc')->get();
        return view('subadmin.owner.home', [
            'items' => $items,
        ]);

    }

    public function destroy_owner($id)
    {
        $item = Subadmin::query()->findOrFail($id);
        if ($item) {
            User::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }





    public function edit_owner($id)
    {
        //dd($id);
        $owner_id = auth('subadmin')->id();
        $item = Subadmin::where('id',$owner_id)->findOrFail($id);
        //return $item;

        return view('subadmin.owner.edit',['item'=>$item]);
    }

    public function update_owner(Request $request, $id)
    {
        //dd($request->all());

        //dd($request->all());
        $users_rules=array(
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:255|unique:users,id,'.$id,
            'mobile'=>'required|integer|min:8',
//            'lat'=>'required',
//            'lan'=>'required',
//            'location'=>'required',
        );
        $users_validation=Validator::make($request->all(), $users_rules);

        if($users_validation->fails())
        {
            return redirect()->back()->withErrors($users_validation)->withInput();
        }



        $user='';


        $user= Subadmin::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if(Input::file("profile_image")&&Input::file("profile_image")!=NULL)
        {
            if (Input::file("profile_image")->isValid())
            {
                $destinationPath=public_path('uploads/users');

                $extension=strtolower(Input::file("profile_image")->getClientOriginalExtension());
                //dd($extension);
                $array= $this->image_extensions();
                if(in_array($extension,$array))
                {
                    $fileName_person=uniqid().'.'.$extension;
                    Input::file("profile_image")->move($destinationPath, $fileName_person);
                }
            }
        }


        if(isset($fileName_person)){$user->image='uploads/users/'.$fileName_person;}
        $user->save();


        return redirect()->back()->with('status', __('common.update'));
    }



    public function edit_password_owner(Request $request, $id)
    {
        //dd($id);

        $item = Subadmin::findOrFail($id);
        return view('subadmin.owner.edit_password',['item'=>$item]);
    }


    public function update_password_owner(Request $request, $id)
    {
        //dd($request->all());
        $users_rules=array(
            'password'=>'required|min:6',
            'confirm_password'=>'required|same:password|min:6',
        );
        $users_validation=Validator::make($request->all(), $users_rules);

        if($users_validation->fails())
        {
            return redirect()->back()->withErrors($users_validation)->withInput();
        }
        $user = Subadmin::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();


        return redirect()->back()->with('status', __('common.update'));
    }



}
