<?php

namespace App\Filters;

use Atnic\LaravelGenerator\Filters\BaseFilter;

/**
 * DatasetFilter Filter
 */
class DatasetFilter extends BaseFilter
{
    /**
     * Searchable Field
     * @var array
     */
    protected $searchables = [
        'name',
        'remark'
    ];

    /**
     * Sortables Field
     * @var array
     */
    protected $sortables = [
        'name',
        'remark',
        'created_at',
        'updated_at'
    ];

    /**
     * Default Sort
     * @var string|null
     */
    protected $default_sort = 'created_at,desc';

    /**
     * Default per page
     * @var int|null
     */
    protected $default_per_page = null;
}
