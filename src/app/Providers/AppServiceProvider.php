<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
    Paginator::defaultView('vendor.pagination.default');
    Paginator::defaultSimpleView('vendor.pagination.simple');

    view()->composer('*', function ($view) {
        $params = request()->query();
        unset($params['page']);

        $view->with([
            'query_params' => $params,
        ]);
    });
}
}
