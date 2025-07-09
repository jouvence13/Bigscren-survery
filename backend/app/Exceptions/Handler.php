<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Throwable;

//  Importation des classes JWT (bien orthographiées)
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;


class Handler extends ExceptionHandler
{
    /**
     * Gestion des erreurs d'authentification API (ex : route protégée sans token)
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        return redirect()->guest(route('login'));
    }

    /**
     * Gestion des erreurs générales (dont JWT)
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TokenExpiredException) {
            return response()->json(['error' => 'Token expired'], 401);
        }

        if ($exception instanceof TokenInvalidException) {
            return response()->json(['error' => 'Token invalid'], 401);
        }

        if ($exception instanceof JWTException) {
            return response()->json(['error' => 'Token absent'], 401);
        }

        return parent::render($request, $exception);
    }
}
