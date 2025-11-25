@extends('layouts.app')

@section('title', 'Browse Jobs')

@section('content')
<div class="row">
    <!-- Filters Sidebar -->
    <div class="col-lg-3 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Filter Jobs</h5>
                <form action="{{ route('freelancer.jobs.index') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Search</label>
                        <input type="text" name="q" class="form-control" value="{{ request('q') }}" placeholder="Keywords...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Job Type</label>
                        <select name="type" class="form-select">
                            <option value="">All Types</option>
                            <option value="fixed_price" {{ request('type') == 'fixed_price' ? 'selected' : '' }}>Fixed Price</option>
                            <option value="hourly" {{ request('type') == 'hourly' ? 'selected' : '' }}>Hourly</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Category (Skill)</label>
                        <select name="skill_id" class="form-select">
                            <option value="">All Skills</option>
                            @foreach($skills as $skill)
                                <option value="{{ $skill->id }}" {{ request('skill_id') == $skill->id ? 'selected' : '' }}>
                                    {{ $skill->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Min Budget ($)</label>
                        <input type="number" name="budget_min" class="form-control" value="{{ request('budget_min') }}">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-link text-decoration-none btn-sm mt-1">Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Job List -->
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">Available Jobs</h4>
            <span class="text-muted small">{{ $jobs->total() }} results found</span>
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
                            Posted {{ $job->created_at->diffForHumans() }} by {{ $job->clientProfile->company_name ?? $job->clientProfile->user->name }}
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
            No jobs found matching your criteria. Try adjusting your filters.
        </div>
        @endforelse

        <div class="mt-4">
            {{ $jobs->links() }}
        </div>
    </div>
</div>
@endsection