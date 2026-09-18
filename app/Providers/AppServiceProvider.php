<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        if (config('app.env') === 'production' || request()->server('HTTPS') === 'on' || request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $host = request()->getHost();
            $scheme = request()->getScheme();
            $port = request()->getPort();
            $portStr = ($port && !in_array($port, [80, 443])) ? ':' . $port : '';

            $subdomains = ['tk', 'tkit', 'sd', 'sdit', 'smp', 'smpit', 'sma', 'smait', 'spmb'];
            $parts = explode('.', $host);
            if (count($parts) >= 3 && in_array(strtolower($parts[0]), $subdomains)) {
                array_shift($parts);
                $portalUrl = $scheme . '://' . implode('.', $parts) . $portStr;
            } elseif (str_contains($host, 'sitrobbani.sch.id')) {
                $portalUrl = 'https://sitrobbani.sch.id' . $portStr;
            } else {
                $appUrl = config('app.url');
                $portalUrl = ($appUrl && $appUrl !== 'http://localhost') ? rtrim($appUrl, '/') : route('home');
            }

            $view->with('portalUrl', $portalUrl);
        });
    }
}
