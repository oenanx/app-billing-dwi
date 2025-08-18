<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('hasRole', function($expression) {
            $condition = false;

            // check if the user is authenticated
            if (Auth::check()) {
                // check if the user has a subscription
                $condition = Auth::user()->role && Auth::user()->role->name === $expression;
            }

            return $condition;
        });

        Blade::directive('money', function ($money) {
            return "<?php echo number_format($money, 0); ?>";
        });


    }
}
