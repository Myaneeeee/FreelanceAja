@extends('layouts.app')

@section('title', 'Freelancer Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold text-primary">Welcome back, {{ Auth::user()->name }}!</h2>
        <p class="text-muted">Here is what's happening with your projects today.</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-primary">
            Find Work
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-5">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small">Total Earnings</h6>
                <h3 class="fw-bold text-success">${{ number_format($totalEarnings, 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small">Active Contracts</h6>
                <h3 class="fw-bold text-primary">{{ $activeContracts->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small">Pending Proposals</h6>
                <h3 class="fw-bold text-secondary">{{ $proposalsCount }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Active Contracts Section -->
    <div class="col-lg-7 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">Active Contracts</h5>
            </div>
            <div class="card-body p-0">
                @if($activeContracts->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($activeContracts as $contract)
                        <div class="list-group-item px-4 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-bold">{{ $contract->job->title }}</h6>
                                    <small class="text-muted">Client: {{ $contract->job->clientProfile->user->name }}</small>
                                </div>
                                <span class="badge bg-success-subtle text-success">Active</span>
                            </div>
                            <div class="mt-2 text-end">
                                <a href="{{ route('freelancer.contracts.index') }}" class="btn btn-sm btn-outline-secondary">View Details</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 text-center text-muted">
                        <p>No active contracts yet.</p>
                        <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-outline-primary btn-sm">Start Applying</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recommended Jobs Section -->
    <div class="col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">Jobs For You</h5>
            </div>
            <div class="card-body">
                @forelse($recommendedJobs as $job)
                    <div class="mb-3 pb-3 border-bottom last-no-border">
                        <a href="{{ route('freelancer.jobs.show', $job->id) }}" class="text-decoration-none text-dark">
                            <h6 class="fw-bold mb-1">{{ $job->title }}</h6>
                        </a>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-light text-dark border">{{ ucfirst($job->type) }}</span>
                            <small class="fw-bold text-primary">${{ number_format($job->budget) }}</small>
                        </div>
                        <p class="small text-muted mb-0 text-truncate">{{ Str::limit($job->description, 60) }}</p>
                    </div>
                @empty
                    <div class="text-center py-3">
                        <p class="text-muted small">Update your skills to see recommendations.</p>
                        <a href="{{ route('freelancer.skills.edit') }}" class="btn btn-sm btn-outline-secondary">Edit Skills</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection