@extends('layouts.app')

{{-- TODO : GANTI PAGE TITLE --}}
@section('title', 'Create Jobs')

@section('content')
<h2 class="mb-3">Post a Job</h2>
<form method="post" action="{{ route('client.jobs.store') }}">
  @csrf
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Title</label>
      <input type="text" class="form-control" name="title" placeholder="e.g. Build a Company Website">
    </div>
    <div class="col-md-3">
      <label class="form-label">Type</label>
      <select class="form-select" name="type">
        <option value="fixed_price">Fixed price</option>
        <option value="hourly">Hourly</option>
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">Budget</label>
      <input type="number" step="0.01" class="form-control" name="budget" placeholder="e.g. 2000">
    </div>
    <div class="col-12">
      <label class="form-label">Description</label>
      <textarea class="form-control" name="description" rows="5" placeholder="What needs to be done?"></textarea>
    </div>
    <div class="col-md-4">
      <label class="form-label">Deadline</label>
      <input type="date" class="form-control" name="deadline">
    </div>
    <div class="col-12">
      <label class="form-label">Skills</label>
      <div class="row g-2">
        @foreach ($skills as $s)
          <div class="col-6 col-md-4 col-lg-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="skills[]" id="skill-{{ $s['id'] }}" value="{{ $s['id'] }}">
              <label class="form-check-label" for="skill-{{ $s['id'] }}">{{ $s['name'] }}</label>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary" type="submit">Create Job</button>
    <span class="form-text ms-2">// TODO: Save to DB</span>
  </div>
</form>
@endsection
