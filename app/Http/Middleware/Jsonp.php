<?php

namespace App\Http\Middleware;

use Closure;

class Jsonp
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
        $response =  $next($request);
        if($request->input('callback')){
            return response()->jsonp($request->input('callback'),json_decode($response->content()));
        }else{
            return $response;
        }
    }
}
