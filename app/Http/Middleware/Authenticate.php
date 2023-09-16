<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // return $request->expectsJson() ? null : route('login');

        if (!$request->expectsJson()) {
            if ($request->routeIs('admin.*')) {
                session()->flash('fail', 'Anda harus login terlebih dahulu!!');
                return route('admin.auth.login.get', ['return-url' => URL::current()]);
            }
        }
    }
}
