<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if (session('locale') && in_array(session('locale'), ['en', 'id'])) {
            app()->setLocale(session('locale'));
        } elseif ($request->cookie('locale') && in_array($request->cookie('locale'), ['en', 'id'])) {
            app()->setLocale($request->cookie('locale'));
        } else {
            app()->setLocale(config('app.locale', 'en'));
        }

        return $next($request);
    }
}
