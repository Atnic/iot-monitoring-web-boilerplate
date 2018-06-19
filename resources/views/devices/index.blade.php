@extends('layouts.app')

@section('content-title', title_case(__('devices.plural')))

@include('generator::components.models.index', [
  'col_class' => 'col-md-8 col-md-offset-2',
  'panel_title' => title_case(__('devices.plural')),
  'resource_route' => 'devices',
  'model_variable' => 'device',
  'models' => $devices
])
