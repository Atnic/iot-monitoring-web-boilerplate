<?php

namespace App\Http\Controllers\Device;

use App\DeviceLog;
use App\Device;
use App\DeviceParameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DeviceController;

/**
 * DeviceLogController
 */
class DeviceLogController extends Controller
{
    /**
     * Relations
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Device|null  $device
     * @param  \App\DeviceLog|null  $device_log
     * @return array
     */
    public static function relations(Request $request = null, Device $device = null, DeviceLog $device_log = null)
    {
        return [
            'device' => DeviceController::relations($request, $device)['device'],
            'device_log' => [
                'belongsToMany' => [], // also for morphToMany
                'hasMany' => [], // also for morphMany, hasManyThrough
            ]
        ];
    }

    /**
     * Visibles
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Device|null  $device
     * @param  \App\DeviceLog|null  $device_log
     * @return array
     */
    public static function visibles(Request $request = null, Device $device = null, DeviceLog $device_log = null)
    {
        return [
            'parent' => [
                'device' => DeviceController::visibles($request, $device)['show']['device']
            ],
            'index' => [
                'device_log' => [
                    [ 'name' => 'device_parameter', 'label' => title_case(__('device_logs.device_parameter')), 'column' => 'name' ],
                    [ 'name' => 'value', 'label' => title_case(__('device_logs.value')) ],
                    [ 'name' => 'logged_at', 'label' => title_case(__('device_logs.logged_at')) ],
                ]
            ],
            'show' => [
                'device_log' => [
                    [ 'name' => 'device_parameter', 'label' => title_case(__('device_logs.device_parameter')), 'column' => 'name' ],
                    [ 'name' => 'value', 'label' => title_case(__('device_logs.value')) ],
                    [ 'name' => 'logged_at', 'label' => title_case(__('device_logs.logged_at')) ],
                ]
            ]
        ];
    }

    /**
     * Fields
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Device|null  $device
     * @param  \App\DeviceLog|null  $device_log
     * @return array
     */
    public static function fields(Request $request = null, Device $device = null, DeviceLog $device_log = null)
    {
        return [
            'create' => [
                'device_log' => [
                    'device_parameter' => [ 'field' => 'input', 'type' => 'text', 'name' => 'device_parameter_id', 'label' => title_case(__('device_logs.device_parameter')), 'required' => true, 'options' => DeviceParameter::all()->map(function ($device_parameter) {
                        return [ 'value' => $device_parameter->id, 'text' => $device_parameter->name ];
                    })->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'value', 'label' => title_case(__('device_logs.value')), 'required' => true ],
                    [ 'field' => 'input', 'type' => 'datetime-local', 'name' => 'logged_at', 'label' => title_case(__('device_logs.logged_at')).' (UTC)' ],
                ]
            ],
            'edit' => [
                'device_log' => [
                    'device_parameter' => [ 'field' => 'input', 'type' => 'text', 'name' => 'device_parameter_id', 'label' => title_case(__('device_logs.device_parameter')), 'options' => DeviceParameter::all()->map(function ($device_parameter) {
                        return [ 'value' => $device_parameter->id, 'text' => $device_parameter->name ];
                    })->prepend([ 'value' => '', 'text' => '-' ])->toArray() ],
                    [ 'field' => 'input', 'type' => 'text', 'name' => 'value', 'label' => title_case(__('device_logs.value')) ],
                    [ 'field' => 'input', 'type' => 'datetime-local', 'name' => 'logged_at', 'label' => title_case(__('device_logs.logged_at')).' (UTC)' ],
                ]
            ]
        ];
    }

    /**
     * Rules
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Device|null  $device
     * @param  \App\DeviceLog|null  $device_log
     * @return array
     */
    public static function rules(Request $request = null, Device $device = null, DeviceLog $device_log = null)
    {
        return [
            'store' => [
                'device_parameter_id' => 'required|exists:device_parameters,id',
                'value' => 'required',
                'logged_at' => 'date|nullable',
            ],
            'update' => [
                'device_parameter_id' => 'exists:device_parameters,id',
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
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function index(Device $device)
    {
        $this->authorize('view', $device);
        $device_logs = DeviceLog::filter()
            ->where($device->getForeignKey(), $device->getKey())
            ->paginate()->appends(request()->query());
        $this->authorize('index', 'App\DeviceLog');

        return response()->view('devices.device_logs.index', [
            'device' => $device,
            'device_logs' => $device_logs,
            'relations' => self::relations(request(), $device),
            'visibles' => array_merge(self::visibles(request(), $device)['parent'], self::visibles(request(), $device)['index']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function create(Device $device)
    {
        $this->authorize('update', $device);
        $this->authorize('create', 'App\DeviceLog');

        return response()->view('devices.device_logs.create', [
            'device' => $device,
            'relations' => self::relations(request(), $device),
            'visibles' => self::visibles(request(), $device)['parent'],
            'fields' => self::fields(request(), $device)['create']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Device $device)
    {
        $this->authorize('update', $device);
        $this->authorize('create', 'App\DeviceLog');
        $request->validate(self::rules($request, $device)['store']);

        $device_log = new DeviceLog;
        foreach (self::rules($request, $device)['store'] as $key => $value) {
            if (str_contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $device_log->{$key} = $request->file($key)->store('device_logs');
                } elseif ($request->exists($key)) {
                    $device_log->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $device_log->{$key} = $request->{$key};
            }
        }
        $device_log->device()->associate($device);
        $device_log->save();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('devices.device_logs.show', [ $device->getKey(), $device_log->getKey() ]);

        return $response->withInput([
            $device->getForeignKey() => $device->getKey(),
            $device_log->getForeignKey() => $device_log->getKey(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Device  $device
     * @param  \App\DeviceLog  $device_log
     * @return \Illuminate\Http\Response
     */
    public function show(Device $device, DeviceLog $device_log)
    {
        $device->device_logs()->findOrFail($device_log->getKey());
        $this->authorize('view', $device);
        $this->authorize('view', $device_log);

        return response()->view('devices.device_logs.show', [
            'device' => $device,
            'device_log' => $device_log,
            'relations' => self::relations(request(), $device, $device_log),
            'visibles' => array_merge(self::visibles(request(), $device, $device_log)['parent'], self::visibles(request(), $device, $device_log)['show'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Device  $device
     * @param  \App\DeviceLog  $device_log
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device, DeviceLog $device_log)
    {
        $device->device_logs()->findOrFail($device_log->getKey());
        $this->authorize('update', $device);
        $this->authorize('update', $device_log);

        return response()->view('devices.device_logs.edit', [
            'device' => $device,
            'device_log' => $device_log,
            'relations' => self::relations(request(), $device, $device_log),
            'visibles' => self::visibles(request(), $device, $device_log)['parent'],
            'fields' => self::fields(request(), $device, $device_log)['edit']
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Device  $device
     * @param  \App\DeviceLog  $device_log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device, DeviceLog $device_log)
    {
        $device->device_logs()->findOrFail($device_log->getKey());

        $this->authorize('update', $device);
        $this->authorize('update', $device_log);
        $request->validate(self::rules($request, $device, $device_log)['update']);

        foreach (self::rules($request, $device, $device_log)['update'] as $key => $value) {
            if (str_contains($value, [ 'file', 'image', 'mimetypes', 'mimes' ])) {
                if ($request->hasFile($key)) {
                    $device_log->{$key} = $request->file($key)->store('device_logs');
                } elseif ($request->exists($key)) {
                    $device_log->{$key} = $request->{$key};
                }
            } elseif ($request->exists($key)) {
                $device_log->{$key} = $request->{$key};
            }
        }
        $device_log->device()->associate($device);
        $device_log->save();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()))
            $response = response()->redirectTo(request()->redirect);
        else
            $response = response()->redirectToRoute('devices.device_logs.show', [ $device->getKey(), $device_log->getKey() ]);

        return $response->withInput([
            $device->getForeignKey() => $device->getKey(),
            $device_log->getForeignKey() => $device_log->getKey(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Device  $device
     * @param  \App\DeviceLog  $device_log
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device, DeviceLog $device_log)
    {
        $device->device_logs()->findOrFail($device_log->getKey());
        $this->authorize('update', $device);
        $this->authorize('delete', $device_log);
        $device_log->delete();

        if (request()->filled('redirect') && starts_with(request()->redirect, request()->root()) && !str_contains(request()->redirect, '/'.array_last(explode('.', 'devices.device_logs')).'/'.$device_log->getKey()))
            return response()->redirectTo(request()->redirect);
        else
            return response()->redirectToRoute('devices.device_logs.index', $device->getKey());
    }
}
