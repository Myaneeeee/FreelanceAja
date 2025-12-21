@extends('layouts.app')

@section('title', __('freelancer.browse_jobs'))

@section('content')
<div class="container-fluid px-0">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="sticky-top" style="top: 20px; z-index: 900;">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-sliders me-2"></i>Filter Jobs</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('freelancer.jobs.index') }}" method="GET">
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted">Keywords</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                                    <input type="text" name="q" class="form-control border-start-0 ps-0" value="{{ request('q') }}" placeholder="Title or description">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted">Job Type</label>
                                <div class="d-flex flex-column gap-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="type_all" value="" {{ request('type') == '' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_all">Any Type</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="type_fixed" value="fixed_price" {{ request('type') == 'fixed_price' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_fixed">Fixed Price</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="type_hourly" value="hourly" {{ request('type') == 'hourly' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_hourly">Hourly</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted">Skills</label>
                                <select name="skill_id" class="form-select form-select-sm">
                                    <option value="">All Skills</option>
                                    @foreach($skills as $skill)
                                        <option value="{{ $skill->id }}" {{ request('skill_id') == $skill->id ? 'selected' : '' }}>
                                            {{ $skill->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase text-muted">Min Budget</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="budget_min" class="form-control" value="{{ request('budget_min') }}" placeholder="0">
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                                @if(request()->anyFilled(['q', 'type', 'skill_id', 'budget_min']))
                                    <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-outline-secondary btn-sm">Clear All</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">
                    {{ request('q') ? 'Search Results' : 'Latest Jobs' }}
                </h4>
                <span class="badge bg-light text-dark border">{{ $jobs->total() }} Jobs Found</span>
            </div>

            @forelse($jobs as $job)
            <div class="card shadow-sm border-0 mb-3 hover-card position-relative overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="w-100">
                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted">
                                    Posted {{ $job->created_at->diffForHumans() }} 
                                </small>
                                <span class="fw-bold text-dark">
                                    Rp. {{ number_format($job->budget) }}
                                    <span class="text-muted fw-normal small">
                                        {{ $job->type == 'hourly' ? '/hr' : '(Fixed)' }}
                                    </span>
                                </span>
                            </div>

                            <h5 class="fw-bold text-primary mb-2">
                                <a href="{{ route('freelancer.jobs.show', $job->id) }}" class="text-decoration-none stretched-link">
                                    {{ $job->title }}
                                </a>
                            </h5>

                            <p class="text-muted mb-3" style="line-height: 1.6;">
                                {{ Str::limit($job->description, 200) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-3 border-top pt-3">
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach($job->skills->take(4) as $skill)
                                        <span class="badge bg-light text-secondary border fw-normal">{{ $skill->name }}</span>
                                    @endforeach
                                    @if($job->skills->count() > 4)
                                        <span class="badge bg-light text-muted border fw-normal">+{{ $job->skills->count() - 4 }}</span>
                                    @endif
                                </div>
                                <div class="text-end d-none d-md-block">
                                    <small class="text-muted">
                                        <i class="bi bi-building me-1"></i> {{ $job->clientProfile->company_name ?? $job->clientProfile->user->name }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <div class="mb-3 text-muted opacity-50">
                    <i class="bi bi-search" style="font-size: 3rem;"></i>
                </div>
                <h5>No jobs found matching your criteria.</h5>
                <p class="text-muted">Try removing some filters or searching for different keywords.</p>
                <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-outline-primary">View All Jobs</a>
            </div>
            @endforelse

            <div class="mt-4 d-flex justify-content-center">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card { transition: transform 0.2s, box-shadow 0.2s; }
    .hover-card:hover { transform: translateY(-2px); box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important; }
</style>
@endsection