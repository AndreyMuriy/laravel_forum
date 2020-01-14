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
    protected $excludes = [
        'threads.reply'
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
        \View::composer('*', function ($view) {
            if (!in_array($view->getName(), $this->excludes)) {
                $view->with('channels', Channel::all());
            }
        });
    }
}
