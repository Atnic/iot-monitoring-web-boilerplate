@extends('layouts.app')

@section('content-title', title_case(__('datasets.plural')))

@include('generator::components.models.index', [
  'col_class' => 'col-md-8 col-md-offset-2',
  'panel_title' => title_case(__('datasets.plural')),
  'resource_route' => 'datasets',
  'model_variable' => 'dataset',
  'models' => $datasets
])
