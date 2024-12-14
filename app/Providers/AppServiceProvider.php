<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(env('APP_ENV') !== 'local'){
            URL::forceScheme('https');
        };
        Inertia::share([
            'userRole' => function(){
                return Cache::remember('userRole_' . Auth::id(), 60 , function(){
                    return Auth::check() ? Auth::user()->getRoleNames() : [];
                });
            },
            'flash' => function(){
                return [
                    'message' => Session::get('message',''),
                ];
            }
        ]);
    }
}
