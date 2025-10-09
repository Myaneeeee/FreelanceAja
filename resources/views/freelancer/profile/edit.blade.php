@extends('layouts.app')

{{-- TODO : GANTI PAGE TITLE --}}
@section('title', 'Edit Profile')

@section('content')
<h2 class="mb-3">Edit Profile</h2>
<form method="post" action="{{ route('freelancer.profile.update') }}">
  @csrf
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Headline</label>
      <input type="text" class="form-control" name="headline" value="{{ $profile['headline'] }}">
    </div>
    <div class="col-md-6">
      <label class="form-label">Rate per hour</label>
      <input type="number" step="0.01" class="form-control" name="rate_per_hour" value="{{ $profile['rate_per_hour'] }}">
    </div>
    <div class="col-12">
      <label class="form-label">Bio</label>
      <textarea class="form-control" name="bio" rows="4">{{ $profile['bio'] }}</textarea>
    </div>
    <div class="col-12">
      <label class="form-label">Portfolio URL</label>
      <input type="url" class="form-control" name="portfolio_url" value="{{ $profile['portfolio_url'] }}">
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary" type="submit">Save</button>
    <span class="form-text ms-2">// TODO: Save to DB</span>
  </div>
</form>
@endsection
