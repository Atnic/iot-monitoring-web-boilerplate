<?php

namespace App\Http\Controllers\Dataset;

use App\Datum;
use App\Dataset;
use App\Parameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DatasetController;

/**
 * DatumController
 */
class DatumController extends Controller
{
    /**
     * Relations
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Dataset|null  $dataset
     * @param  \App\Datum|null  $datum
     * @return array
     */
    public static function relations(Request $request = null, Dataset $dataset = null, Datum $datum = null)
    {
        return [
            'dataset' => DatasetController::relations($request, $dataset)['dataset'],
            'datum' => [
                'belongsToMany' => [], // also for morphToMany
                'hasMany' => [], // also for morphMany, hasManyThrough
            ]
        ];
    }

    /**
     * Visibles
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Dataset|null  $dataset
     * @param  \App\Datum|null  $datum
     * @return array
     */
    public static function visibles(Request $request = null, Dataset $dataset = null, Datum $datum = null)
    {
        return [
            'parent' => [
                'dataset' => DatasetController::visibles($request, $dataset)['show']['dataset']
            ],
            'index' => [
                'datum' => [
                    [ 'name' => 'parameter', 'label' => title_case(__('data.parameter')), 'column' => 'name' ],
                    [ 'name' => 'value', 'label' => title_case(__('data.value')) ],
                    [ 'name' => 'logged_at', 'label' => title_case(__('data.logged_at')) ],
                ]
            ],
            'show' => [
                'datum' => [
                    [ 'name' => 'parameter', 'label' => title_case(__('data.parameter')), 'column' => 'name' ],
                    [ 'name' => 'value', 'label' => title_case(__('data.value')) ],
                    [ 'name' => 'logged_at', 'label' => title_case(__('data.logged_at')) ],
                ]
            ]
        ];
    }

    /**
     * Fields
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Dataset|null  $dataset
     * @param  \App\Datum|null  $datum
     * @return array
     */
    public static function fields(Request $request = null, Dataset $dataset = null, Datum $datum = null)
    {
        return [
            'create' => [
                'datum' => [
                    'parameter' => [ 'field' => 'select', 'name' => 'parameter_id', 'label' => title_case(__('data.parameter')), 'required' => true, 'options' => Parameter::all()->map(function ($parameter) {
                        return [ 'value' => $parameter->id, 'text' => $parameter->name ];
                    })->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'value', 'label' => title_case(__('data.value')), 'required' => true ],
                    [ 'field' => 'input', 'type' => 'datetime-local', 'name' => 'logged_at', 'label' => title_case(__('data.logged_at')).' (UTC)' ],
                ]
            ],
            'edit' => [
                'datum' => [
                    'parameter' => [ 'field' => 'select', 'name' => 'parameter_id', 'label' => title_case(__('data.parameter')), 'options' => Parameter::all()->map(function ($parameter) {
                        return [ 'value' => $parameter->id, 'text' => $parameter->name ];
                    })->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'value', 'label' => title_case(__('data.value')) ],
                    [ 'field' => 'input', 'type' => 'datetime-local', 'name' => 'logged_at', 'label' => title_case(__('data.logged_at')).' (UTC)' ],
                ]
            ]
        ];
    }

    /**
     * Rules
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Dataset|null  $dataset
     * @param  \App\Datum|null  $datum
     * @return array
     */
    public static function rules(Request $request = null, Dataset $dataset = null, Datum $datum = null)
    {
        return [
            'store' => [
                'parameter_id' => 'required|exists:parameters,id',
                'value' => 'required',
                'logged_at' => 'date|nullable',
            ],
            'update' => [
                'parameter_id' => 'exists:parameters,id',
                'value' => '',
                'logged_at' => 'date',
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
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Dataset  $dataset
     * @return \Illuminate\Http\Response
     */
    public function index(Dataset $dataset)
    {
        $this->authorize('view', $dataset);
        $data = Datum::filter()
            ->where($dataset->getForeignKey(), $dataset->getKey())
            ->paginate()->appends(request()->query());
        $this->authorize('index', 'App\Datum');

        return response()->view('datasets.data.index', [
            'dataset' => $dataset,
            'data' => $data,
            'relations' => self::relations(request(), $dataset),
            'visibles' => array_merge(self::visibles(request(), $dataset)['parent'], self::visibles(request(), $dataset)['index']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Dataset  $dataset
     * @return \Illuminate\Http\Response
     */
    public function create(Dataset $dataset)
    {
        $this->authorize('update', $dataset);
        $this->authorize('create', 'App\Datum');

        return response()->view('datasets.data.create', [
            'dataset' => $dataset,
            'relations' => self::relations(request(), $dataset),
            'visibles' => self::visibles(request(), $dataset)['parent'],
            'fields' => self::fields(request(), $dataset)['create']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dataset  $dataset
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Dataset $dataset)
    {
        $this->authorize('update', $dataset);
        $this->authorize('create', 'App\Datum');
        $request->validate(self::rules($request, $dataset)['store']);

        $datum = new Datum;
        foreach (self::rules($request, $dataset)['store'] as $key => $value) {
            if (str_contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $datum->{$key} = $request->file($key)->store('data');
                } elseif ($request->exists($key)) {
                    $datum->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $datum->{$key} = $request->{$key};
            }
        }
        $datum->dataset()->associate($dataset);
        // TODO: Add custom logic if any
        $datum->save();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('datasets.data.show', [ $dataset->getKey(), $datum->getKey() ]);

        return $response->withInput([
            $dataset->getForeignKey() => $dataset->getKey(),
            $datum->getForeignKey() => $datum->getKey(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dataset  $dataset
     * @param  \App\Datum  $datum
     * @return \Illuminate\Http\Response
     */
    public function show(Dataset $dataset, Datum $datum)
    {
        $dataset->data()->findOrFail($datum->getKey());
        $this->authorize('view', $dataset);
        $this->authorize('view', $datum);

        return response()->view('datasets.data.show', [
            'dataset' => $dataset,
            'datum' => $datum,
            'relations' => self::relations(request(), $dataset, $datum),
            'visibles' => array_merge(self::visibles(request(), $dataset, $datum)['parent'], self::visibles(request(), $dataset, $datum)['show'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dataset  $dataset
     * @param  \App\Datum  $datum
     * @return \Illuminate\Http\Response
     */
    public function edit(Dataset $dataset, Datum $datum)
    {
        $dataset->data()->findOrFail($datum->getKey());
        $this->authorize('update', $dataset);
        $this->authorize('update', $datum);

        return response()->view('datasets.data.edit', [
            'dataset' => $dataset,
            'datum' => $datum,
            'relations' => self::relations(request(), $dataset, $datum),
            'visibles' => self::visibles(request(), $dataset, $datum)['parent'],
            'fields' => self::fields(request(), $dataset, $datum)['edit']
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dataset  $dataset
     * @param  \App\Datum  $datum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dataset $dataset, Datum $datum)
    {
        $dataset->data()->findOrFail($datum->getKey());

        // TODO: Add authorize for relation if any
        $this->authorize('update', $dataset);
        $this->authorize('update', $datum);
        $request->validate(self::rules($request, $dataset, $datum)['update']);

        foreach (self::rules($request, $dataset, $datum)['update'] as $key => $value) {
            if (str_contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $datum->{$key} = $request->file($key)->store('data');
                } elseif ($request->exists($key)) {
                    $datum->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $datum->{$key} = $request->{$key};
            }
        }
        $datum->dataset()->associate($dataset);
        // TODO: Add custom logic if any
        $datum->save();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('datasets.data.show', [ $dataset->getKey(), $datum->getKey() ]);

        return $response->withInput([
            $dataset->getForeignKey() => $dataset->getKey(),
            $datum->getForeignKey() => $datum->getKey(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dataset  $dataset
     * @param  \App\Datum  $datum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dataset $dataset, Datum $datum)
    {
        $dataset->data()->findOrFail($datum->getKey());
        $this->authorize('update', $dataset);
        $this->authorize('delete', $datum);
        $datum->delete();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()) && !str_contains(request()->redirect, '/'.array_last(explode('.', 'datasets.data')).'/'.$datum->getKey()))
            return response()->redirectTo(request()->redirect);
        else
            return response()->redirectToRoute('datasets.data.index', $dataset->getKey());
    }
}
