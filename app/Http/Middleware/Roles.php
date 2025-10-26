<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ... $roles)
    {
        $user = Auth::user();
        $users = array('SuperAdmin'=>1,'Sub_SuperAdmin'=>2,'InstituteAdmin'=>3,'Teacher'=>4,'Student'=>5,'Guardian'=>6,'AffiliateUser'=>7);
        foreach($roles as $k => $v){
            if($user->who == $users[$v]){
                return $next($request);
            }
        }
        Alert::error('You have no Permission!');
        return back();
    }
}
