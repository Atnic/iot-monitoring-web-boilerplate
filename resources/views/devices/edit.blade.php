@extends('layouts.app')

@section('content-title', title_case(__('devices.plural')))

@include('generator::components.models.edit', [
  'panel_title' => title_case(__('devices.singular')),
  'resource_route' => 'devices',
  'model_variable' => 'device',
  'model' => $device
])
