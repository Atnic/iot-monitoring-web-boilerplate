<?php

namespace App;

use App\Database\Eloquent\Concerns;
use Arados\Filters\Traits\Filterable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Device Model
 */
class Device extends Authenticatable
{
    use Filterable, Concerns\HasRelationships;

    /** @var string Filter Class */
    protected $filters = 'App\Filters\DeviceFilter';

    /** @var string $table */
    // protected $table = '';

    /** @var string $primaryKey */
    protected $primaryKey = 'imei';

    /** @var bool $incrementing */
    public $incrementing = false;

    /** @var string $keyType */
    protected $keyType = 'string';

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'imei', 'name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'api_token',
    ];

    /**
     * Get device_logs this model has
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function device_logs()
    {
        return $this->hasMany(DeviceLog::class);
    }

    /**
     * Get dataset this model belongs to
     * @return \App\Database\Eloquent\Relations\BelongsToOne
     */
    public function dataset()
    {
        return $this->belongsToOne(Dataset::class);
    }

    /**
     * Get data this model has
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function data()
    {
        return $this->hasManyThrough(Datum::class, DatasetDevice::class, null, (new Dataset)->getForeignKey(), null, (new Dataset)->getForeignKey());
    }
}
