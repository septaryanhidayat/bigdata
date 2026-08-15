<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Models\SystemErrorLog;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectTo(
            guests: '/admin/login',
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        $exceptions->reportable(function (\Throwable $e) {
            try {
                $req = request();
                $file = str_replace(base_path().'\\', '', $e->getFile());
                $file = str_replace(base_path().'/', '', $file);

                SystemErrorLog::create([
                    'error_type' => 'PHP Exception',
                    'severity' => ($e instanceof \PDOException || $e instanceof \Error) ? 'CRITICAL' : 'HIGH',
                    'message' => $e->getMessage() ?: get_class($e),
                    'file' => $file,
                    'line' => $e->getLine(),
                    'stack_trace' => substr($e->getTraceAsString(), 0, 2000),
                    'url' => $req ? $req->fullUrl() : 'CLI / System',
                    'user_agent' => $req ? $req->userAgent() : 'System Worker',
                    'ip_address' => $req ? $req->ip() : '127.0.0.1',
                    'status' => 'UNRESOLVED',
                    'mitigation_solution' => SystemErrorLog::generateMitigation('PHP Exception', $e->getMessage(), $file),
                ]);
            } catch (\Throwable $loggingErr) {
                // Silence logging failure to avoid infinite loop
            }
        });
    })->create();

