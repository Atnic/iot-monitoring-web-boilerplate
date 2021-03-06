<?php

namespace App\Providers;

use App\Datum;
use App\Dataset;
use App\Device;
use App\DeviceLog;
use App\DeviceParameter;
use App\Parameter;
use Carbon\Carbon;
use App\Observers\DatumObserver;
use App\Observers\DatasetObserver;
use App\Observers\DeviceObserver;
use App\Observers\DeviceLogObserver;
use App\Observers\DeviceParameterObserver;
use App\Observers\ParameterObserver;
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
        DeviceParameter::observe(DeviceParameterObserver::class);
        DeviceLog::observe(DeviceLogObserver::class);
        Dataset::observe(DatasetObserver::class);
        Parameter::observe(ParameterObserver::class);
        Datum::observe(DatumObserver::class);
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
