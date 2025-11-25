<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PhpSpreadsheetServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Load PhpSpreadsheet manually
        $path = base_path('vendor/PhpOffice/PhpSpreadsheet/src/Bootstrap.php');
        if (file_exists($path)) {
            require_once $path;
        }
    }

    public function boot(): void
    {
        // Nothing to boot
    }
}
