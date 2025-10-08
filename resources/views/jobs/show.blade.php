@extends('layouts.app')

@section('title', $job['title'])

@section('content')
    <h1>{{ $job['title'] }}</h1>
    <p><strong>Description:</strong> {{ $job['description'] }}</p>
    <p><strong>Budget:</strong> ${{ number_format($job['budget'], 2) }}</p>
    <p><strong>Type:</strong> {{ $job['type'] }}</p>
    <p><strong>Status:</strong> {{ $job['status'] }}</p>
    <p><strong>Deadline:</strong> {{ $job['deadline'] }}</p>

    <h2>Proposals</h2>
    <ul class="list-group">
        @foreach($proposals as $proposal)
            <li class="list-group-item">
                <strong>Bid:</strong> ${{ number_format($proposal['bid_amount'], 2) }}<br>
                <strong>Cover Letter:</strong> {{ Str::limit($proposal['cover_letter'], 150) }}<br>
                <strong>Status:</strong> {{ $proposal['status'] }}
            </li>
        @endforeach
    </ul>
@endsection
