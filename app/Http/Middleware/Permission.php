<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ... $permissions)
    {
        $user = Auth::user();
        if($user->who == 3){
            return $next($request);
        }else{
            foreach($permissions as $k => $v){
                $property = 'm'.$v;
                if($user->$property == 1){
                    return $next($request);
                }else{
                    echo '<h3>You have no permission!</h3>';
                    exit();
                }
            }
        }
    }
}
