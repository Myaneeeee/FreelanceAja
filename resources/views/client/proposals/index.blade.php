@extends('layouts.app')

@section('title', 'Review Proposals')

@section('content')
    <div class="mb-4">
        <a href="{{ route('client.jobs.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">&larr;
            {{ __('client.back_to_jobs') }}</a>
        <h3 class="fw-bold">{{ __('client.proposals_for') }} {{ $job->title }}</h3>
        <div class="d-flex gap-3 text-muted">
            <span><i class="bi bi-cash"></i> {{ __('client.budget') }}: Rp. {{ number_format($job->budget) }}</span>
            <span><i class="bi bi-clock"></i> {{ __('client.deadline') }}:
                {{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}</span>
        </div>

        @if ($job->proposals->where('status', 'sent')->count() > 0)
            <form action="{{ route('client.proposals.reject_all', $job->id) }}" method="POST"
                onsubmit="return confirm(@json(__('client.reject_all_confirm')));">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-x-circle me-1"></i> {{ __('client.reject_all_pending') }}
                </button>
            </form>
        @endif
    </div>

    <div class="row">
        <div class="col-md-12">
            @forelse($job->proposals as $proposal)
                <div class="card shadow-sm border-0 mb-3 {{ $proposal->status == 'rejected' ? 'opacity-50' : '' }}">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="fw-bold mb-1">{{ $proposal->freelancerProfile->user->name }}</h5>
                                <p class="text-muted small mb-2">{{ $proposal->freelancerProfile->headline }}</p>

                                @if ($proposal->status == 'accepted')
                                    <span class="badge bg-success mb-2">{{ __('client.accepted') }}</span>
                                @elseif($proposal->status == 'rejected')
                                    <span class="badge bg-danger mb-2">{{ __('client.rejected') }}</span>
                                @else
                                    <span class="badge bg-secondary mb-2">{{ __('client.pending_review') }}</span>
                                @endif
                            </div>
                            <div class="text-end">
                                <h4 class="fw-bold text-primary mb-0">Rp. {{ number_format($proposal->bid_amount) }}</h4>
                                <small class="text-muted">{{ __('client.bid_amount') }}</small>
                            </div>
                        </div>

                        <div class="bg-light p-3 rounded mb-3 mt-2">
                            <p class="mb-0 text-secondary" style="white-space: pre-line;">{{ $proposal->cover_letter }}</p>

                            @if ($proposal->attachment_path)
                                <div class="mt-3 pt-3 border-top">
                                    <span
                                        class="fw-bold small text-uppercase text-muted me-2">{{ __('client.attachment') }}</span>
                                    <a href="{{ asset('storage/' . $proposal->attachment_path) }}" target="_blank"
                                        class="btn btn-sm btn-outline-dark bg-white">
                                        <i class="bi bi-file-earmark-pdf text-danger"></i>
                                        {{ __('client.view_pdf_proposal') }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        @if ($proposal->status == 'sent')
                            <div class="d-flex gap-2 justify-content-end">

                                <form action="{{ route('client.proposals.reject', $proposal->id) }}" method="POST"
                                    onsubmit="return confirm('{{ __('common.confirm_reject') }}');">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">
                                        {{ __('common.reject') }}
                                    </button>
                                </form>

                                <form action="{{ route('client.proposals.accept', $proposal->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        {{ __('common.accept') }}
                                    </button>
                                </form>

                            </div>
                        @elseif($proposal->status == 'accepted')
                            <div class="d-flex justify-content-end align-items-center gap-3">
                                <span class="text-success small">
                                    <i class="bi bi-check-circle"></i> {{ __('client.proposal_accepted') }}
                                </span>

                                @if (!$proposal->contract)
                                    <a href="{{ route('client.contracts.create', ['proposal_id' => $proposal->id]) }}"
                                        class="btn btn-primary">
                                        {{ __('client.finalize_contract') }}
                                    </a>
                                @else
                                    <span class="badge bg-light text-dark border">{{ __('client.contract_active') }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-5 bg-white rounded shadow-sm">
                    <p class="text-muted">{{ __('client.no_proposals_received') }}</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
