@extends('layouts.app')

@section('title', __('client.my_job_postings'))

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-0 text-dark">{{ __('client.my_job_postings') }}</h2>
        <p class="text-muted small mb-0">Manage your active listings and view proposals.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="{{ route('client.jobs.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> {{ __('client.post_job') }}
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form action="{{ route('client.jobs.index') }}" method="GET" class="row g-2">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control border-start-0 ps-0" placeholder="Search by job title..." value="{{ request('q') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-light w-100 border">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary text-uppercase small" style="width: 45%;">Job Details</th>
                        <th class="py-3 text-secondary text-uppercase small">Budget</th>
                        <th class="py-3 text-secondary text-uppercase small">Proposals</th>
                        <th class="py-3 text-secondary text-uppercase small">Status</th>
                        <th class="py-3 text-end pe-4 text-secondary text-uppercase small">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                    <tr class="position-relative">
                        <td class="ps-4 py-3">
                            <div class="d-flex flex-column">
                                <a href="{{ route('client.jobs.proposals', $job->id) }}" class="fw-bold text-dark text-decoration-none stretched-link">
                                    {{ $job->title }}
                                </a>
                                <div class="small text-muted mt-1">
                                    <span class="badge bg-light text-secondary border me-1">
                                        {{ $job->type == 'fixed_price' ? 'Fixed Price' : 'Hourly' }}
                                    </span>
                                    <span>Posted {{ $job->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="fw-semibold text-dark">
                                Rp. {{ number_format($job->budget) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($job->new_proposals_count > 0)
                                    <span class="badge bg-danger rounded-pill me-2" title="New Proposals">
                                        {{ $job->new_proposals_count }} New
                                    </span>
                                @endif
                                <span class="text-muted small">
                                    {{ $job->proposals_count }} Total
                                </span>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusClass = match($job->status) {
                                    'open' => 'success',
                                    'in_progress' => 'primary',
                                    'completed' => 'secondary',
                                    'cancelled' => 'danger',
                                    default => 'secondary'
                                };
                                $statusLabel = match($job->status) {
                                    'in_progress' => 'In Progress',
                                    default => ucfirst($job->status)
                                };
                            @endphp
                            <span class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} border border-{{ $statusClass }}-subtle rounded-pill px-3">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="position-relative z-2">
                                <a href="{{ route('client.jobs.proposals', $job->id) }}" class="btn btn-sm btn-outline-primary">
                                    Manage
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="mb-3 text-muted opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-journal-plus" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
                                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
                                </svg>
                            </div>
                            <h5 class="fw-bold text-dark">{{ __('client.no_jobs_yet') }}</h5>
                            <p class="text-muted mb-3">Create a job post to start finding freelancers.</p>
                            <a href="{{ route('client.jobs.create') }}" class="btn btn-primary">
                                {{ __('client.create_first_job') }}
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($jobs->hasPages())
    <div class="card-footer bg-white py-3">
        {{ $jobs->links() }}
    </div>
    @endif
</div>
@endsection