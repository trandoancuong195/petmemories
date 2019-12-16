<?php

namespace App\Http\Middleware;

use Closure;

class CheckPrice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->price_new >100000000){
            return 0;
        }
        return $next($request);
    }
}
