@extends('master')
@section('header')
<h2> Please Log In </h2>
@stop
@section('content')
{{Form::open()}}
  <div class="form-group">
    {{Form::label('Username')}} {{Form::text('username')}}
  </div>
  <div class="form-group">
    {{Form::label('Password')}} {{Form::password('password')}}
  </div>
  {{Form::submit("Log in", array("class"=>"btn btn-default"))}}
{{Form::close()}}
@stop
