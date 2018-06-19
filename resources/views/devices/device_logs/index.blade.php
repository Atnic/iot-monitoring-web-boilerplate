@extends('devices.show')

@include('generator::components.models.childs.index', [
  'resource_route' => 'devices.device_logs',
  'model_variable' => 'device_log',
  'parent' => $device,
  'models' => $device_logs
])
