@extends('master')

@section('header')
  @if(isset($breed))
    <a href="{{URL::to('/')}}">Back to the overview</a>
  @endif
  <h2>
    All @if(isset($breed)) {{$breed}} @endif Cats
    @if(Auth::check())
      <a href="{{URL::to('cats/create')}}" 
         class="btn btn-primary pull-right">
        Add a new cat
      </a>
    @endif
  </h2>
@stop

@section('content')
  @foreach($cats as $cat)
    <div class="cat">
      <a href="{{URL::to('cats/'.$cat->id)}}">
        <strong> {{{$cat->name}}} </strong> - {{$cat->breed->name}}
        @if(Auth::check() and Auth::user()->owns($cat))*@endif
      </a>
    </div>
  @endforeach
  @if(Auth::check())
    <hr />
    <small class="small">* cats you own</small>
  @endif
@stop

