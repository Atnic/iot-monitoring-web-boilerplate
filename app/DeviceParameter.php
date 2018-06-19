<?php

namespace App;

use Arados\Filters\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * DeviceParameter Model
 */
class DeviceParameter extends Model
{
    use Filterable;

    /** @var string Filter Class */
    protected $filters = 'App\Filters\DeviceParameterFilter';

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
     * Get device_logs this model has
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function device_logs()
    {
        return $this->hasMany(DeviceLog::class);
    }
}
