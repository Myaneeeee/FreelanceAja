@extends('layouts.app')

@section('title', __('client.dashboard'))

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">{{ __('client.dashboard') }}</h2>
            <p class="text-muted mb-0">{{ __('client.manage_jobs_contracts') }}</p>
        </div>
        <a href="{{ route('client.jobs.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-plus-lg"></i> {{ __('client.post_new_job') }}
        </a>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition-all position-relative overflow-hidden">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted text-uppercase fw-semibold small mb-2">{{ __('client.open_jobs') }}</h6>
                        <h2 class="display-6 fw-bold text-primary mb-0">{{ $openJobsCount }}</h2>
                        <div class="mt-2 text-muted small">
                            @if ($openJobsCount > 0)
                                {{ __('common.candidates_applying') }}
                            @else
                                {{ __('common.no_jobs_currently_open') }}
                            @endif
                        </div>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                            class="text-primary bi bi-briefcase" viewBox="0 0 16 16">
                            <path
                                d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5zM1 4.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5H1.5a.5.5 0 0 1-.5-.5v-8z" />
                        </svg>
                    </div>
                </div>
                <a href="{{ route('client.jobs.index') }}" class="stretched-link"></a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-shadow transition-all position-relative overflow-hidden">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted text-uppercase fw-semibold small mb-2">{{ __('client.active_contracts') }}
                        </h6>
                        <h2 class="display-6 fw-bold text-success mb-0">{{ $activeContracts->count() }}</h2>
                        <div class="mt-2 text-muted small">
                            {{ __('common.projects_in_progress') }}
                        </div>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                            class="text-success bi bi-people" viewBox="0 0 16 16">
                            <path
                                d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0z" />
                        </svg>
                    </div>
                </div>
                <a href="{{ route('client.contracts.index') }}" class="stretched-link"></a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 h-100">
                <div
                    class="card-header bg-white border-bottom pt-4 px-4 pb-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">{{ __('client.active_contracts') }}</h5>
                    @if ($activeContracts->count() > 0)
                        <a href="{{ route('client.contracts.index') }}"
                            class="text-decoration-none small fw-bold">{{ __('common.view_all') }}</a>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($activeContracts as $contract)
                            <div class="list-group-item px-4 py-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1 fw-bold text-dark">{{ $contract->job->title }}</h6>
                                        <p class="text-muted small mb-1">
                                            {{ __('client.freelancer') }}: <span
                                                class="text-dark">{{ $contract->freelancerProfile->user->name }}</span>
                                        </p>
                                    </div>
                                    <span class="badge bg-success rounded-pill px-3">{{ ucfirst($contract->status) }}</span>
                                </div>
                                <div class="mt-2 d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-secondary small">Rp.
                                        {{ number_format($contract->final_price) }}</span>
                                    <small class="text-muted">{{ __('freelancer.started') }}:
                                        {{ $contract->start_date }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                        fill="currentColor" class="text-muted opacity-25 bi bi-clipboard-x"
                                        viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708z" />
                                        <path
                                            d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                        <path
                                            d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                    </svg>
                                </div>
                                <h6 class="text-muted">{{ __('client.no_active_contracts') }}</h6>
                                <p class="small text-muted">{{ __('common.accept_proposals_start_contracts') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom pt-4 px-4 pb-3">
                    <h5 class="fw-bold mb-0">{{ __('client.recent_proposals') }}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recentProposals as $proposal)
                            <div class="list-group-item px-4 py-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold mb-0 text-truncate text-primary" style="max-width: 200px;">
                                        <a href="{{ route('client.jobs.proposals', $proposal->job_id) }}"
                                            class="text-decoration-none">
                                            {{ $proposal->job->title }}
                                        </a>
                                    </h6>
                                    <small
                                        class="text-muted">{{ $proposal->created_at->diffForHumans(null, true, true) }}</small>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar bg-light rounded-circle text-center me-2"
                                        style="width:24px; height:24px; line-height:24px;">
                                        <small
                                            class="fw-bold text-muted">{{ substr($proposal->freelancerProfile->user->name, 0, 1) }}</small>
                                    </div>
                                    <p class="small text-muted mb-0">{{ $proposal->freelancerProfile->user->name }}</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="badge bg-light text-dark border">Bid: Rp.
                                        {{ number_format($proposal->bid_amount) }}</span>
                                    <a href="{{ route('client.jobs.proposals', $proposal->job_id) }}"
                                        class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        Review
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                        fill="currentColor" class="text-muted opacity-25 bi bi-inbox" viewBox="0 0 16 16">
                                        <path
                                            d="M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4H4.98zm-1.17-.437A1.5 1.5 0 0 1 4.98 3h6.04a1.5 1.5 0 0 1 1.17.653l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.494-1.224l-.39-3.124a.5.5 0 0 1 .106-.374l3.7-4.625zM4 6.733v.065l.44-1.1 1.2 1.4h-3.28zm5.6-1.1L10.8 7.08v-.065h-1.2z" />
                                    </svg>
                                </div>
                                <p class="text-muted mb-0">{{ __('client.no_proposals') }}</p>
                                <small class="text-muted">{{ __('common.proposals_will_appear') }}</small>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-shadow:hover {
            transform: translateY(-2px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }

        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
@endsection
