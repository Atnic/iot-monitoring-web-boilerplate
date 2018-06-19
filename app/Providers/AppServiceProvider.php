<?php

namespace App\Providers;

use App\Device;
use Carbon\Carbon;
use App\Observers\DeviceObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
        if (config('database.default') == 'sqlite' && file_exists(database_path('database.sqlite'))) {
            Schema::enableForeignKeyConstraints();
        }
        if (config('database.default') == 'mysql' && file_exists(base_path('.env'))) {
            Schema::defaultStringLength(191);
        }

        Device::observe(DeviceObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
