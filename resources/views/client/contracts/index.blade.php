@extends('layouts.app')

@section('title', __('client.contracts'))

@section('content')
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">{{ __('client.contracts') }}</h2>
            <p class="text-muted small mb-0">{{ __('client.manage_active_work_desc') }}</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <form action="{{ route('client.contracts.index') }}" method="GET" class="d-inline-block w-100 w-md-auto">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control border-start-0"
                        placeholder="{{ __('client.search_contract_placeholder') }}" value="{{ request('q') }}">
                    <input type="hidden" name="status" value="{{ request('status', 'active') }}">
                    <button type="submit" class="btn btn-outline-secondary">{{ __('freelancer.search_button') }}</button>
                </div>
            </form>
        </div>
    </div>

    <ul class="nav nav-tabs mb-4 border-bottom-0">
        <li class="nav-item">
            <a class="nav-link {{ request('status', 'active') == 'active' ? 'active fw-bold' : '' }}"
                href="{{ route('client.contracts.index', ['status' => 'active']) }}">
                {{ __('common.active') }} <span class="badge bg-success ms-1 rounded-pill">{{ $activeCount }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'all' ? 'active fw-bold' : '' }}"
                href="{{ route('client.contracts.index', ['status' => 'all']) }}">
                {{ __('freelancer.all_history') }} <span
                    class="badge bg-secondary ms-1 rounded-pill">{{ $allCount }}</span>
            </a>
        </li>
    </ul>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-secondary text-uppercase small" style="width: 35%;">
                                {{ __('client.job') }} & {{ __('freelancer.client') ?? 'Freelancer' }}</th>
                            <th class="py-3 text-secondary text-uppercase small">
                                {{ __('freelancer.start_date') ?? 'Start Date' }}</th>
                            <th class="py-3 text-secondary text-uppercase small">{{ __('client.amount') ?? 'Amount' }}</th>
                            <th class="py-3 text-secondary text-uppercase small">{{ __('client.status') }}</th>
                            <th class="pe-4 py-3 text-end text-secondary text-uppercase small">{{ __('client.action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contracts as $contract)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle text-center me-3 d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <span
                                                class="fw-bold">{{ substr($contract->freelancerProfile->user->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $contract->job->title }}</div>
                                            <small
                                                class="text-muted">{{ $contract->freelancerProfile->user->name }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-secondary">
                                    {{ \Carbon\Carbon::parse($contract->start_date)->format('M d, Y') }}</td>
                                <td class="fw-bold text-dark">
                                    Rp. {{ number_format($contract->final_price) }}
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match ($contract->status) {
                                            'active' => 'primary',
                                            'completed' => 'success',
                                            'disputed' => 'warning',
                                            'cancelled' => 'danger',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <span
                                        class="badge bg-{{ $badgeClass }}-subtle text-{{ $badgeClass }} border border-{{ $badgeClass }}-subtle rounded-pill px-3">
                                        {{ __('client.status_' . $contract->status) }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('contracts.show', $contract->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        {{ __('client.manage') }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="mb-3 text-muted opacity-50">
                                        <i class="bi bi-folder-x display-4"></i>
                                    </div>
                                    <h5 class="fw-bold">{{ __('client.no_proposals') }}</h5>
                                    <p class="text-muted small">{{ __('client.accept_proposal_to_start') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($contracts->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $contracts->links() }}
            </div>
        @endif
    </div>
@endsection
