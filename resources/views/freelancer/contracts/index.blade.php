@extends('layouts.app')

@section('title', __('freelancer.my_contracts'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark">{{ __('freelancer.my_contracts') }}</h2>
        <p class="text-muted mb-0">Manage your active projects and review work history.</p>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom-0 pt-3 px-4">
        <ul class="nav nav-tabs card-header-tabs" id="contractTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab" aria-selected="true">
                    {{ __('freelancer.active_contracts') }} 
                    @if($activeContracts->count() > 0)
                        <span class="badge bg-success rounded-pill ms-2">{{ $activeContracts->count() }}</span>
                    @endif
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold text-muted" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-selected="false">
                    {{ __('freelancer.work_history') }}
                </button>
            </li>
        </ul>
    </div>
    
    <div class="card-body p-0">
        <div class="tab-content" id="contractTabsContent">
            
            <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3" style="width: 40%;">Job Details</th>
                                <th class="py-3">Client</th>
                                <th class="py-3">Timeline</th>
                                <th class="py-3">Total Value</th>
                                <th class="py-3 text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activeContracts as $contract)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('freelancer.jobs.show', $contract->job_id) }}" class="fw-bold text-dark text-decoration-none">
                                            {{ $contract->job->title }}
                                        </a>
                                        <span class="small text-success">
                                            <i class="bi bi-circle-fill" style="font-size: 6px; vertical-align: middle;"></i> Active
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-light text-secondary rounded-circle text-center me-2 border" style="width: 30px; height: 30px; line-height: 28px;">
                                            {{ substr($contract->job->clientProfile->user->name, 0, 1) }}
                                        </div>
                                        {{ $contract->job->clientProfile->user->name }}
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted d-block">Started</small>
                                    {{ \Carbon\Carbon::parse($contract->start_date)->format('M d, Y') }}
                                </td>
                                <td class="fw-bold text-dark">Rp. {{ number_format($contract->final_price, 2) }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('freelancer.jobs.show', $contract->job_id) }}" class="btn btn-sm btn-outline-primary">
                                        View Job
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="mb-3 text-muted opacity-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-briefcase" viewBox="0 0 16 16">
                                            <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5zM1 4.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5H1.5a.5.5 0 0 1-.5-.5v-8z"/>
                                        </svg>
                                    </div>
                                    <p class="text-muted mb-2">{{ __('freelancer.no_active_contracts') }}</p>
                                    <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-primary btn-sm">Find Work</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3" style="width: 40%;">Job Details</th>
                                <th class="py-3">Client</th>
                                <th class="py-3">Ended</th>
                                <th class="py-3">Final Price</th>
                                <th class="py-3 text-end pe-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pastContracts as $contract)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="fw-bold text-muted">{{ $contract->job->title }}</div>
                                </td>
                                <td>{{ $contract->job->clientProfile->user->name }}</td>
                                <td>{{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('M d, Y') : '-' }}</td>
                                <td>Rp. {{ number_format($contract->final_price, 2) }}</td>
                                <td class="text-end pe-4">
                                    @if($contract->status == 'completed')
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill">Completed</span>
                                    @elseif($contract->status == 'cancelled')
                                        <span class="badge bg-danger-subtle text-danger rounded-pill">Cancelled</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-dark rounded-pill">{{ ucfirst($contract->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">{{ __('freelancer.no_past_contracts') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection