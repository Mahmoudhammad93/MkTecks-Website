<?php

namespace App\Providers;

use App\Shop\Myfatoorah\PaymentMyfatoorahApiV2;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PaymentMyfatoorahApiV2::class,function(){
            return new PaymentMyfatoorahApiV2(env('MY_FATOORAH_KEY',null) , env('MY_FATOORAH_TESTING',true));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        app()->singleton('lang',function (){
            if (session()->has('mktechs.lang')){
                return session()->get('mktechs.lang');
            }else{
                return 'en';
            }
        });
        Schema::defaultStringlength(191);
    }
}
