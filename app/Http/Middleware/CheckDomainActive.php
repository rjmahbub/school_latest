<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckDomainActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $c = new Controller;
        $prefix = $c->prefix(0);
        $prefixMain = $c->prefixMain;
        if($prefix !== $prefixMain){
            $isNotActive = $c->checkDomainActive($prefix);
            if($isNotActive){
                return $isNotActive;
            }
        }
        return $next($request);
    }
}
