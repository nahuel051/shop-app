<?php
// Este archivo define un proveedor de servicios en Laravel. Los proveedores de servicios son la forma principal de vincular y configurar servicios en Laravel.
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PdfService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */public function register()
{
    $this->app->singleton(PdfService::class, function ($app) {
        return new PdfService();
    });
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
