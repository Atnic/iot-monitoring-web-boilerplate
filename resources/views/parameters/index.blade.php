@extends('layouts.app')

@section('content-title', title_case(__('parameters.plural')))

@include('generator::components.models.index', [
  'col_class' => 'col-md-8 col-md-offset-2',
  'panel_title' => title_case(__('parameters.plural')),
  'resource_route' => 'parameters',
  'model_variable' => 'parameter',
  'models' => $parameters
])
