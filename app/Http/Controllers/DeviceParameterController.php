<?php

namespace App\Http\Controllers;

use App\DeviceParameter;
use Illuminate\Http\Request;

/**
 * DeviceParameterController
 */
class DeviceParameterController extends Controller
{
    /**
     * Relations
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\DeviceParameter|null  $device_parameter
     * @return array
     */
    public static function relations(Request $request = null, DeviceParameter $device_parameter = null)
    {
        return [
            'device_parameter' => [
                'belongsToMany' => [], // also for morphToMany
                'hasMany' => [
                    // [ 'name' => 'childs', 'label' => title_case(__('device_parameters.childs')) ], // Example
                ], // also for morphMany, hasManyThrough
            ]
        ];
    }

    /**
     * Visibles
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\DeviceParameter|null  $device_parameter
     * @return array
     */
    public static function visibles(Request $request = null, DeviceParameter $device_parameter = null)
    {
        return [
            'index' => [
                'device_parameter' => [
                    // [ 'name' => 'parent', 'label' => title_case(__('device_parameters.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'code', 'label' => title_case(__('device_parameters.code')) ],
                    [ 'name' => 'nama', 'label' => title_case(__('device_parameters.nama')) ],
                    [ 'name' => 'unit', 'label' => title_case(__('device_parameters.unit')) ],
                ]
            ],
            'show' => [
                'device_parameter' => [
                    // [ 'name' => 'parent', 'label' => title_case(__('device_parameters.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'code', 'label' => title_case(__('device_parameters.code')) ],
                    [ 'name' => 'name', 'label' => title_case(__('device_parameters.name')) ],
                    [ 'name' => 'unit', 'label' => title_case(__('device_parameters.unit')) ],
                ]
            ]
        ];
    }

    /**
     * Fields
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\DeviceParameter|null  $device_parameter
     * @return array
     */
    public static function fields(Request $request = null, DeviceParameter $device_parameter = null)
    {
        return [
            'create' => [
                'device_parameter' => [
                    // [ 'field' => 'select', 'name' => 'parent_id', 'label' => title_case(__('bars.parent')), 'required' => true, 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //     return [ 'value' => $parent->id, 'text' => $parent->name ];
                    // })->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'code', 'label' => title_case(__('device_parameters.code')), 'required' => true ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => title_case(__('device_parameters.name')) ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'unit', 'label' => title_case(__('device_parameters.unit')) ],
                ]
            ],
            'edit' => [
                'device_parameter' => [
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
     * @param  \App\DeviceParameter|null  $device_parameter
     * @return array
     */
    public static function rules(Request $request = null, DeviceParameter $device_parameter = null)
    {
        return [
            'store' => [
                'code' => 'string|max:255|nullable|unique:device_parameters',
                'name' => 'required|string|max:255',
                'unit' => 'string|max:255|nullable',
            ],
            'update' => [
                'code' => 'string|max:255|nullable|unique:device_parameters,code,'.($device_parameter ? $device_parameter->getKey() : 'NULL').',code',
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
        $device_parameters = DeviceParameter::filter()
            ->paginate()->appends(request()->query());
        $this->authorize('index', 'App\DeviceParameter');

        return response()->view('device_parameters.index', [
            'device_parameters' => $device_parameters,
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
        $this->authorize('create', 'App\DeviceParameter');

        return response()->view('device_parameters.create', [
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
        $this->authorize('create', 'App\DeviceParameter');
        $request->validate(self::rules($request)['store']);

        $device_parameter = new DeviceParameter;
        foreach (self::rules($request)['store'] as $key => $value) {
            if (str_contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $device_parameter->{$key} = $request->file($key)->store('device_parameters');
                } elseif ($request->exists($key)) {
                    $device_parameter->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $device_parameter->{$key} = $request->{$key};
            }
        }
        $device_parameter->save();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('device_parameters.show', $device_parameter->getKey());

        return $response->withInput([ $device_parameter->getForeignKey() => $device_parameter->getKey() ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DeviceParameter  $device_parameter
     * @return \Illuminate\Http\Response
     */
    public function show(DeviceParameter $device_parameter)
    {
        $this->authorize('view', $device_parameter);

        return response()->view('device_parameters.show', [
            'device_parameter' => $device_parameter,
            'relations' => self::relations(request(), $device_parameter),
            'visibles' => self::visibles(request(), $device_parameter)['show'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DeviceParameter  $device_parameter
     * @return \Illuminate\Http\Response
     */
    public function edit(DeviceParameter $device_parameter)
    {
        $this->authorize('update', $device_parameter);

        return response()->view('device_parameters.edit', [
            'device_parameter' => $device_parameter,
            'fields' => self::fields(request(), $device_parameter)['edit']
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DeviceParameter  $device_parameter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeviceParameter $device_parameter)
    {
        $this->authorize('update', $device_parameter);
        $request->validate(self::rules($request, $device_parameter)['update']);

        foreach (self::rules($request, $device_parameter)['update'] as $key => $value) {
            if (str_contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $device_parameter->{$key} = $request->file($key)->store('device_parameters');
                } elseif ($request->exists($key)) {
                    $device_parameter->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $device_parameter->{$key} = $request->{$key};
            }
        }
        $device_parameter->save();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('device_parameters.show', $device_parameter->getKey());

        return $response->withInput([ $device_parameter->getForeignKey() => $device_parameter->getKey() ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DeviceParameter  $device_parameter
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeviceParameter $device_parameter)
    {
        $this->authorize('delete', $device_parameter);
        $device_parameter->delete();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()) && !str_contains(request()->redirect, '/device_parameters/'.$device_parameter->getKey()))
            return response()->redirectTo(request()->redirect);
        else
            return response()->redirectToRoute('device_parameters.index');
    }
}
