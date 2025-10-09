@extends('layouts.app')

{{-- TODO : GANTI PAGE TITLE --}}
@section('title', 'Proposals')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-2">
  <h2 class="mb-0">Proposals for: {{ $job['title'] }}</h2>
  <a href="{{ route('client.jobs.index') }}" class="btn btn-outline-secondary btn-sm">Back to Jobs</a>
</div>

<div class="list-group">
  @forelse ($proposals as $p)
    <div class="list-group-item">
      <div class="d-flex justify-content-between">
        <div>
          <div class="fw-semibold">Proposal #{{ $p['id'] }}</div>
          <div class="text-muted small mb-2">Submitted {{ $p['created_at'] }}</div>
          <div class="mb-2"><strong>Bid:</strong> ${{ number_format($p['bid_amount'],2) }}</div>
          <div class="text-pre-wrap">{{ $p['cover_letter'] }}</div>
        </div>
        <div class="text-end">
          <span class="badge text-bg-secondary text-capitalize d-block mb-2">{{ $p['status'] }}</span>
          <form method="post" action="{{ route('client.proposals.accept', $p['id']) }}" class="d-inline">
            @csrf
            <button class="btn btn-success btn-sm" type="submit">Accept</button>
          </form>
          <form method="post" action="{{ route('client.proposals.reject', $p['id']) }}" class="d-inline ms-1">
            @csrf
            <button class="btn btn-outline-danger btn-sm" type="submit">Reject</button>
          </form>
        </div>
      </div>
    </div>
  @empty
    <div class="list-group-item text-muted">No proposals yet.</div>
  @endforelse
</div>

<div class="alert alert-info mt-3 mb-0">
  // TODO: Accepting a proposal should update DB and optionally navigate to Create Contract.
</div>
@endsection
