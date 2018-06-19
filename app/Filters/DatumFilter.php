<?php

namespace App\Filters;

use Atnic\LaravelGenerator\Filters\BaseFilter;

/**
 * DatumFilter Filter
 */
class DatumFilter extends BaseFilter
{
    /**
     * Searchable Field
     * @var array
     */
    protected $searchables = [
        'dataset' => [ 'name' ],
        'parameter' => [ 'name' ],
        'value',
        'logged_at',
    ];

    /**
     * Sortables Field
     * @var array
     */
    protected $sortables = [
        'id',
        'dataset.name',
        'parameter.name',
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
