<?php

namespace App\Http\Middleware;

use App\Billing\PaymentGatewayContract;
use Closure;
use Illuminate\Http\Request;

class EnsurePaymentSignatureIsValid
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
        if (!app()->make(PaymentGatewayContract::class)->validateSignature($request)) {
            return abort(401);
        }

        return $next($request);
    }
}
