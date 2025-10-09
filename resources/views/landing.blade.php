@extends('layouts.app')

{{-- TODO : GANTI PAGE TITLE --}}
@section('title', 'Landing')

@section('sidebar')
    @@parent
@endsection

@section('content')
<div class="row align-items-center">
  <div class="col-lg-6">
    <h1 class="display-5 fw-bold text-balance">Hire faster. Work smarter.</h1>
    <p class="lead text-muted">A simple marketplace connecting great clients with talented freelancers.</p>
    <div class="d-flex gap-2 mt-3">
      <a href="{{ route('freelancer.home') }}" class="btn btn-primary btn-lg">I'm a Freelancer</a>
      <a href="{{ route('client.home') }}" class="btn btn-outline-primary btn-lg">I'm a Client</a>
    </div>

    <div class="mt-4">
      <span class="badge bg-primary-subtle text-primary me-2">Open Jobs: {{ $stats['jobs_open'] }}</span>
      <span class="badge bg-secondary-subtle text-secondary me-2">Freelancers: {{ $stats['freelancers'] }}</span>
      <span class="badge bg-success-subtle text-success">Clients: {{ $stats['clients'] }}</span>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Popular Skills</h5>
        <div class="d-flex flex-wrap gap-2">
          @foreach (\App\Support\DummyData::skills() as $s)
            <span class="badge text-bg-light border">{{ $s['name'] }}</span>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

