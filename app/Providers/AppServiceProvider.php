<?php

namespace App\Providers;

<<<<<<< HEAD

=======
use Illuminate\Support\Facades\Route;
>>>>>>> 9bcb70e46542c4181318cbfb7aff22e3c07d3b9a
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));
    }

}
