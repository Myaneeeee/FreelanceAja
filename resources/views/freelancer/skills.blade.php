@extends('layouts.app')

{{-- TODO : GANTI PAGE TITLE --}}
@section('title', 'Skills')

@section('content')
<h2 class="mb-3">Edit Skills</h2>
<form method="post" action="{{ route('freelancer.skills.update') }}">
  @csrf
  <div class="row g-3">
    @foreach ($skills as $s)
      @php $checked = in_array($s['id'], $profile['skills']); @endphp
      <div class="col-6 col-md-4 col-lg-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="skills[]" id="skill-{{ $s['id'] }}" value="{{ $s['id'] }}" @checked($checked)>
          <label class="form-check-label" for="skill-{{ $s['id'] }}">{{ $s['name'] }}</label>
        </div>
      </div>
    @endforeach
  </div>
  <div class="mt-3">
    <button type="submit" class="btn btn-primary">Save</button>
    <span class="form-text ms-2">// TODO: Save to DB</span>
  </div>
</form>
@endsection
