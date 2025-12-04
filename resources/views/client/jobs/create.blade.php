@extends('layouts.app')

@section('title', __('client.post_job'))

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h4 class="fw-bold mb-0">{{ __('client.post_new_job') }}</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('client.jobs.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('client.job_title') }}</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="{{ __('client.job_title_placeholder') }}" required>
                        @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('client.description') }}</label>
                        <textarea name="description" rows="6" class="form-control" placeholder="{{ __('client.description_placeholder') }}" required>{{ old('description') }}</textarea>
                        <div class="form-text">{{ __('client.be_detailed') }}</div>
                        @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('client.budget_label') }}</label>
                            <input type="number" name="budget" class="form-control" value="{{ old('budget') }}" step="0.01" required>
                            @error('budget') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('client.payment_type') }}</label>
                            <select name="type" class="form-select">
                                <option value="fixed_price">{{ __('client.fixed_price') }}</option>
                                <option value="hourly">{{ __('client.hourly') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('client.required_skills') }}</label>
                        <div class="card bg-light border-0 p-3">
                            <div class="row row-cols-2 row-cols-md-3 g-2" style="max-height: 200px; overflow-y: auto;">
                                @foreach($skills as $skill)
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="skills[]" value="{{ $skill->id }}" id="skill_{{ $skill->id }}">
                                            <label class="form-check-label" for="skill_{{ $skill->id }}">{{ $skill->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @error('skills') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('client.application_deadline') }}</label>
                        <input type="date" name="deadline" class="form-control w-auto" value="{{ old('deadline') }}" required>
                        @error('deadline') <span class="text-danger small">{{ $message }}</span> @enderror
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
@endsection