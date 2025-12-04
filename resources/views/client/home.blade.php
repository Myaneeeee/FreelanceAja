@extends('layouts.app')

@section('title', __('client.dashboard'))

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h2 class="fw-bold text-primary">{{ __('client.dashboard') }}</h2>
        <p class="text-muted">{{ __('client.manage_jobs_contracts') }}</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('client.jobs.create') }}" class="btn btn-primary">
            + {{ __('client.post_new_job') }}
        </a>
    </div>
</div>

<!-- Stats -->
<div class="row g-3 mb-5">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small">{{ __('client.open_jobs') }}</h6>
                <h3 class="fw-bold text-primary">{{ $openJobsCount }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small">{{ __('client.active_contracts') }}</h6>
                <h3 class="fw-bold text-success">{{ $activeContracts->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small">{{ __('client.total_spent') }}</h6>
                <h3 class="fw-bold text-secondary">${{ number_format($totalSpent, 2) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Active Contracts -->
    <div class="col-lg-7 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">{{ __('client.active_contracts') }}</h5>
            </div>
            <div class="card-body p-0">
                @forelse($activeContracts as $contract)
                    <div class="list-group-item px-4 py-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $contract->job->title }}</h6>
                                <p class="text-muted small mb-0">{{ __('client.freelancer') }}: {{ $contract->freelancerProfile->user->name }}</p>
                            </div>
                            <span class="badge bg-success">{{ __('freelancer.active_contracts') }}</span>
                        </div>
                        <div class="mt-2 text-end">
                            <span class="fw-bold small me-2">${{ number_format($contract->final_price) }}</span>
                            <!-- Placeholder for 'End Contract' logic later -->
                            <button class="btn btn-sm btn-outline-secondary" disabled>{{ __('client.manage') }}</button>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">
                        <p>{{ __('client.no_active_contracts') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Proposals -->
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">{{ __('client.recent_proposals') }}</h5>
            </div>
            <div class="card-body">
                @forelse($recentProposals as $proposal)
                    <div class="mb-3 pb-3 border-bottom last-no-border">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h6 class="fw-bold mb-0 text-truncate" style="max-width: 200px;">{{ $proposal->job->title }}</h6>
                            <small class="text-muted">{{ $proposal->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="small text-muted mb-2">{{ __('client.from') }}: {{ $proposal->freelancerProfile->user->name }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-primary">${{ number_format($proposal->bid_amount) }}</span>
                            <a href="{{ route('client.jobs.proposals', $proposal->job_id) }}" class="btn btn-sm btn-outline-primary">{{ __('client.manage') }}</a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-3">
                        <p class="text-muted small">{{ __('client.no_proposals') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection