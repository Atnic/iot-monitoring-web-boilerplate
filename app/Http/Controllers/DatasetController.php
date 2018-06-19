<?php

namespace App\Http\Controllers;

use App\Dataset;
use Illuminate\Http\Request;

/**
 * DatasetController
 */
class DatasetController extends Controller
{
    /**
     * Relations
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Dataset|null  $dataset
     * @return array
     */
    public static function relations(Request $request = null, Dataset $dataset = null)
    {
        return [
            'dataset' => [
                'belongsToMany' => [], // also for morphToMany
                'hasMany' => [
                    // [ 'name' => 'childs', 'label' => title_case(__('datasets.childs')) ], // Example
                ], // also for morphMany, hasManyThrough
            ]
        ];
    }

    /**
     * Visibles
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Dataset|null  $dataset
     * @return array
     */
    public static function visibles(Request $request = null, Dataset $dataset = null)
    {
        return [
            'index' => [
                'dataset' => [
                    // [ 'name' => 'parent', 'label' => title_case(__('datasets.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'name', 'label' => title_case(__('datasets.name')) ],
                    [ 'name' => 'remark', 'label' => title_case(__('datasets.remark')) ],
                ]
            ],
            'show' => [
                'dataset' => [
                    // [ 'name' => 'parent', 'label' => title_case(__('datasets.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'name', 'label' => title_case(__('datasets.name')) ],
                    [ 'name' => 'remark', 'label' => title_case(__('datasets.remark')) ],
                ]
            ]
        ];
    }

    /**
     * Fields
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Dataset|null  $dataset
     * @return array
     */
    public static function fields(Request $request = null, Dataset $dataset = null)
    {
        return [
            'create' => [
                'dataset' => [
                    // [ 'field' => 'select', 'name' => 'parent_id', 'label' => title_case(__('bars.parent')), 'required' => true, 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //     return [ 'value' => $parent->id, 'text' => $parent->name ];
                    // })->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => title_case(__('datasets.name')), 'required' => true ],
                    [ 'field' => 'textarea', 'name' => 'remark', 'label' => title_case(__('datasets.remark')) ],
                ]
            ],
            'edit' => [
                'dataset' => [
                    // [ 'field' => 'select', 'name' => 'parent_id', 'label' => title_case(__('bars.parent')), 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //     return [ 'value' => $parent->id, 'text' => $parent->name ];
                    // })->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => title_case(__('datasets.name')) ],
                    [ 'field' => 'textarea', 'name' => 'remark', 'label' => title_case(__('datasets.remark')) ],
                ]
            ]
        ];
    }

    /**
     * Rules
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Dataset|null  $dataset
     * @return array
     */
    public static function rules(Request $request = null, Dataset $dataset = null)
    {
        return [
            'store' => [
                // 'parent_id' => 'required|exists:parents,id',
                'name' => 'required|string|max:255',
                'remark' => 'string|nullable',
            ],
            'update' => [
                // 'parent_id' => 'exists:parents,id',
                'name' => 'string|max:255',
                'remark' => 'string|nullable',
            ]
        ];
    }

    /**
    * Instantiate a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        // TODO: Add/Remove middleware as needed
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datasets = Dataset::filter()
            ->paginate()->appends(request()->query());
        $this->authorize('index', 'App\Dataset');

        return response()->view('datasets.index', [
            'datasets' => $datasets,
            'relations' => self::relations(request()),
            'visibles' => self::visibles(request())['index']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', 'App\Dataset');

        return response()->view('datasets.create', [
            'fields' => self::fields(request())['create']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', 'App\Dataset');
        $request->validate(self::rules($request)['store']);

        $dataset = new Dataset;
        foreach (self::rules($request)['store'] as $key => $value) {
            if (str_contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $dataset->{$key} = $request->file($key)->store('datasets');
                } elseif ($request->exists($key)) {
                    $dataset->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $dataset->{$key} = $request->{$key};
            }
        }
        // TODO: Add custom logic if any
        $dataset->save();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('datasets.show', $dataset->getKey());

        return $response->withInput([ $dataset->getForeignKey() => $dataset->getKey() ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dataset  $dataset
     * @return \Illuminate\Http\Response
     */
    public function show(Dataset $dataset)
    {
        $this->authorize('view', $dataset);

        return response()->view('datasets.show', [
            'dataset' => $dataset,
            'relations' => self::relations(request(), $dataset),
            'visibles' => self::visibles(request(), $dataset)['show'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dataset  $dataset
     * @return \Illuminate\Http\Response
     */
    public function edit(Dataset $dataset)
    {
        $this->authorize('update', $dataset);

        return response()->view('datasets.edit', [
            'dataset' => $dataset,
            'fields' => self::fields(request(), $dataset)['edit']
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dataset  $dataset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dataset $dataset)
    {
        $this->authorize('update', $dataset);
        $request->validate(self::rules($request, $dataset)['update']);

        foreach (self::rules($request, $dataset)['update'] as $key => $value) {
            if (str_contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $dataset->{$key} = $request->file($key)->store('datasets');
                } elseif ($request->exists($key)) {
                    $dataset->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $dataset->{$key} = $request->{$key};
            }
        }
        // TODO: Add custom logic if any
        $dataset->save();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('datasets.show', $dataset->getKey());

        return $response->withInput([ $dataset->getForeignKey() => $dataset->getKey() ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dataset  $dataset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dataset $dataset)
    {
        $this->authorize('delete', $dataset);
        $dataset->delete();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()) && !str_contains(request()->redirect, '/datasets/'.$dataset->getKey()))
            return response()->redirectTo(request()->redirect);
        else
            return response()->redirectToRoute('datasets.index');
    }
}
