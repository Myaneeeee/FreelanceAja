@extends('layouts.app')

@section('title', 'Welcome to FreelanceApp')

@section('sidebar')
@endsection

@section('content')
<div class="px-4 py-5 my-5 text-center">
    <h1 class="display-5 fw-bold text-body-emphasis">{{ __('common.hire_faster') }}</h1>
    <div class="col-lg-6 mx-auto">
        <p class="lead mb-4 text-muted">{{ __('common.landing_description') }}</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4 gap-3">{{ __('common.start_now') }}</a>
        </div>
    </div>
</div>

<div class="container py-5 border-top border-bottom">
    <div class="row text-center">
        <div class="col-md-4 mb-3 mb-md-0">
            <h2 class="fw-bold text-primary">{{ number_format($stats['jobs_open']) }}</h2>
            <p class="text-muted text-uppercase small ls-1">{{ __('common.active_jobs') }}</p>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <h2 class="fw-bold text-primary">{{ number_format($stats['freelancers']) }}</h2>
            <p class="text-muted text-uppercase small ls-1">{{ __('common.talented_freelancers') }}</p>
        </div>
        <div class="col-md-4">
            <h2 class="fw-bold text-primary">{{ number_format($stats['clients']) }}</h2>
            <p class="text-muted text-uppercase small ls-1">{{ __('common.happy_clients') }}</p>
        </div>
    </div>
</div>

<div class="container px-4 py-5">
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
        <div class="col">
            <div class="d-inline-flex align-items-center justify-content-center fs-2 mb-3">
                <i class="bi bi-lock"></i>
            </div>
            <h3 class="fs-2 text-body-emphasis">{{ __('common.secure_payments') }}</h3>
            <p>{{ __('common.secure_payments_desc') }}</p>
        </div>
        <div class="col">
            <div class="d-inline-flex align-items-center justify-content-center fs-2 mb-3">
                <i class="bi bi-lightning"></i>
            </div>
            <h3 class="fs-2 text-body-emphasis">{{ __('common.fast_matching') }}</h3>
            <p>{{ __('common.fast_matching_desc') }}</p>
        </div>
        <div class="col">
            <div class="d-inline-flex align-items-center justify-content-center fs-2 mb-3">
                <i class="bi bi-handshake"></i>
            </div>
            <h3 class="fs-2 text-body-emphasis">{{ __('common.verified_profiles') }}</h3>
            <p>{{ __('common.verified_profiles_desc') }}</p>
        </div>
    </div>
</div>

<div class="bg-light py-5">
    <div class="container text-center">
        <h3 class="mb-4">{{ __('common.trending_skills') }}</h3>
        <div class="d-flex flex-wrap justify-content-center gap-2">
            @forelse($skills as $skill)
                <a href="#" class="btn btn-white bg-white border rounded-pill shadow-sm px-4">
                    {{ $skill->name }}
                </a>
            @empty
                <p class="text-muted">{{ __('common.no_skills_added') }}</p>
            @endforelse
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>{{ __('common.latest_opportunities') }}</h3>
        <a href="#" class="text-decoration-none">{{ __('common.view_all_jobs') }} &rarr;</a>
    </div>

    <div class="row">
        @forelse($recentJobs as $job)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-primary-subtle text-primary rounded-pill">{{ ucfirst($job->type) }}</span>
                        <small class="text-muted">{{ $job->created_at->diffForHumans() }}</small>
                    </div>
                    <h5 class="card-title fw-bold">{{ $job->title }}</h5>
                    <p class="card-text text-muted text-truncate">{{ Str::limit($job->description, 80) }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="fw-bold">${{ number_format($job->budget, 2) }}</span>
                        <a href="#" class="btn btn-sm btn-outline-primary">{{ __('freelancer.submit') }}</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">{{ __('common.no_jobs_available') }}</p>
        </div>
        @endforelse
    </div>
</div>
@endsection