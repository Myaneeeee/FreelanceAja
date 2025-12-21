@extends('layouts.app')

@section('title', 'All Contracts')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-0">Contracts</h2>
        <p class="text-muted small mb-0">Manage your active work and view history.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <form action="{{ route('client.contracts.index') }}" method="GET" class="d-inline-block w-100 w-md-auto">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control border-start-0" placeholder="Search contract..." value="{{ request('q') }}">
                <input type="hidden" name="status" value="{{ request('status', 'active') }}">
                <button type="submit" class="btn btn-outline-secondary">Search</button>
            </div>
        </form>
    </div>
</div>

<ul class="nav nav-tabs mb-4 border-bottom-0">
    <li class="nav-item">
        <a class="nav-link {{ request('status', 'active') == 'active' ? 'active fw-bold' : '' }}" 
           href="{{ route('client.contracts.index', ['status' => 'active']) }}">
           Active <span class="badge bg-success ms-1 rounded-pill">{{ $activeCount }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('status') == 'all' ? 'active fw-bold' : '' }}" 
           href="{{ route('client.contracts.index', ['status' => 'all']) }}">
           All History <span class="badge bg-secondary ms-1 rounded-pill">{{ $allCount }}</span>
        </a>
    </li>
</ul>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary text-uppercase small" style="width: 35%;">Job & Freelancer</th>
                        <th class="py-3 text-secondary text-uppercase small">Start Date</th>
                        <th class="py-3 text-secondary text-uppercase small">Amount</th>
                        <th class="py-3 text-secondary text-uppercase small">Status</th>
                        <th class="pe-4 py-3 text-end text-secondary text-uppercase small">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($contracts as $contract)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle text-center me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <span class="fw-bold">{{ substr($contract->freelancerProfile->user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $contract->job->title }}</div>
                                    <small class="text-muted">{{ $contract->freelancerProfile->user->name }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-secondary">{{ \Carbon\Carbon::parse($contract->start_date)->format('M d, Y') }}</td>
                        <td class="fw-bold text-dark">
                            Rp. {{ number_format($contract->final_price) }}
                        </td>
                        <td>
                            @php
                                $badgeClass = match($contract->status) {
                                    'active' => 'success',
                                    'completed' => 'primary',
                                    'cancelled' => 'danger',
                                    'disputed' => 'warning',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeClass }}-subtle text-{{ $badgeClass }} border border-{{ $badgeClass }}-subtle rounded-pill px-3">
                                {{ ucfirst($contract->status) }}
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <button class="btn btn-sm btn-outline-dark" disabled>
                                Manage
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="mb-3 text-muted opacity-50">
                                <i class="bi bi-folder-x display-4"></i>
                            </div>
                            <h5 class="fw-bold">No contracts found</h5>
                            <p class="text-muted small">Accept a proposal to start a new contract.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($contracts->hasPages())
    <div class="card-footer bg-white py-3">
        {{ $contracts->links() }}
    </div>
    @endif
</div>
@endsection