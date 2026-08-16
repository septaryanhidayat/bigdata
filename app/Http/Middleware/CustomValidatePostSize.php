<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Middleware\ValidatePostSize as BaseValidatePostSize;

class CustomValidatePostSize extends BaseValidatePostSize
{
    /**
     * URIs that should be excluded from default POST size validation.
     *
     * @var array<int, string>
     */
    protected $except = [
        'admin/cms/import-wordpress',
        'cms/import-wordpress',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Http\Exceptions\PostTooLargeException
     */
    public function handle($request, Closure $next)
    {
        foreach ($this->except as $except) {
            if ($request->is($except)) {
                return $next($request);
            }
        }

        return parent::handle($request, $next);
    }
}
