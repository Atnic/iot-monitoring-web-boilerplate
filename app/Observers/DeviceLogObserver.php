<?php

namespace App\Observers;

use App\DeviceLog;

class DeviceLogObserver
{
    /**
     * Listen to the Model retrieved event.
     *
     * @param  \App\DeviceLog  $device_log
     * @return void
     */
    public function retrieved(DeviceLog $device_log)
    {
        //
    }

    /**
     * Listen to the Model creating event.
     *
     * @param  \App\DeviceLog  $device_log
     * @return void
     */
    public function creating(DeviceLog $device_log)
    {
        $device_log->logged_at = $device_log->logged_at ? : now(config('app.timezone'))->toAtomString();
    }

    /**
     * Listen to the Model created event.
     *
     * @param  \App\DeviceLog  $device_log
     * @return void
     */
    public function created(DeviceLog $device_log)
    {
        //
    }

    /**
     * Listen to the Model updating event.
     *
     * @param  \App\DeviceLog  $device_log
     * @return void
     */
    public function updating(DeviceLog $device_log)
    {
        //
    }

    /**
     * Listen to the Model updated event.
     *
     * @param  \App\DeviceLog  $device_log
     * @return void
     */
    public function updated(DeviceLog $device_log)
    {
        //
    }

    /**
     * Listen to the Model saving event.
     *
     * @param  \App\DeviceLog  $device_log
     * @return void
     */
    public function saving(DeviceLog $device_log)
    {
        //
    }

    /**
     * Listen to the Model saved event.
     *
     * @param  \App\DeviceLog  $device_log
     * @return void
     */
    public function saved(DeviceLog $device_log)
    {
        //
    }

    /**
     * Listen to the Model deleting event.
     *
     * @param  \App\DeviceLog  $device_log
     * @return void
     */
    public function deleting(DeviceLog $device_log)
    {
        //
    }

    /**
     * Listen to the Model deleted event.
     *
     * @param  \App\DeviceLog  $device_log
     * @return void
     */
    public function deleted(DeviceLog $device_log)
    {
        //
    }

    /**
     * Listen to the Model restoring event.
     *
     * @param  \App\DeviceLog  $device_log
     * @return void
     */
    public function restoring(DeviceLog $device_log)
    {
        //
    }

    /**
     * Listen to the Model restored event.
     *
     * @param  \App\DeviceLog  $device_log
     * @return void
     */
    public function restored(DeviceLog $device_log)
    {
        //
    }
}
