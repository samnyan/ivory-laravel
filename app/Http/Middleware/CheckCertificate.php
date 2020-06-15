<?php

namespace App\Http\Middleware;

use Closure;

class CheckCertificate
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
        if (auth()->user()->certificate_checked == 2) {
            return $next($request);
        } else {
            return response()->json(['message' => '证书还未审核通过，暂时无法使用'], 403);
        }
    }
}
