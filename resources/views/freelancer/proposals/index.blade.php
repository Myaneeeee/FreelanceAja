@extends('layouts.app')

@section('title', __('freelancer.my_proposals'))

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">{{ __('freelancer.my_proposals') }}</h2>
            <p class="text-muted small mb-0">{{ __('freelancer.manage_proposals_desc') }}</p>
        </div>
        <a href="{{ route('freelancer.home') }}" class="btn btn-outline-secondary btn-sm">
            &larr; {{ __('common.back_to_home') }}
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form action="{{ route('freelancer.proposals.index') }}" method="GET" class="row g-2 align-items-center">
                {{-- Search Input --}}
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" class="form-control border-start-0 ps-0"
                            placeholder="{{ __('freelancer.search_placeholder') }}" value="{{ request('q') }}">
                    </div>
                </div>

                {{-- Status Filter --}}
                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">{{ __('freelancer.all_statuses') }}</option>
                        <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>
                            {{ __('freelancer.status_pending') }}</option>
                        <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>
                            {{ __('freelancer.status_accepted') }}</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                            {{ __('freelancer.status_rejected') }}</option>
                    </select>
                </div>

                {{-- Filter Button (Optional but good for mobile) --}}
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">{{ __('freelancer.filter') }}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-secondary text-uppercase small" style="width: 40%;">
                                {{ __('freelancer.job_details') }}</th>
                            <th class="py-3 text-secondary text-uppercase small">{{ __('freelancer.bid_amount') }}</th>
                            <th class="py-3 text-secondary text-uppercase small">{{ __('freelancer.date_submitted') }}</th>
                            <th class="py-3 text-secondary text-uppercase small">{{ __('freelancer.status') }}</th>
                            <th class="pe-4 py-3 text-end text-secondary text-uppercase small">
                                {{ __('freelancer.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proposals as $proposal)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('freelancer.jobs.show', $proposal->job_id) }}"
                                            class="fw-bold text-dark text-decoration-none mb-1">
                                            {{ $proposal->job->title }}
                                        </a>
                                        <div class="d-flex align-items-center">
                                            <span
                                                class="avatar-circle bg-light text-secondary rounded-circle text-center me-2 border"
                                                style="width: 24px; height: 24px; font-size: 10px; line-height: 24px;">
                                                {{ substr($proposal->job->clientProfile->user->name, 0, 1) }}
                                            </span>
                                            <small class="text-muted">
                                                {{ $proposal->job->clientProfile->user->name }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">Rp. {{ number_format($proposal->bid_amount) }}</span>
                                </td>
                                <td class="text-muted small">
                                    {{ $proposal->created_at->format('M d, Y') }}
                                </td>
                                <td>
                                    @php
                                        $statusClass = match ($proposal->status) {
                                            'accepted' => 'success',
                                            'rejected' => 'danger',
                                            default => 'secondary', // pending/sent
                                        };
                                        $statusLabel = match ($proposal->status) {
                                            'sent' => __('freelancer.status_pending'),
                                            'accepted' => __('freelancer.status_accepted'),
                                            'rejected' => __('freelancer.status_rejected'),
                                            default => ucfirst($proposal->status),
                                        };
                                    @endphp
                                    <span
                                        class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} border border-{{ $statusClass }}-subtle rounded-pill px-3">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('freelancer.jobs.show', $proposal->job_id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        {{ __('freelancer.view_job') }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="mb-3 text-muted opacity-25">
                                        <i class="bi bi-inbox display-4"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">{{ __('freelancer.no_proposals_found') }}</h5>
                                    <p class="text-muted small mb-3">
                                        @if (request('q') || request('status'))
                                            {{ __('freelancer.try_adjust_search') }}
                                        @else
                                            {{ __('freelancer.start_applying_here') }}
                                        @endif
                                    </p>
                                    @if (request('q') || request('status'))
                                        <a href="{{ route('freelancer.proposals.index') }}"
                                            class="btn btn-outline-secondary btn-sm">{{ __('freelancer.clear_filters') }}</a>
                                    @else
                                        <a href="{{ route('freelancer.jobs.index') }}"
                                            class="btn btn-primary btn-sm">{{ __('freelancer.find_work') }}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($proposals->hasPages())
            <div class="card-footer bg-white border-top-0 py-3">
                {{ $proposals->links() }}
            </div>
        @endif
    </div>
@endsection
