<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Utility;

class FleetAdmin
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
        if(auth()->check()){
            $user = Utility::firstRow('vehicle_fleet_access','user_id',auth()->user()->id);
            if ((auth()->user()->role == 1 || auth()->user()->role == 2 || auth()->user()->role == 3 || !empty($user))) {
                return $next($request);
            }
        }

        //return abort(401, 'Unauthorized');
        return redirect(route('logout'));
    }
}
