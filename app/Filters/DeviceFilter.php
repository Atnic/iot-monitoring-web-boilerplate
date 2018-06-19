<?php

namespace App\Filters;

use Atnic\LaravelGenerator\Filters\BaseFilter;

/**
 * DeviceFilter Filter
 */
class DeviceFilter extends BaseFilter
{
    /**
     * Searchable Field
     * @var array
     */
    protected $searchables = [
        'imei',
        'name'
    ];

    /**
     * Sortables Field
     * @var array
     */
    protected $sortables = [
        'imei',
        'name',
        'created_at',
        'updated_at'
    ];

    /**
     * Default Sort
     * @var string|null
     */
    protected $default_sort = 'create_at,desc';

    /**
     * Default per page
     * @var int|null
     */
    protected $default_per_page = null;
}
