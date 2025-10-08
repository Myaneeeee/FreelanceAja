@extends('layouts.app')

@section('title', $profile['company_name'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ $profile['company_name'] }}</h1>
        </div>
        <div class="card-body">
            <p><strong>User:</strong> {{ $user['name'] }} ({{ $user['email'] }})</p>
            <p><strong>Description:</strong> {{ $profile['company_description'] }}</p>
            <p><strong>Website:</strong> <a href="{{ $profile['website_url'] }}">{{ $profile['website_url'] }}</a></p>
        </div>
    </div>
@endsection
