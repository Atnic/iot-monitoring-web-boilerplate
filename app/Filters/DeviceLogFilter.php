<?php

namespace App\Filters;

use Atnic\LaravelGenerator\Filters\BaseFilter;

/**
 * DeviceLogFilter Filter
 */
class DeviceLogFilter extends BaseFilter
{
    /**
     * Searchable Field
     * @var array
     */
    protected $searchables = [
        'id',
        'device_imei' => [ 'imei', 'name' ],
        'device_parameter' => [ 'name' ],
        'value',
        'logged_at',
    ];

    /**
     * Sortables Field
     * @var array
     */
    protected $sortables = [
        'id',
        'device_imei.imei',
        'device_parameter.name',
        'value',
        'logged_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Default Sort
     * @var string|null
     */
    protected $default_sort = 'logged_at,desc';

    /**
     * Default per page
     * @var int|null
     */
    protected $default_per_page = null;
}
