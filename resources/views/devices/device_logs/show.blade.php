@extends('devices.show')

@include('generator::components.models.childs.show', [
  'resource_route' => 'devices.device_logs',
  'model_variable' => 'device_log',
  'parent' => $device,
  'model' => $device_log
])
