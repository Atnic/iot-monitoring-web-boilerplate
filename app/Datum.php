<?php

namespace App;

use Arados\Filters\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * Datum Model
 */
class Datum extends Model
{
    use Filterable;

    /** @var string Filter Class */
    protected $filters = 'App\Filters\DatumFilter';

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
     * Get dataset this model belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }

    /**
     * Get parameter this model belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }
}
