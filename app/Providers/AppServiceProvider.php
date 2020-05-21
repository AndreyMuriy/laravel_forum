<?php

namespace App\Providers;

use App\Channel;
use App\Notifications\PleaseVerifyYourEmail;
use Cache;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\ServiceProvider;
use Validator;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $channels = Cache::rememberForever('channels', function () {
                return Channel::all();
            });
            $view->with('channels', $channels);
        });

        Validator::extend('spamfree', '\App\Rules\SpamFree@passes');

        VerifyEmail::toMailUsing(function ($notifiable, $verificationUrl) {
            return (new PleaseVerifyYourEmail($verificationUrl))->toMail($notifiable);
        });
    }
}
