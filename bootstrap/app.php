<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Default middleware (যেগুলো web group এ যোগ হয়)
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        // ✅ Custom middleware alias গুলো এখানে যোগ করো
        $middleware->alias([
            'Roles' => \App\Http\Middleware\Roles::class,
            'Permission' => \App\Http\Middleware\Permission::class,
            'AffiliateUser' => \App\Http\Middleware\AffiliateUser::class,
            'CheckDomainActive' => \App\Http\Middleware\CheckDomainActive::class,
            'Guardian' => \App\Http\Middleware\Guardian::class,
            'iAdminAndTcrByPermission' => \App\Http\Middleware\iAdminAndTcrByPermission::class,
            'InstituteAdmin' => \App\Http\Middleware\InstituteAdmin::class,
            'Student' => \App\Http\Middleware\Student::class,
            'SuperAdmin' => \App\Http\Middleware\SuperAdmin::class,
            'Sub_SuperAdmin' => \App\Http\Middleware\Sub_SuperAdmin::class,
            'Teacher' => \App\Http\Middleware\Teacher::class,
            // চাইলে এখানে আরো middleware যোগ করতে পারো
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
