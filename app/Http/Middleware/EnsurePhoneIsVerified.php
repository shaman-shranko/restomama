<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;

class EnsurePhoneIsVerified
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
//        if (! $request->user() || ! $request->user()->hasVerifiedPhone()) {
//            return Redirect::route('phone_verification_notice');
//        }

        return $next($request);
    }
}
