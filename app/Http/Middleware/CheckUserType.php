<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $type
     * @return mixed
     */
    public function handle($request, Closure $next, $type)
    {
        if (auth()->user()->type == $type) {
            return $next($request);
        } else {
            return response()->json(['message' => '没有访问权限'], 403);
        }
    }
}
