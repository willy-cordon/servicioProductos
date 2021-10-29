<?php

namespace App\Http\Middleware;

use App\Models\Account;
use Closure;
use Illuminate\Http\Request;

class CheckAccountService
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
        if (auth()->user()->account_id != null || auth()->user()->account_id !='') {
            $account = Account::find(auth()->user()->account_id);
            if ($account->services == null || $account->services == '') {
                return redirect()->route('commons.accounts.edit', auth()->user()->account_id);
            }
        }else{
            return redirect()->route('commons.accounts.create');
        }
        return $next($request);
    }
}
