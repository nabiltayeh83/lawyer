<?php

namespace App\Http\Controllers\WEB\Admin;


use App\Models\UserAddress;
use App\Models\City;
use App\Models\Setting;
use App\User;
use Dotenv\Exception\ValidationException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NewPostNotification;
use Image;
use Illuminate\Validation\Rule;
use Mockery\Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->settings = Setting::query()->first();
        view()->share([
            'settings' => $this->settings,
        ]);
    }



    public function index(Request $request)
    {
        $items = User::query();
        
        if($request->has('email')){
            $items->where('email', 'like', '%' . $request->get('email') . '%');
        }

        if($request->has('mobile')){
            $items->where('mobile', 'like', '%' . $request->get('mobile') . '%');
        }

        $items = $items->where('type','1');
        $items = $items->latest()->get();

        return view('admin.users.home', compact('items'));

    }




    
    public function stores(Request $request){
        $items = User::query();
        if ($request->has('email')) {
            if ($request->get('email') != null)
                $items->where('email', 'like', '%' . $request->get('email') . '%');
        }

        if ($request->has('mobile')) {
            if ($request->get('mobile') != null)
                $items->where('mobile', 'like', '%' . $request->get('mobile') . '%');
        }
        $items = $items->where('type','1');
        $items = $items->orderBy('id', 'desc')->get();
        return view('admin.store.home', [
            'items' => $items,
        ]);

    }




    public function destroy($id)
    {
        $item = User::query()->findOrFail($id);
        if ($item) {
            User::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }


    public function create()
    {
        return view('admin.users.create');
    }




    public function store(Request $request)
    {

        
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,jpg,png',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|unique:users|digits_between:8,12',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extention = $image->getClientOriginalExtension();
            $file_name = str_random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) . "." . $extention;
            Image::make($image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save("uploads/images/users/$file_name");
        }


        $newUser = User::create(Input::except(['password', 'image']) + ['image' => $file_name, 'type' => 1, 'password' => bcrypt($request->password)]);

        return redirect('/admin/users')->with('status', __('cp.create'));

    }



    public function edit($id)
    {

        $item = User::findOrFail($id);
        return view('admin.users.edit', compact('item'));
    }





    public function update(Request $request, $id)
    {
        $user= User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile' => 'required|digits_between:8,12|unique:users,mobile,'.$user->id,
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extention = $image->getClientOriginalExtension();
            $file_name = str_random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) . "." . $extention;
            Image::make($image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save("uploads/images/users/$file_name");
            $user->image = $file_name;
        }
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->save();

        return redirect('/admin/users')->with('status', __('cp.update'));
    }



    public function edit_password(Request $request, $id)
    {
        $item = User::findOrFail($id);
        return view('admin.users.edit_password', compact('item'));
    }



    public function update_password (Request $request, $id)
    {
        $users_rules=array(
            'password'=>'required|min:6',
            'confirm_password'=>'required|same:password|min:6',
        );
        $users_validation=Validator::make($request->all(), $users_rules);

        if($users_validation->fails())
        {
            return redirect()->back()->withErrors($users_validation)->withInput();
        }
        $user = User::findOrFail($id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('status', __('cp.update'));
    }


    public function changeStatus(Request $request)
    {
        dd($request->IDsArray) ;
        if ($request->event == 'delete') {
            User::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            User::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }

}
