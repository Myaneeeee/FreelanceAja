@extends('layouts.app')

@section('title', 'Freelancer Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark">{{ __('freelancer.welcome_back', ['name' => Auth::user()->name]) }}</h2>
        <p class="text-muted mb-0">Here's what's happening with your projects today.</p>
    </div>
    <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-primary btn-lg shadow-sm">
        <i class="bi bi-search me-1"></i> {{ __('freelancer.find_work') }}
    </a>
</div>

@if(!$profile->bio || $profile->rate_per_hour == 0)
<div class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
    <div class="bg-warning bg-opacity-25 rounded-circle p-2 me-3">
        <i class="bi bi-exclamation-circle-fill text-warning-emphasis fs-5"></i>
    </div>
    <div>
        <strong>Complete your profile!</strong> 
        Clients are more likely to hire freelancers with a bio and set hourly rate.
        <a href="{{ route('freelancer.profile.edit') }}" class="alert-link">Edit Profile</a>
    </div>
</div>
@endif

<div class="row g-4 mb-5">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100 hover-shadow transition-all position-relative overflow-hidden">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted text-uppercase fw-semibold small mb-2">{{ __('freelancer.active_contracts') }}</h6>
                    <h2 class="display-6 fw-bold text-success mb-0">{{ $activeContracts->count() }}</h2>
                    <div class="mt-2 text-muted small">
                         Projects currently in progress
                    </div>
                </div>
                <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="text-success bi bi-briefcase" viewBox="0 0 16 16">
                        <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5zM1 4.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5H1.5a.5.5 0 0 1-.5-.5v-8z"/>
                    </svg>
                </div>
            </div>
            <a href="{{ route('freelancer.contracts.index') }}" class="stretched-link"></a>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100 hover-shadow transition-all position-relative overflow-hidden">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted text-uppercase fw-semibold small mb-2">{{ __('common.pending_proposals') }}</h6>
                    <h2 class="display-6 fw-bold text-secondary mb-0">{{ $proposalsCount }}</h2>
                    <div class="mt-2 text-muted small">
                        Awaiting client review
                    </div>
                </div>
                <div class="bg-secondary bg-opacity-10 p-3 rounded-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="text-secondary bi bi-send" viewBox="0 0 16 16">
                        <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                    </svg>
                </div>
            </div>
            <a href="{{ route('freelancer.proposals.index') }}" class="stretched-link"></a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom pt-4 px-4 pb-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Active Contracts</h5>
                @if($activeContracts->count() > 0)
                    <a href="{{ route('freelancer.contracts.index') }}" class="text-decoration-none small fw-bold">View All</a>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                @forelse($activeContracts as $contract)
                    <div class="list-group-item px-4 py-3 position-relative hover-bg-light">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="mb-0 fw-bold text-dark">
                                {{ $contract->job->title }}
                            </h6>
                            <span class="badge bg-success-subtle text-success rounded-pill px-3">Active</span>
                        </div>
                        <p class="text-muted small mb-2">Client: {{ $contract->job->clientProfile->user->name }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold small text-dark">Rp. {{ number_format($contract->final_price) }}</span>
                            <small class="text-muted">Started {{ \Carbon\Carbon::parse($contract->start_date)->format('M d') }}</small>
                        </div>
                        {{-- Make row clickable --}}
                        <a href="{{ route('freelancer.jobs.show', $contract->job_id) }}" class="stretched-link"></a>
                    </div>
                @empty
                    <div class="text-center py-5 px-4">
                        <div class="mb-3 text-muted opacity-25">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-clipboard-x" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708z"/>
                                <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                                <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                            </svg>
                        </div>
                        <p class="text-muted mb-3">{{ __('freelancer.no_active_contracts') }}</p>
                        <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-outline-primary btn-sm">Find Work</a>
                    </div>
                @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom pt-4 px-4 pb-3">
                <h5 class="fw-bold mb-0">Recommended for You</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                @forelse($recommendedJobs as $job)
                    <div class="list-group-item px-4 py-3 position-relative hover-bg-light">
                        <a href="{{ route('freelancer.jobs.show', $job->id) }}" class="stretched-link text-decoration-none">
                            <h6 class="fw-bold text-primary mb-1">{{ Str::limit($job->title, 40) }}</h6>
                        </a>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">{{ $job->type == 'hourly' ? 'Hourly' : 'Fixed Price' }}</small>
                            <span class="fw-bold text-dark small">Rp. {{ number_format($job->budget) }}</span>
                        </div>
                        <div class="d-flex gap-1 flex-wrap">
                            @foreach($job->skills->take(3) as $skill)
                                <span class="badge bg-light text-secondary border fw-normal" style="font-size: 0.75rem;">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 px-4">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="text-muted opacity-25 bi bi-stars" viewBox="0 0 16 16">
                                <path d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828l.645-1.937zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.734 1.734 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.734 1.734 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.734 1.734 0 0 0 3.407 2.31l.387-1.162zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L10.863.1z"/>
                            </svg>
                        </div>
                        <p class="text-muted small mb-3">Add skills to get job recommendations.</p>
                        <a href="{{ route('freelancer.skills.edit') }}" class="btn btn-sm btn-outline-primary">Add Skills</a>
                    </div>
                @endforelse
                </div>
            </div>
             <div class="card-footer bg-white border-top-0 text-center py-3">
                <a href="{{ route('freelancer.jobs.index') }}" class="text-decoration-none fw-bold small">View All Jobs</a>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    .hover-bg-light:hover { 
        background-color: #f8f9fa; 
    }
</style>
@endsection