@extends('datasets.show')

@include('generator::components.models.childs.show', [
  'resource_route' => 'datasets.data',
  'model_variable' => 'datum',
  'parent' => $dataset,
  'model' => $datum
])
