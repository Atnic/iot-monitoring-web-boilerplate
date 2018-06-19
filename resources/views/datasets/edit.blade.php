@extends('layouts.app')

@section('content-title', title_case(__('datasets.plural')))

@include('generator::components.models.edit', [
  'panel_title' => title_case(__('datasets.singular')),
  'resource_route' => 'datasets',
  'model_variable' => 'dataset',
  'model' => $dataset
])
