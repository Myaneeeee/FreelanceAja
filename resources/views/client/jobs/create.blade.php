@extends('layouts.app')

@section('title', __('client.post_job'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h4 class="fw-bold mb-0">{{ __('client.post_new_job') }}</h4>
                    <p class="text-muted small mb-0">{{ __('client.job_define_requirements') }}</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('client.jobs.store') }}" method="POST">
                        @csrf

                        {{-- Basic Info --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('client.job_title') }}</label>
                            {{-- Added value="{{ old('title') }}" --}}
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                                placeholder="{{ __('client.job_title_placeholder') }}" required>
                            @error('title')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('client.description') }}</label>
                            {{-- Added {{ old('description') }} inside textarea --}}
                            <textarea name="description" rows="6" class="form-control"
                                placeholder="{{ __('client.description_placeholder') }}" required>{{ old('description') }}</textarea>
                            <div class="form-text">{{ __('client.be_detailed') }}</div>
                            @error('description')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('client.budget_label') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">Rp.</span>
                                    {{-- Added value="{{ old('budget') }}" --}}
                                    <input type="number" name="budget" class="form-control" value="{{ old('budget') }}"
                                        step="0.01" required>
                                </div>
                                @error('budget')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('client.payment_type') }}</label>
                                <select name="type" class="form-select">
                                    {{-- Added selection retention logic --}}
                                    <option value="fixed_price" {{ old('type') == 'fixed_price' ? 'selected' : '' }}>
                                        {{ __('client.fixed_price') }}</option>
                                    <option value="hourly" {{ old('type') == 'hourly' ? 'selected' : '' }}>
                                        {{ __('client.hourly') }}</option>
                                </select>
                            </div>
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        {{-- SKILLS SECTION --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">{{ __('client.required_skills') }}</label>

                            {{-- Search Bar --}}
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" id="skillSearch" class="form-control border-start-0 bg-light"
                                    placeholder="{{ __('client.search_standard_skills_placeholder') }}">
                            </div>

                            {{-- Standard Skills List --}}
                            <div class="card bg-light border-0 p-3 mb-3">
                                <div class="row row-cols-2 row-cols-md-3 g-2" id="skillsContainer"
                                    style="max-height: 200px; overflow-y: auto;">
                                    @foreach ($skills as $skill)
                                        <div class="col skill-item" data-name="{{ strtolower($skill->name) }}">
                                            <div class="form-check">
                                                {{--
                                                LOGIC TO KEEP CHECKBOXES CHECKED:
                                                1. Check if old('skills') exists and is an array.
                                                2. Check if the current $skill->id is inside that array.
                                            --}}
                                                <input class="form-check-input" type="checkbox" name="skills[]"
                                                    value="{{ $skill->id }}" id="skill_{{ $skill->id }}"
                                                    {{ is_array(old('skills')) && in_array($skill->id, old('skills')) ? 'checked' : '' }}>

                                                <label class="form-check-label w-100"
                                                    for="skill_{{ $skill->id }}">{{ $skill->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div id="noResults" class="text-center text-muted mt-2 d-none">
                                    <small>{{ __('client.no_standard_skill_found') }}</small>
                                </div>
                            </div>

                            {{-- Custom Skills Input --}}
                            <div>
                                <label class="form-label fw-bold small text-secondary">
                                    <i class="bi bi-plus-circle me-1"></i> Add Custom Skills
                                </label>
                                {{-- Added value="{{ old('custom_skills') }}" --}}
                                <input type="text" name="custom_skills" class="form-control"
                                    value="{{ old('custom_skills') }}"
                                    placeholder="{{ __('client.custom_skills_placeholder') }}">
                                <div class="form-text">{{ __('client.skill_input_help') }}</div>
                            </div>
                            @error('skills')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <div class="mb-4">
                            <label class="form-label fw-bold">{{ __('client.application_deadline') }}</label>
                            {{-- Added value="{{ old('deadline') }}" --}}
                            <input type="date" name="deadline" class="form-control w-auto" value="{{ old('deadline') }}"
                                required>
                            @error('deadline')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('client.jobs.index') }}" class="btn btn-light">{{ __('client.cancel') }}</a>
                            <button type="submit" class="btn btn-primary px-4">{{ __('client.post_job_now') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Javascript for Search Filtering --}}
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

    <style>
        #skillsContainer::-webkit-scrollbar {
            width: 6px;
        }

        #skillsContainer::-webkit-scrollbar-track {
            background: #e9ecef;
        }

        #skillsContainer::-webkit-scrollbar-thumb {
            background: #ced4da;
            border-radius: 4px;
        }
    </style>
@endsection
