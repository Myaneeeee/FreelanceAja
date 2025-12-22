@extends('layouts.app')

@section('title', __('freelancer.manage_skills'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h4 class="fw-bold mb-0">{{ __('freelancer.manage_skills') }}</h4>
                    <p class="text-muted small mb-0">{{ __('freelancer.select_skills') }}</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('freelancer.skills.update') }}" method="POST">
                        @csrf

                        <div class="mb-4 position-relative">
                            <label
                                class="form-label fw-bold small text-uppercase text-secondary">{{ __('freelancer.search_skills_label') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" id="skillSearch" class="form-control border-start-0 bg-light"
                                    placeholder="{{ __('freelancer.search_skills_placeholder') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex flex-wrap gap-2" id="skillsContainer"
                                style="max-height: 300px; overflow-y: auto;">
                                @foreach ($skills as $skill)
                                    <div class="skill-item" data-name="{{ strtolower($skill->name) }}">
                                        <input type="checkbox" class="btn-check" name="skills[]"
                                            id="skill_{{ $skill->id }}" value="{{ $skill->id }}" autocomplete="off"
                                            {{ in_array($skill->id, $mySkills) ? 'checked' : '' }}>

                                        <label
                                            class="btn btn-outline-primary rounded-pill btn-sm px-3 py-1 fw-semibold d-flex align-items-center"
                                            for="skill_{{ $skill->id }}">
                                            {{ $skill->name }}
                                            @if (in_array($skill->id, $mySkills))
                                                <i class="bi bi-check-lg ms-2"></i>
                                            @else
                                                <i class="bi bi-plus-lg ms-2 text-muted"></i>
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div id="noResults" class="text-center text-muted mt-3 d-none">
                                <small>{{ __('freelancer.no_matching_skill') }}</small>
                            </div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <div class="mb-4">
                            <label for="custom_skills" class="form-label fw-bold text-dark">
                                <i class="bi bi-stars text-warning me-1"></i> {{ __('freelancer.add_custom_skills') }}
                            </label>
                            <p class="text-muted small mb-2">
                                {{ __('freelancer.add_custom_skills_desc') }}
                            </p>

                            <input type="text" name="custom_skills" id="custom_skills" class="form-control"
                                placeholder="e.g. Underwater Basket Weaving, Fortran 77">
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('freelancer.home') }}"
                                class="btn btn-light me-md-2">{{ __('common.cancel') }}</a>
                            <button type="submit"
                                class="btn btn-primary px-4 shadow-sm">{{ __('freelancer.update_skills') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Simple JS for Filter --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('skillSearch');
            const items = document.querySelectorAll('.skill-item');
            const noResults = document.getElementById('noResults');

            searchInput.addEventListener('keyup', function(e) {
                const term = e.target.value.toLowerCase();
                let hasVisible = false;

                items.forEach(item => {
                    const name = item.getAttribute('data-name');
                    if (name.includes(term)) {
                        item.classList.remove('d-none');
                        hasVisible = true;
                    } else {
                        item.classList.add('d-none');
                    }
                });

                if (!hasVisible) {
                    noResults.classList.remove('d-none');
                } else {
                    noResults.classList.add('d-none');
                }
            });
        });
    </script>
@endsection
