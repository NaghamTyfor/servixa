<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if($request->is('api/*')){
            $local=$request->header('Accept-language',config('app.locale'));
        }
        else{
            $local=session('locale',config('app.locale'));
        }
        app()->setLocale($local);
        return $next($request);
    }
}
