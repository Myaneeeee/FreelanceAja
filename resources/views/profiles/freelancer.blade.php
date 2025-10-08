@extends('layouts.app')

@section('title', $profile['headline'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>{{ $profile['headline'] }}</h1>
        </div>
        <div class="card-body">
            <p><strong>User:</strong> {{ $user['name'] }} ({{ $user['email'] }})</p>
            <p><strong>Bio:</strong> {{ $profile['bio'] }}</p>
            <p><strong>Rate:</strong> ${{ number_format($profile['rate_per_hour'], 2) }}/hr</p>
            <p><strong>Portfolio:</strong> <a href="{{ $profile['portfolio_url'] }}">{{ $profile['portfolio_url'] }}</a></p>
            <h3>Skills</h3>
            <ul>
                @foreach($skills as $skill)
                    <li>{{ $skill['name'] }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
