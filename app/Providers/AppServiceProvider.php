<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Массив представлений, для которых не нужен массив channel
     * @var array
     */
    protected $includes = [
        'layouts.app',
        'threads.create',
    ];

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
        \View::composer($this->includes, function ($view) {
            $view->with('channels', Channel::all());
        });
    }
}
