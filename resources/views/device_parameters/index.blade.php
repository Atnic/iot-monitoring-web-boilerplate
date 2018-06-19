@extends('layouts.app')

@section('content-title', title_case(__('device_parameters.plural')))

@include('generator::components.models.index', [
  'col_class' => 'col-md-8 col-md-offset-2',
  'panel_title' => title_case(__('device_parameters.plural')),
  'resource_route' => 'device_parameters',
  'model_variable' => 'device_parameter',
  'models' => $device_parameters
])
