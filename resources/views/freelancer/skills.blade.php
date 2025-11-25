@extends('layouts.app')

@section('title', 'Edit Skills')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h4 class="fw-bold mb-0">Manage Skills</h4>
                <p class="text-muted small mb-0">Select the skills that best describe your expertise.</p>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('freelancer.skills.update') }}" method="POST">
                    @csrf
                    
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mb-4">
                        @foreach($skills as $skill)
                            <div class="col">
                                <div class="form-check position-relative p-3 border rounded bg-white shadow-sm h-100 d-flex align-items-center user-select-none hover-shadow transition">
                                    <input class="form-check-input shrink-0 me-3" type="checkbox" 
                                           name="skills[]" 
                                           value="{{ $skill->id }}" 
                                           id="skill_{{ $skill->id }}"
                                           style="width: 1.3em; height: 1.3em; cursor: pointer;"
                                           {{ in_array($skill->id, $mySkills) ? 'checked' : '' }}>
                                    
                                    <label class="form-check-label fw-bold stretched-link w-100" for="skill_{{ $skill->id }}" style="cursor: pointer;">
                                        {{ $skill->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Update Skills</button>
                        <a href="{{ route('freelancer.home') }}" class="btn btn-link text-decoration-none text-muted">Back to Dashboard</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        border-color: #0d6efd !important;
    }
    .transition {
        transition: all 0.2s ease-in-out;
    }
</style>
@endsection