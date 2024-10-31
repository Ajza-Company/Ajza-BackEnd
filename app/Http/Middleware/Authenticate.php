<?php

namespace App\Http\Middleware;

use App\Enums\ErrorMessageEnum;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends \Illuminate\Auth\Middleware\Authenticate
{
    /**
     * Handle an unauthenticated user.
     *
     * @param Request $request
     * @param  array  $guards
     * @return void
     *
     * @throws AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        if ($request->is('api/*') || $request->expectsJson()) {
            abort(response()->json(errorResponse(
                message: 'Unauthenticated'),
                Response::HTTP_UNAUTHORIZED));
        }

        parent::unauthenticated($request, $guards);
    }
}
