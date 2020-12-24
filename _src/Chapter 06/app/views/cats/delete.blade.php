@extends('master')

@section('header')
  <h2> Delete {{$cat->name}}?  </h2>
@stop

@section('content')
  {{Form::open(array('method'=>'delete'))}}
  {{Form::close()}}
@stop
