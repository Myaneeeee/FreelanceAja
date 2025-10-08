@extends('layouts.app')

@section('title', 'Jobs')

@section('content')
    <h1>All Jobs</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Budget</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
                <tr>
                    <td>{{ $job['title'] }}</td>
                    <td>{{ $job['type'] }}</td>
                    <td>${{ number_format($job['budget'], 2) }}</td>
                    <td>{{ $job['status'] }}</td>
                    <td><a href="/jobs/{{ $job['id'] }}" class="btn btn-sm btn-info">View</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
