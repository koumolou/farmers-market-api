<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prepend(
            \Illuminate\Http\Middleware\HandleCors::class
        );
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // Validation errors — 422
        $exceptions->render(function (
            \Illuminate\Validation\ValidationException $e,
            $request
        ) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors'  => $e->errors(),
                ], 422);
            }
        });

        // Authorization errors — 403
        $exceptions->render(function (
            \Illuminate\Auth\Access\AuthorizationException $e,
            $request
        ) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage() ?: 'Forbidden',
                ], 403);
            }
        });

        // Unauthenticated — 401
        $exceptions->render(function (
            \Illuminate\Auth\AuthenticationException $e,
            $request
        ) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Please login.',
                ], 401);
            }
        });

        // Model not found — 404
        $exceptions->render(function (
            \Illuminate\Database\Eloquent\ModelNotFoundException $e,
            $request
        ) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resource not found.',
                ], 404);
            }
        });

    })->create(); 