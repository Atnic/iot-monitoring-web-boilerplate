@extends('devices.show')

@include('generator::components.models.childs.create', [
  'resource_route' => 'devices.device_logs',
  'model_variable' => 'device_log',
  'parent' => $device
])
