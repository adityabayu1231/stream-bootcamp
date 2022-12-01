@extends('admin.layouts.base')
@section('title', 'Dashboard Admin')

@section('content')
    {{-- <h3>Welcome {{ Auth::user()->name; }}</h3> --}}
    <h3>Welcome {{ auth()->user()->name; }}</h3>
@endsection