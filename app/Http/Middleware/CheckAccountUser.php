<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckAccountUser
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
        if (!auth()->user()->hasRole(User::ROLE_ADMIN)) {
            if (auth()->user()->account_id == null || auth()->user()->account_id == '') {
                return redirect()->route('commons.accounts.create');
            }
        }
        return $next($request);
    }
}
