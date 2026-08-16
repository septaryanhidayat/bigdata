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
        $middleware->replace(
            \Illuminate\Http\Middleware\ValidatePostSize::class,
            \App\Http\Middleware\CustomValidatePostSize::class,
        );

        $middleware->validateCsrfTokens(except: [
            'admin/cms/import-wordpress',
            'cms/import-wordpress',
        ]);

        $middleware->redirectTo(
            guests: '/admin/login',
        );

        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'CSRF Token Mismatch / Page Expired'], 419);
            }

            return redirect()->back()->with(
                'error',
                '⚠️ Sesi formulir telah kedaluwarsa (HTTP 419). Silakan ulangi kembali atau gunakan opsi "Impor via Path File Server".'
            );
        });

        $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Ukuran file unggahan terlalu besar untuk diproses oleh server web.',
                    'post_max_size' => ini_get('post_max_size'),
                ], 413);
            }

            return redirect()->back()->with(
                'error',
                '⛔ Ukuran berkas unggahan melebihi batas POST server web (Batas saat ini: ' . ini_get('post_max_size') . '). Gunakan opsi "Impor via Path File Server" atau jalankan perintah "php artisan wp:import" pada terminal untuk file berukuran besar tanpa batas.'
            );
        });

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

