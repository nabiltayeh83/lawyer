<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use Mockery\Exception;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NewPostNotification;

use App\User;
use App\Models\NotificationMessage;
use App\Models\Token;


class NotificationMessageController extends Controller
{


    public function index(Request $request)
    {
        $owner_id = auth()->guard('subadmin')->id();
        $company = Company::query()->where('owner_id',$owner_id)->first();
        $items = NotificationMessage::query()->where('company_id',$company->id)->orderBy('id', 'Desc')->paginate(10);
        //return $items;
        return view('subadmin.notifications.home', [
            'items' => $items,
        ]);
    }



   

}
