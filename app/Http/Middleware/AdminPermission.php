<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission = null)
    {
        $user = User::where('id', adminLogin()->id)->first();
        if ($user->hasRole('owner')) {
            return $next($request);
        } else {
            if (!$user->isAbleTo([$permission])) {
                return back()->with('faild','Have No Permission To Access This Page');
            }else{
                return $next($request);
            }
        }
    }
}
