<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponserTrait;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Authenticate extends Middleware
{
    use ApiResponserTrait;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            return $this->errorResponse(Response::HTTP_UNAUTHORIZED, 'Unauthenticated.');
        }
        return null;
    }
}
