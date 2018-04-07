<?php

namespace App\Http\Middleware;

use Closure;

class Permitted
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
        $role = session('role');
        if($role[0] == 'payroll admin' || $role[0] == 'business owner') {
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}
