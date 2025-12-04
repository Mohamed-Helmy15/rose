<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class CustomerAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('customer.login');
    }

    /**
     * Specify the guard to use for authentication.
     */
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = ['customer'];
        }

        return parent::authenticate($request, $guards);
    }
}