<?php

declare(strict_types=1);

namespace Coddin\Filters;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;

final class FieldServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-date-range-filter', __DIR__ . '/../dist/js/date-range-filter.js');
            Nova::style('nova-date-range-filter', __DIR__ . '/../dist/css/date-range-filter.css');
        });
    }
}
