@extends('layouts.app')

@section('content')
  <div id="children-view-container" class="container">
    <child-view-page-component childHash="{{$hash}}"></child-view-page-component>
  </div>
@endsection