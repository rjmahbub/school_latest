<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\SiteHelper;

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
        $prefix = SiteHelper::prefix(0);
        $prefixMain = SiteHelper::$prefixMain;

        if($prefix !== $prefixMain){
            $isNotActive = SiteHelper::checkDomainActive($prefix);
            if($isNotActive){
                return $isNotActive;
            }
        }
        return $next($request);
    }
}
