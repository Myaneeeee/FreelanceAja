@extends('layouts.app')

{{-- TODO : GANTI PAGE TITLE --}}
@section('title', 'Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="mb-0">My Profile</h2>
  <a class="btn btn-outline-secondary btn-sm" href="{{ route('freelancer.profile.edit') }}">Edit</a>
</div>

<div class="card">
  <div class="card-body">
    <h5 class="card-title">{{ $profile['headline'] }}</h5>
    <p class="text-muted">{{ $profile['bio'] }}</p>
    <div class="mb-2"><strong>Rate:</strong> ${{ number_format($profile['rate_per_hour'],2) }}/hr</div>
    <div><strong>Portfolio:</strong> <a href="{{ $profile['portfolio_url'] }}" target="_blank" rel="noopener">Open</a></div>
  </div>
</div>
@endsection
