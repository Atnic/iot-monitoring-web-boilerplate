<?php

namespace App\Http\Controllers;

use App\Parameter;
use Illuminate\Http\Request;

/**
 * ParameterController
 */
class ParameterController extends Controller
{
    /**
     * Relations
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Parameter|null  $parameter
     * @return array
     */
    public static function relations(Request $request = null, Parameter $parameter = null)
    {
        return [
            'parameter' => [
                'belongsToMany' => [], // also for morphToMany
                'hasMany' => [
                    // [ 'name' => 'childs', 'label' => title_case(__('parameters.childs')) ], // Example
                ], // also for morphMany, hasManyThrough
            ]
        ];
    }

    /**
     * Visibles
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Parameter|null  $parameter
     * @return array
     */
    public static function visibles(Request $request = null, Parameter $parameter = null)
    {
        return [
            'index' => [
                'parameter' => [
                    // [ 'name' => 'parent', 'label' => title_case(__('device_parameters.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'code', 'label' => title_case(__('device_parameters.code')) ],
                    [ 'name' => 'nama', 'label' => title_case(__('device_parameters.nama')) ],
                    [ 'name' => 'unit', 'label' => title_case(__('device_parameters.unit')) ],
                ]
            ],
            'show' => [
                'parameter' => [
                    // [ 'name' => 'parent', 'label' => title_case(__('device_parameters.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'code', 'label' => title_case(__('device_parameters.code')) ],
                    [ 'name' => 'nama', 'label' => title_case(__('device_parameters.nama')) ],
                    [ 'name' => 'unit', 'label' => title_case(__('device_parameters.unit')) ],
                ]
            ]
        ];
    }

    /**
     * Fields
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Parameter|null  $parameter
     * @return array
     */
    public static function fields(Request $request = null, Parameter $parameter = null)
    {
        return [
            'create' => [
                'parameter' => [
                    // [ 'field' => 'select', 'name' => 'parent_id', 'label' => title_case(__('bars.parent')), 'required' => true, 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //     return [ 'value' => $parent->id, 'text' => $parent->name ];
                    // })->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'code', 'label' => title_case(__('device_parameters.code')), 'required' => true ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => title_case(__('device_parameters.name')) ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'unit', 'label' => title_case(__('device_parameters.unit')) ],
                ]
            ],
            'edit' => [
                'parameter' => [
                    // [ 'field' => 'select', 'name' => 'parent_id', 'label' => title_case(__('bars.parent')), 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //     return [ 'value' => $parent->id, 'text' => $parent->name ];
                    // })->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'code', 'label' => title_case(__('device_parameters.code')) ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => title_case(__('device_parameters.name')) ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'unit', 'label' => title_case(__('device_parameters.unit')) ],
                ]
            ]
        ];
    }

    /**
     * Rules
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Parameter|null  $parameter
     * @return array
     */
    public static function rules(Request $request = null, Parameter $parameter = null)
    {
        return [
            'store' => [
                'code' => 'string|max:255|nullable|unique:parameters',
                'name' => 'required|string|max:255',
                'unit' => 'string|max:255|nullable',
            ],
            'update' => [
                'code' => 'string|max:255|nullable|unique:parameters,code,'.($parameter ? $parameter->getKey() : 'NULL').',code',
                'name' => 'string|max:255',
                'unit' => 'string|max:255|nullable',
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = Parameter::filter()
            ->paginate()->appends(request()->query());
        $this->authorize('index', 'App\Parameter');

        return response()->view('parameters.index', [
            'parameters' => $parameters,
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
        $this->authorize('create', 'App\Parameter');

        return response()->view('parameters.create', [
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
        $this->authorize('create', 'App\Parameter');
        $request->validate(self::rules($request)['store']);

        $parameter = new Parameter;
        foreach (self::rules($request)['store'] as $key => $value) {
            if (str_contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $parameter->{$key} = $request->file($key)->store('parameters');
                } elseif ($request->exists($key)) {
                    $parameter->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $parameter->{$key} = $request->{$key};
            }
        }
        // TODO: Add custom logic if any
        $parameter->save();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('parameters.show', $parameter->getKey());

        return $response->withInput([ $parameter->getForeignKey() => $parameter->getKey() ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function show(Parameter $parameter)
    {
        $this->authorize('view', $parameter);

        return response()->view('parameters.show', [
            'parameter' => $parameter,
            'relations' => self::relations(request(), $parameter),
            'visibles' => self::visibles(request(), $parameter)['show'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function edit(Parameter $parameter)
    {
        $this->authorize('update', $parameter);

        return response()->view('parameters.edit', [
            'parameter' => $parameter,
            'fields' => self::fields(request(), $parameter)['edit']
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parameter $parameter)
    {
        $this->authorize('update', $parameter);
        $request->validate(self::rules($request, $parameter)['update']);

        foreach (self::rules($request, $parameter)['update'] as $key => $value) {
            if (str_contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $parameter->{$key} = $request->file($key)->store('parameters');
                } elseif ($request->exists($key)) {
                    $parameter->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $parameter->{$key} = $request->{$key};
            }
        }
        // TODO: Add custom logic if any
        $parameter->save();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('parameters.show', $parameter->getKey());

        return $response->withInput([ $parameter->getForeignKey() => $parameter->getKey() ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parameter  $parameter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parameter $parameter)
    {
        $this->authorize('delete', $parameter);
        $parameter->delete();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()) && !str_contains(request()->redirect, '/parameters/'.$parameter->getKey()))
            return response()->redirectTo(request()->redirect);
        else
            return response()->redirectToRoute('parameters.index');
    }
}
