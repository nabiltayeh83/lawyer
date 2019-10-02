<?php

namespace App\Providers;

use App\Admin;
use App\User;
use App\Models\AreaRequest;
use App\Models\Contact;
use App\Models\Language;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use App\Models\Order;
use App\Models\Car;
use App\Models\Area;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('*', function ($view) 
        {


            //...with this variable
            $view->with([
            'setting' => Setting::query()->first(),
            'locales'=> Language::all(),
            'admin'=>Admin::first(),
            'contact'=> Contact::where('read',0)->count(),
            'orders'=> Order::count(),
            'areas'=> Area::query()->count(),
            'count_users' => User::where('type', 1)->count(),
            'count_store' => User::where('type', 2)->count(),
            'area_request'=> AreaRequest::query()->count(),
        ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

