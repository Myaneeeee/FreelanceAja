@extends('layouts.app')

{{-- TODO : GANTI PAGE TITLE --}}
@section('title', 'Home')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="mb-0">Freelancer Home</h2>
  <a href="{{ route('freelancer.profile.edit') }}" class="btn btn-outline-secondary btn-sm">Edit Profile</a>
</div>

<div class="row g-3 mb-4">
  <div class="col-sm-6 col-lg-3">
    <div class="card shadow-sm h-100">
      <div class="card-body">
        <div class="text-muted small">Hourly Rate</div>
        <div class="h4 mb-0">${{ number_format($profile['rate_per_hour'], 2) }}</div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card shadow-sm h-100">
      <div class="card-body">
        <div class="text-muted small">Active Contracts</div>
        <div class="h4 mb-0">{{ count($activeContracts) }}</div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card shadow-sm h-100">
      <div class="card-body">
        <div class="text-muted small">Past Contracts</div>
        <div class="h4 mb-0">{{ count($pastContracts) }}</div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card shadow-sm h-100">
      <div class="card-body">
        <div class="text-muted small">Open Jobs</div>
        <div class="h4 mb-0">{{ count($jobs) }}</div>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header d-flex align-items-center justify-content-between">
    <strong>Suggested Jobs</strong>
    <a class="btn btn-sm btn-primary" href="{{ route('freelancer.jobs.index') }}">Browse All</a>
  </div>
  <div class="list-group list-group-flush">
    @forelse (array_slice($jobs, 0, 5) as $j)
      <a href="{{ route('freelancer.jobs.show', $j['id']) }}" class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
          <h6 class="mb-1">{{ $j['title'] }}</h6>
          <small class="text-muted">{{ ucfirst(str_replace('_', ' ', $j['type'])) }}</small>
        </div>
        <p class="mb-1 text-muted">{{ $j['description'] }}</p>
        <small class="text-success fw-semibold">${{ number_format($j['budget'], 2) }}</small>
      </a>
    @empty
      <div class="list-group-item text-muted">No jobs available.</div>
    @endforelse
  </div>
</div>
@endsection
