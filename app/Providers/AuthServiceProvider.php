<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Device' => 'App\Policies\DevicePolicy',
        'App\DeviceParameter' => 'App\Policies\DeviceParameterPolicy',
        'App\DeviceLog' => 'App\Policies\DeviceLogPolicy',
        'App\Dataset' => 'App\Policies\DatasetPolicy',
        'App\Parameter' => 'App\Policies\ParameterPolicy',
        'App\Datum' => 'App\Policies\DatumPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
