@extends('layouts.app')

{{-- TODO : GANTI PAGE TITLE --}}
@section('title', 'Home')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="mb-0">Client Home</h2>
  <a href="{{ route('client.jobs.create') }}" class="btn btn-primary btn-sm">Post a Job</a>
</div>

<div class="row g-3 mb-4">
  <div class="col-sm-6 col-lg-4">
    <div class="card h-100 shadow-sm">
      <div class="card-body">
        <div class="text-muted small">Company</div>
        <div class="h5 mb-1">{{ $client['company_name'] }}</div>
        <a href="{{ $client['website_url'] }}" target="_blank" rel="noopener" class="small">Website</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-4">
    <div class="card h-100 shadow-sm">
      <div class="card-body">
        <div class="text-muted small">Total Jobs</div>
        <div class="h4 mb-0">{{ count($myJobs) }}</div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-4">
    <div class="card h-100 shadow-sm">
      <div class="card-body">
        <div class="text-muted small">Open Jobs</div>
        <div class="h4 mb-0">{{ count($open) }}</div>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header d-flex align-items-center justify-content-between">
    <strong>My Jobs</strong>
    <a class="btn btn-sm btn-outline-secondary" href="{{ route('client.jobs.index') }}">View all</a>
  </div>
  <div class="list-group list-group-flush">
    @forelse (array_slice($myJobs, 0, 5) as $j)
      <a href="{{ route('client.jobs.proposals', $j['id']) }}" class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
          <h6 class="mb-1">{{ $j['title'] }}</h6>
          <small class="text-muted text-capitalize">{{ str_replace('_',' ',$j['status']) }}</small>
        </div>
        <small class="text-muted">{{ $j['created_at'] }}</small>
      </a>
    @empty
      <div class="list-group-item text-muted">No jobs posted yet.</div>
    @endforelse
  </div>
</div>
@endsection
