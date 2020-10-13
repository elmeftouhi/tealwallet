<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use App\Observers\ExpenseObserver;
use App\Expense;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Blade::directive('money', function ($amount) {
            return "<?php echo number_format($amount, 2) . ' Dh'; ?>";
        });

        Str::macro('money', function ($price)
        {
            return number_format($price, 2).' Dh';
        });

        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        Expense::observe(ExpenseObserver::class);

    }
}
