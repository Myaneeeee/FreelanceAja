@extends('layouts.app')

@section('title', 'Landing Page')

@section('sidebar')
    @@parent
@endsection

@section('content')
    <p>This is landing page</p>
    <div class="alert alert-primary" role="alert">
        A simple primary alert—check it out!
    </div>
@endsection
