<?php

namespace App\Providers;

use App\Coin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

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

        Validator::extend('check_fund', function ($attribute, $value, $parameters) {
            $user = auth()->user();
            $amount = $user->getBalance(strtoupper($parameters[0]));
            return $value <= $amount;
        });

        Validator::extend('old_password', function ($attribute, $value, $parameters) {
            $user = auth()->user();
            return Hash::check($value, $user->password);
        });
		
		
        Validator::extend('passed', function ($attribute, $value, $parameters) {
            $phrase = session()->get('phrase');
            return $phrase == $value;
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
