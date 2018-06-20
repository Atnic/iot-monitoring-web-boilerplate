<?php

namespace App\Http\Controllers\ApiDevice;

use App\DeviceLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\Resource;

/**
 * DeviceLogController
 * @extends Controller
 */
class DeviceLogController extends Controller
{
    /**
     * Rules
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\DeviceLog|null  $device_log
     * @return array
     */
    public function rules(Request $request = null, DeviceLog $device_log = null)
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
        $this->middleware('auth:api_device');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $device_logs = DeviceLog::filter()->paginate();
        // $this->authorize('index', 'App\DeviceLog'); // TODO: Policy

        return Resource::collection($device_logs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO: Add authorize for relation if any
        // $this->authorize('create', 'App\DeviceLog'); // TODO: Policy
        $request->validate($this->rules($request)['store']);

        $device_log = new DeviceLog;
        foreach ($this->rules($request)['store'] as $key => $value) {
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
        $device_log->device()->associate($request->user());
        $device_log->save();

        return (new Resource($device_log))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DeviceLog  $device_log
     * @return \Illuminate\Http\Response
     */
    public function show(DeviceLog $device_log)
    {
        // $this->authorize('view', $device_log); // TODO: Policy

        return new Resource($device_log);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DeviceLog  $device_log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeviceLog $device_log)
    {
        // TODO: Add authorize for relation if any
        // $this->authorize('update', $device_log); // TODO: Policy
        $request->validate($this->rules($request, $device_log)['update']);

        foreach ($this->rules($request, $device_log)['update'] as $key => $value) {
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
        // TODO: Add custom logic if any
        $device_log->save();

        return new Resource($device_log);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DeviceLog  $device_log
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeviceLog $device_log)
    {
        // $this->authorize('delete', $device_log); // TODO: Policy
        $device_log->delete();

        return new Resource($device_log);
    }
}
