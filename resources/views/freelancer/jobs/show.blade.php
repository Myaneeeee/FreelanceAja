@extends('layouts.app')

{{-- TODO : GANTI PAGE TITLE --}}
@section('title', 'All Jobs')

@section('content')
<div class="row g-4">
  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="card-title">{{ $job['title'] }}</h3>
        <div class="d-flex gap-2 mb-3">
          <span class="badge text-bg-light border">{{ ucfirst(str_replace('_', ' ', $job['type'])) }}</span>
          <span class="badge text-bg-success">${{ number_format($job['budget'], 2) }}</span>
          <span class="badge text-bg-secondary">{{ $job['deadline'] }}</span>
        </div>
        <p class="text-muted">{{ $job['description'] }}</p>
        <div class="mt-3">
          <strong>Skills:</strong>
          @foreach ($skills as $s)
            @if (in_array($s['id'], $job['skills']))
              <span class="badge text-bg-light border me-1">{{ $s['name'] }}</span>
            @endif
          @endforeach
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Submit a Proposal</h5>
        <form method="post" action="{{ route('freelancer.jobs.proposals.submit', $job['id']) }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Cover Letter</label>
            <textarea name="cover_letter" class="form-control" rows="4" placeholder="Why are you a great fit?"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Bid Amount {{ $job['type']==='hourly' ? '(per hour)' : '(total)' }}</label>
            <input type="number" step="0.01" name="bid_amount" class="form-control" placeholder="e.g. {{ $job['budget'] }}">
          </div>
          <button class="btn btn-primary w-100" type="submit">Send Proposal</button>
          <div class="form-text mt-2">// TODO: Persist to DB</div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
