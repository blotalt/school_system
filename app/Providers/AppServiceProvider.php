<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // The app has no Tailwind/Bootstrap build pipeline, so the
        // framework's default pagination views (which rely on those
        // frameworks' utility classes to size their icons) render an
        // oversized, unstyled SVG arrow. Use our own plain view instead.
        Paginator::defaultView('vendor.pagination.custom');
    }
}