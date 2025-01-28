<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserOrContractorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->user_type == 'user' || Auth::user()->user_type == 'contractor') {
            return $next($request);
        }

        // Redirect if user does not have 'user' or 'contractor' user_type
        return redirect()->back()->withErrors([
            'error' => __('lang.text_account_type_restriction'),
        ]);
    }
}
