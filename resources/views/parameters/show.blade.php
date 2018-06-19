@extends('layouts.app')

@section('content-title', title_case(__('parameters.plural')))

@include('generator::components.models.show', [
  'panel_title' => title_case(__('parameters.singular')),
  'resource_route' => 'parameters',
  'model_variable' => 'parameter',
  'model' => $parameter
])
