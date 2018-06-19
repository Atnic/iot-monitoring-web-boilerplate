<?php

namespace App\Filters;

use Atnic\LaravelGenerator\Filters\BaseFilter;

/**
 * DeviceParameterFilter Filter
 */
class DeviceParameterFilter extends BaseFilter
{
    /**
     * Searchable Field
     * @var array
     */
    protected $searchables = [
        'code',
        'name',
        'unit',
    ];

    /**
     * Sortables Field
     * @var array
     */
    protected $sortables = [
        'id',
        'code',
        'name',
        'unit',
        'created_at',
        'updated_at'
    ];

    /**
     * Default Sort
     * @var string|null
     */
    protected $default_sort = null; // TODO: Default sort, null if no default, ex: 'name,asc'

    /**
     * Default per page
     * @var int|null
     */
    protected $default_per_page = null; // TODO: Default per page, null if use model per page default, ex: 20
}
