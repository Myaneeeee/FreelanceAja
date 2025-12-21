@extends('layouts.app')

@section('title', 'Edit Skills')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h4 class="fw-bold mb-0">{{ __('freelancer.manage_skills') }}</h4>
                <p class="text-muted small mb-0">Select skills that best describe your expertise.</p>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('freelancer.skills.update') }}" method="POST">
                    @csrf
                    
                    <h6 class="fw-bold mb-3 text-secondary text-uppercase small">Select Popular Skills</h6>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        @foreach($skills as $skill)
                            <input type="checkbox" class="btn-check" 
                                   name="skills[]" 
                                   id="skill_{{ $skill->id }}" 
                                   value="{{ $skill->id }}" 
                                   autocomplete="off"
                                   {{ in_array($skill->id, $mySkills) ? 'checked' : '' }}>
                            
                            <label class="btn btn-outline-primary rounded-pill btn-sm px-3 py-2 fw-semibold" for="skill_{{ $skill->id }}">
                                {{ $skill->name }}
                                @if(in_array($skill->id, $mySkills))
                                    <i class="bi bi-check-lg ms-1"></i>
                                @else
                                    <i class="bi bi-plus-lg ms-1"></i>
                                @endif
                            </label>
                        @endforeach
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <div class="mb-4">
                        <label for="custom_skills" class="form-label fw-bold">
                            <i class="bi bi-stars text-warning me-1"></i> Add Custom Skills
                        </label>
                        <p class="text-muted small mb-2">Can't find your skill above? Add your own, separated by commas.</p>
                        
                        <input type="text" 
                               name="custom_skills" 
                               id="custom_skills" 
                               class="form-control form-control-lg" 
                               placeholder="e.g. Underwater Basket Weaving, Advanced Excel, Fortran">
                        <div class="form-text">We will create these skills and add them to your profile instantly.</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('freelancer.home') }}" class="btn btn-light me-md-2">{{ __('common.cancel') }}</a>
                        <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">{{ __('freelancer.update_skills') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection