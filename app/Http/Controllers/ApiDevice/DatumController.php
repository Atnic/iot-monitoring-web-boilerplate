<?php

namespace App\Http\Controllers\ApiDevice;

use App\Datum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\Resource;

/**
 * DatumController
 * @extends Controller
 */
class DatumController extends Controller
{
    /**
     * Rules
     * @param  \Illuminate\Http\Request|null  $request
     * @param  \App\Datum|null  $datum
     * @return array
     */
    public function rules(Request $request = null, Datum $datum = null)
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
        $this->middleware('auth:api_device');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataset = request()->user()->dataset()->firstOrFail();
        $data = Datum::filter()
            ->where($dataset->getForeignKey(), $dataset->getKey())
            ->paginate()->appends(request()->query());
        // $this->authorize('index', 'App\Datum'); // TODO: Policy

        return Resource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataset = $request->user()->dataset()->firstOrFail();

        // TODO: Add authorize for relation if any
        // $this->authorize('create', 'App\Datum'); // TODO: Policy
        $request->validate($this->rules($request)['store']);

        $datum = new Datum;
        foreach ($this->rules($request)['store'] as $key => $value) {
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
        $datum->save();

        return (new Resource($datum))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Datum  $datum
     * @return \Illuminate\Http\Response
     */
    public function show(Datum $datum)
    {
        $dataset = request()->user()->dataset()->findOrFail($datum->getKey());
        // $this->authorize('view', $datum); // TODO: Policy

        return new Resource($datum);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Datum  $datum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Datum $datum)
    {
        $dataset = $request->user()->dataset()->findOrFail($datum->getKey());
        // TODO: Add authorize for relation if any
        // $this->authorize('update', $datum); // TODO: Policy
        $request->validate($this->rules($request, $datum)['update']);

        foreach ($this->rules($request, $datum)['update'] as $key => $value) {
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
        // TODO: Add custom logic if any
        $datum->save();

        return new Resource($datum);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Datum  $datum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Datum $datum)
    {
        $dataset = request()->user()->dataset()->findOrFail($datum->getKey());
        // $this->authorize('delete', $datum); // TODO: Policy
        $datum->delete();

        return new Resource($datum);
    }
}
