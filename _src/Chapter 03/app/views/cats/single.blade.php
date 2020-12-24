@extends('master')

@section('header')
  <a href="{{URL::to('/')}}">Back to overview</a>
  <h2>
    {{$cat->name}}
  </h2>
    <a href="{{URL::to('cats/'.$cat->id.'/edit')}}">
      <span class="glyphicon glyphicon-edit"></span> Edit
    </a>
    <a href="{{URL::to('cats/'.$cat->id.'/delete')}}">
      <span class="glyphicon glyphicon-trash"></span> Delete
    </a>
    Last edited {{$cat->updated_at}}
@stop

@section('content')
  <p> Age: {{$cat->date_of_birth}} </p>
  <p>
    @if($cat->breed)
      Breed: 
      <a href="{{URL::to('cats/breeds/' . $cat->breed->name)}}">
        {{$cat->breed->name}}
      </a>
    @endif
  </p>
@stop
