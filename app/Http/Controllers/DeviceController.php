<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

/**
 * DeviceController
 */
class DeviceController extends Controller
{
    /**
     * Relations
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Device|null  $device
     * @return array
     */
    public static function relations(Request $request = null, Device $device = null)
    {
        return [
            'device' => [
                'belongsToMany' => [], // also for morphToMany
                'hasMany' => [
                    // [ 'name' => 'childs', 'label' => title_case(__('devices.childs')) ], // Example
                ], // also for morphMany, hasManyThrough
            ]
        ];
    }

    /**
     * Visibles
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Device|null  $device
     * @return array
     */
    public static function visibles(Request $request = null, Device $device = null)
    {
        return [
            'index' => [
                'device' => [
                    // [ 'name' => 'parent', 'label' => title_case(__('devices.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'imei', 'label' => title_case(__('devices.imei')) ],
                    [ 'name' => 'name', 'label' => title_case(__('devices.name')) ],
                ]
            ],
            'show' => [
                'device' => [
                    // [ 'name' => 'parent', 'label' => title_case(__('devices.parent')), 'column' => 'name' ], // Only support belongsTo, hasOne
                    [ 'name' => 'imei', 'label' => title_case(__('devices.imei')) ],
                    [ 'name' => 'name', 'label' => title_case(__('devices.name')) ],
                ]
            ]
        ];
    }

    /**
     * Fields
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Device|null  $device
     * @return array
     */
    public static function fields(Request $request = null, Device $device = null)
    {
        return [
            'create' => [
                'device' => [
                    // [ 'field' => 'select', 'name' => 'parent_id', 'label' => title_case(__('bars.parent')), 'required' => true, 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //     return [ 'value' => $parent->id, 'text' => $parent->name ];
                    // })->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'number', 'name' => 'imei', 'label' => title_case(__('devices.imei')), 'required' => true ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => title_case(__('devices.name')), 'required' => true ],
                ]
            ],
            'edit' => [
                'device' => [
                    // [ 'field' => 'select', 'name' => 'parent_id', 'label' => title_case(__('bars.parent')), 'options' => \App\Parent::filter()->get()->map(function ($parent) {
                    //     return [ 'value' => $parent->id, 'text' => $parent->name ];
                    // })->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'number', 'name' => 'imei', 'label' => title_case(__('devices.imei')) ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'name', 'label' => title_case(__('devices.name')) ],
                ]
            ]
        ];
    }

    /**
     * Rules
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Device|null  $device
     * @return array
     */
    public static function rules(Request $request = null, Device $device = null)
    {
        return [
            'store' => [
                // 'parent_id' => 'required|exists:parents,id',
                'imei' => 'required|numeric|unique:devices',
                'name' => 'required|string|max:255',
            ],
            'update' => [
                // 'parent_id' => 'exists:parents,id',
                'imei' => 'numeric|unique:devices,imei,'.($device ? $device->getKey() : 'NULL').',imei',
                'name' => 'string|max:255',
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
        $devices = Device::filter()
            ->paginate()->appends(request()->query());
        $this->authorize('index', 'App\Device');

        return response()->view('devices.index', [
            'devices' => $devices,
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
        $this->authorize('create', 'App\Device');

        return response()->view('devices.create', [
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
        $this->authorize('create', 'App\Device');
        $request->validate(self::rules($request)['store']);

        $device = new Device;
        foreach (self::rules($request)['store'] as $key => $value) {
            if (str_contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $device->{$key} = $request->file($key)->store('devices');
                } elseif ($request->exists($key)) {
                    $device->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $device->{$key} = $request->{$key};
            }
        }
        $device->save();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('devices.show', $device->getKey());

        return $response->withInput([ $device->getForeignKey() => $device->getKey() ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function show(Device $device)
    {
        $this->authorize('view', $device);

        return response()->view('devices.show', [
            'device' => $device,
            'relations' => self::relations(request(), $device),
            'visibles' => self::visibles(request(), $device)['show'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device)
    {
        $this->authorize('update', $device);

        return response()->view('devices.edit', [
            'device' => $device,
            'fields' => self::fields(request(), $device)['edit']
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device)
    {
        $this->authorize('update', $device);
        $request->validate(self::rules($request, $device)['update']);

        foreach (self::rules($request, $device)['update'] as $key => $value) {
            if (str_contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $device->{$key} = $request->file($key)->store('devices');
                } elseif ($request->exists($key)) {
                    $device->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $device->{$key} = $request->{$key};
            }
        }
        $device->save();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('devices.show', $device->getKey());

        return $response->withInput([ $device->getForeignKey() => $device->getKey() ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {
        $this->authorize('delete', $device);
        $device->delete();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()) && !str_contains(request()->redirect, '/devices/'.$device->getKey()))
            return response()->redirectTo(request()->redirect);
        else
            return response()->redirectToRoute('devices.index');
    }
}
