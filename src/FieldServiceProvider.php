<?php

namespace Ampeco\Filters;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-date-range-filter', __DIR__ . '/../dist/js/date-range-filter.js');
            Nova::style('nova-date-range-filter', __DIR__ . '/../dist/css/date-range-filter.css');
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
