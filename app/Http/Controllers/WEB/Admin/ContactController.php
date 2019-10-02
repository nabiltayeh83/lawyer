<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Contact;
use App\Models\Careers;
use App\Models\Language;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
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
        $items = Contact::query();

        if ($request->has('email')) {
                $items->where('email', 'like', '%' . $request->get('email') . '%');
        }


        if ($request->has('mobile')) {
                $items->where('mobile', 'like', '%' . $request->get('mobile') . '%');
        }


        if ($request->get('from_date') && $request->get('to_date')) {
            $items->whereDate('updated_at', '>=', Carbon::parse($request->get('from_date')));
            $items->whereDate('updated_at', '<=', Carbon::parse($request->get('to_date')));
        }


        $items = $items->latest()->paginate($this->settings->paginate);

        return view('admin.cp.contacts.home', compact('items'));

    }



    public function viewMessage($id)
    {
        Contact::query()->where('id', $id)->update(['read' => 1]);
        $item = Contact::query()->findOrFail($id);
        return view('admin.cp.contacts.message', compact('item'));
    }
    


    public function destroy($id)
    {
        $item = Contact::query()->findOrFail($id);
        if ($item) {
            Contact::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }


    
    
//    public function index_careers(Request $request)
//    {
//        $items = Careers::query();
//        if ($request->has('email')) {
//            if ($request->get('email') != null)
//                $items->where('email', 'like', '%' . $request->get('email') . '%');
//        }
//        if ($request->has('comment')) {
//            if ($request->get('comment') != null)
//                $items->where('comment', 'like', '%' . $request->get('comment') . '%');
//        }
//        if ($request->has('mobile')) {
//            if ($request->get('mobile') != null)
//                $items->where('mobile', 'like', '%' . $request->get('mobile') . '%');
//        }
//        $items = $items->orderBy('id', 'desc')->paginate($this->settings->paginate);
//        //return $items;
//
//        return view('admin.careers.home', [
//            'items' => $items,
//        ]);
//
//    }
//
//
//
//     public function destroy_careers($id)
//    {
//        $item = Careers::query()->findOrFail($id);
//        if ($item) {
//            Careers::query()->where('id', $id)->delete();
//            return "success";
//        }
//        return "fail";
//    }
}
