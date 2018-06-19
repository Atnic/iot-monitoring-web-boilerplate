@extends('datasets.show')

@include('generator::components.models.childs.create', [
  'resource_route' => 'datasets.data',
  'model_variable' => 'datum',
  'parent' => $dataset
])
