@extends('layouts.app')

{{-- TODO : GANTI PAGE TITLE --}}
@section('title', 'Contracts')

@section('content')
<h2 class="mb-3">Contracts</h2>

<h5 class="mb-2">Active</h5>
<div class="list-group mb-4">
  @forelse ($active as $c)
    <div class="list-group-item d-flex justify-content-between align-items-center">
      <div>
        <div class="fw-semibold">Contract #{{ $c['id'] }}</div>
        <div class="text-muted small">Job #{{ $c['job_id'] }} • Started {{ $c['start_date'] }}</div>
      </div>
      <span class="badge text-bg-success">Active</span>
    </div>
  @empty
    <div class="list-group-item text-muted">No active contracts.</div>
  @endforelse
</div>

<h5 class="mb-2">History</h5>
<div class="list-group">
  @forelse ($history as $c)
    <div class="list-group-item d-flex justify-content-between align-items-center">
      <div>
        <div class="fw-semibold">Contract #{{ $c['id'] }}</div>
        <div class="text-muted small">Ended {{ $c['end_date'] ?? '—' }}</div>
      </div>
      <span class="badge text-bg-secondary text-capitalize">{{ $c['status'] }}</span>
    </div>
  @empty
    <div class="list-group-item text-muted">No past contracts.</div>
  @endforelse
</div>
@endsection
