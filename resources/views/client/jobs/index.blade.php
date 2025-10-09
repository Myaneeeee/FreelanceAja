@extends('layouts.app')

{{-- TODO : GANTI PAGE TITLE --}}
@section('title', 'Jobs')

@section('content')
<h2 class="mb-3">My Jobs</h2>
<div class="row g-3">
  @forelse ($jobs as $job)
    <div class="col-md-6">
      <div class="card h-100 shadow-sm">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">{{ $job['title'] }}</h5>
          <p class="card-text text-muted flex-grow-1">{{ $job['description'] }}</p>
          <div class="mb-2">
            <span class="badge text-bg-light border me-2 text-capitalize">{{ str_replace('_',' ',$job['status']) }}</span>
            <span class="badge text-bg-success">${{ number_format($job['budget'], 2) }}</span>
          </div>
          <div>
            <a href="{{ route('client.jobs.proposals', $job['id']) }}" class="btn btn-outline-primary btn-sm">Review Proposals</a>
          </div>
        </div>
      </div>
    </div>
  @empty
    <div class="col-12">
      <div class="alert alert-info mb-0">You have not posted any jobs yet.</div>
    </div>
  @endforelse
</div>
@endsection
