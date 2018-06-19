@extends('layouts.app')

@section('content-title', title_case(__('device_parameters.plural')))

@include('generator::components.models.show', [
  'panel_title' => title_case(__('device_parameters.singular')),
  'resource_route' => 'device_parameters',
  'model_variable' => 'device_parameter',
  'model' => $device_parameter
])
