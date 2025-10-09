@extends('layouts.app')

{{-- TODO : GANTI PAGE TITLE --}}
@section('title', 'Create Contracts')

@section('content')
<h2 class="mb-3">Create Contract</h2>
<form method="post" action="{{ route('client.contracts.store') }}">
  @csrf
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Job</label>
      <select class="form-select" name="job_id">
        @foreach ($jobs as $j)
          <option value="{{ $j['id'] }}">#{{ $j['id'] }} — {{ $j['title'] }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-6">
      <label class="form-label">Proposal</label>
      <select class="form-select" name="proposal_id">
        @foreach ($proposals as $p)
          <option value="{{ $p['id'] }}">#{{ $p['id'] }} — ${{ number_format($p['bid_amount'],2) }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Final Price</label>
      <input type="number" step="0.01" name="final_price" class="form-control" placeholder="e.g. 2000">
    </div>
    <div class="col-md-4">
      <label class="form-label">Start Date</label>
      <input type="date" name="start_date" class="form-control">
    </div>
    <div class="col-md-4">
      <label class="form-label">End Date (optional)</label>
      <input type="date" name="end_date" class="form-control">
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary" type="submit">Create Contract</button>
    <span class="form-text ms-2">// TODO: Save to DB</span>
  </div>
</form>
@endsection
