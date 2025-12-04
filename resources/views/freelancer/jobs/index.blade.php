@extends('layouts.app')

@section('title', __('freelancer.browse_jobs'))

@section('content')
<div class="row">
    <!-- Filters Sidebar -->
    <div class="col-lg-3 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-bold mb-3">{{ __('freelancer.filter_jobs') }}</h5>
                <form action="{{ route('freelancer.jobs.index') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">{{ __('freelancer.search') }}</label>
                        <input type="text" name="q" class="form-control" value="{{ request('q') }}" placeholder="{{ __('freelancer.keywords') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">{{ __('freelancer.job_type') }}</label>
                        <select name="type" class="form-select">
                            <option value="">{{ __('client.post_job') }}</option>
                            <option value="fixed_price" {{ request('type') == 'fixed_price' ? 'selected' : '' }}>{{ __('client.fixed_price') }}</option>
                            <option value="hourly" {{ request('type') == 'hourly' ? 'selected' : '' }}>{{ __('client.hourly') }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">{{ __('freelancer.category_skill') }}</label>
                        <select name="skill_id" class="form-select">
                            <option value="">{{ __('freelancer.skills') }}</option>
                            @foreach($skills as $skill)
                                <option value="{{ $skill->id }}" {{ request('skill_id') == $skill->id ? 'selected' : '' }}>
                                    {{ $skill->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">{{ __('freelancer.min_budget') }}</label>
                        <input type="number" name="budget_min" class="form-control" value="{{ request('budget_min') }}">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">{{ __('freelancer.apply_filters') }}</button>
                        <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-link text-decoration-none btn-sm mt-1">{{ __('freelancer.reset') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Job List -->
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">{{ __('freelancer.available_jobs') }}</h4>
            <span class="text-muted small">{{ $jobs->total() }} {{ __('freelancer.results_found') }}</span>
        </div>

        @forelse($jobs as $job)
        <div class="card shadow-sm border-0 mb-3 hover-shadow transition">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="fw-bold text-primary mb-1">
                            <a href="{{ route('freelancer.jobs.show', $job->id) }}" class="text-decoration-none">{{ $job->title }}</a>
                        </h5>
                        <p class="text-muted small mb-2">
                            {{ __('freelancer.posted') }} {{ $job->created_at->diffForHumans() }} {{ __('common.home') }} {{ $job->clientProfile->company_name ?? $job->clientProfile->user->name }}
                        </p>
                    </div>
                    <div class="text-end">
                        <h5 class="fw-bold mb-0">${{ number_format($job->budget) }}</h5>
                        <small class="text-muted">{{ $job->type == 'hourly' ? '/ hr' : 'Fixed' }}</small>
                    </div>
                </div>

                <p class="mb-3 text-secondary">{{ Str::limit($job->description, 150) }}</p>

                <div class="d-flex flex-wrap gap-2">
                    @foreach($job->skills as $skill)
                        <span class="badge bg-light text-secondary border rounded-pill">{{ $skill->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        @empty
        <div class="alert alert-info text-center">
            {{ __('freelancer.no_jobs_found') }}
        </div>
        @endforelse

        <div class="mt-4">
            {{ $jobs->links() }}
        </div>
    </div>
</div>
@endsection