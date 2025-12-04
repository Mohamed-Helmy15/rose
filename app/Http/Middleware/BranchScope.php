<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchScope
{
    public function handle(Request $request, Closure $next)
    {
        if (!settings('multi_branch', false)) {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->hasRole(['admin'])) {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->branches()->count() === 0) {
            abort(403, 'ليس لديك صلاحية الوصول إلى أي فرع');
        }

        return $next($request);
    }
}