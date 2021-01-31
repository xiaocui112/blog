<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerified
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
        if (
            $request->user() &&
            !$request->user()->hasVerifiedEmail() &&
            !$request->is('email/*', 'logout')
        ) {

            // 根据客户端返回对应的内容
            return $request->expectsJson()
                ? abort(403, '你的邮箱没有验证.')
                : redirect()->route('verification.notice');
        }
        return $next($request);
    }
}
