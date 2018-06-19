<?php

namespace App;

use Arados\Filters\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * DeviceLog Model
 */
class DeviceLog extends Model
{
    use Filterable;

    /** @var string Filter Class */
    protected $filters = 'App\Filters\DeviceLogFilter';

    /** @var string $table */
    // protected $table = '';

    /** @var string $primaryKey */
    // protected $primaryKey = '';

    /** @var bool $incrementing */
    // public $incrementing = false;

    /** @var string $keyType */
    // protected $keyType = 'string';

    /** @var bool $timestamps */
    // public $timestamps = false;

    /** @var string $dateFormat */
    // protected $dateFormat = 'U';

    /** @var string CREATED_AT */
    // const CREATED_AT = '';
    /** @var string UPDATED_AT */
    // const UPDATED_AT = '';

    /** @var string $connection */
    // protected $connection = '';

    /**
     * Get device this device_log belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * Get device_parameter this device_log belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device_parameter()
    {
        return $this->belongsTo(DeviceParameter::class);
    }
}
