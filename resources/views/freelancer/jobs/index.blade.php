@extends('layouts.app')

{{-- TODO : GANTI PAGE TITLE --}}
@section('title', 'Jobs')

@section('content')
<h2 class="mb-3">Browse Jobs</h2>

<form class="row gy-2 gx-2 align-items-end mb-3" method="get" action="{{ route('freelancer.jobs.index') }}">
  <div class="col-12 col-md-4">
    <label class="form-label">Search</label>
    <input type="text" class="form-control" name="q" value="{{ $q }}" placeholder="Title or description">
  </div>
  <div class="col-6 col-md-2">
    <label class="form-label">Type</label>
    <select class="form-select" name="type">
      <option value="">Any</option>
      <option value="fixed_price" @selected($type==='fixed_price')>Fixed price</option>
      <option value="hourly" @selected($type==='hourly')>Hourly</option>
    </select>
  </div>
  <div class="col-6 col-md-3">
    <label class="form-label">Skill</label>
    <select class="form-select" name="skill_id">
      <option value="">Any</option>
      @foreach ($skills as $s)
        <option value="{{ $s['id'] }}" @selected($skillId===$s['id'])>{{ $s['name'] }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-6 col-md-1">
    <label class="form-label">Min</label>
    <input type="number" step="0.01" class="form-control" name="budget_min" value="{{ $budgetMin }}">
  </div>
  <div class="col-6 col-md-1">
    <label class="form-label">Max</label>
    <input type="number" step="0.01" class="form-control" name="budget_max" value="{{ $budgetMax }}">
  </div>
  <div class="col-12 col-md-1 d-grid">
    <button type="submit" class="btn btn-primary">Filter</button>
  </div>
</form>

<div class="row g-3">
  @forelse ($jobs as $job)
    <div class="col-md-6 col-lg-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">{{ $job['title'] }}</h5>
          <p class="card-text text-muted flex-grow-1">{{ $job['description'] }}</p>
          <div class="mb-2">
            <span class="badge text-bg-light border me-2">{{ ucfirst(str_replace('_', ' ', $job['type'])) }}</span>
            <span class="badge text-bg-success">${{ number_format($job['budget'], 2) }}</span>
          </div>
          <div class="d-grid gap-2 d-md-block">
            <a href="{{ route('freelancer.jobs.show', $job['id']) }}" class="btn btn-outline-primary btn-sm">View</a>
            <form class="d-inline" method="post" action="{{ route('freelancer.jobs.proposals.submit', $job['id']) }}">
              @csrf
              <input type="hidden" name="cover_letter" value="Quick apply - // TODO: replace">
              <input type="hidden" name="bid_amount" value="{{ $job['type']==='hourly' ? $job['budget'] : max(500, (int)$job['budget'] - 100) }}">
              <button class="btn btn-primary btn-sm" type="submit">Quick Apply</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  @empty
    <div class="col-12">
      <div class="alert alert-info">No jobs match your filters.</div>
    </div>
  @endforelse
</div>
@endsection
