@extends('layouts.app')

@section('title', 'Landing Page')

@section('sidebar')
    @@parent
@endsection

@section('content')
    <h1>FreelanceAja</h1>
    <p>Browse latest jobs:</p>
    <div class="row">
        @foreach($jobs as $job)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $job['title'] }}</h5>
                        <p class="card-text">{{ Str::limit($job['description'], 100) }}</p>
                        <a href="/jobs/{{ $job['id'] }}" class="btn btn-primary">View Job</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
