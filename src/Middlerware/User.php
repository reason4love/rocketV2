<?php

namespace Hector\V2bAdapter\Middleware;

use Closure;
use Hector\V2bAdapter\Helper;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->session()->get('id')) {
            return response(Helper::unAuth());
        }
        $user = \App\Models\User::find($request->session()->get('id'));
        if(!$user || $user->banned){
            return response(Helper::forbid());
        }
        return $next($request);
    }
}
