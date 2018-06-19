@extends('datasets.show')

@include('generator::components.models.childs.index', [
  'resource_route' => 'datasets.data',
  'model_variable' => 'datum',
  'parent' => $dataset,
  'models' => $data
])
