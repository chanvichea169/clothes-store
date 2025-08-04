<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Throwable $e) {
            if ($e instanceof NotFoundHttpException) {
                return response()->view('errors.404', [], 404);
            }elseif ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return response()->view('errors.500', [], 500);
            }elseif ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
                return response()->view('errors.403', [], 403);
            } elseif ($e instanceof \Illuminate\Validation\ValidationException) {
                return response()->view('errors.422', [], 422);
            }
            return redirect('/login')
               ->with('message', 'Please log in or register to continue.');
        });
})->create();