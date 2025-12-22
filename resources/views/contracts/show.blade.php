@extends('layouts.app')

@section('title', $contract->job->title)

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="mb-3">
                @if (session('active_role') == 'client')
                    <a href="{{ route('client.contracts.index') }}" class="text-decoration-none text-muted">&larr; Back to
                        Contracts</a>
                @else
                    <a href="{{ route('freelancer.contracts.index') }}" class="text-decoration-none text-muted">&larr; Back to
                        Contracts</a>
                @endif
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-5 text-center">
                    <h6 class="text-uppercase text-muted small fw-bold tracking-wide">{{ __('common.current_status') }}</h6>

                    @php
                        $status = $contract->job->status;
                        $colors = [
                            'in_progress' => 'primary',
                            'waiting_for_review' => 'warning',
                            'waiting_for_payment' => 'info',
                            'payment_verification' => 'dark',
                            'completed' => 'success',
                            'cancelled' => 'danger',
                        ];
                        $color = $colors[$status] ?? 'secondary';
                        $statusLabel = trans('client.status_' . $status);
                    @endphp

                    <h2 class="fw-bold text-{{ $color }} display-6 mb-4">{{ $statusLabel }}</h2>

                    @if (session('active_role') == 'freelancer')
                        @if ($status == 'in_progress')
                            <div class="alert alert-light border">
                                <p>{{ __('common.complete_and_submit_for_review') }}</p>
                                <form action="{{ route('contracts.submit_work', $contract->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-primary btn-lg shadow-sm">
                                        <i class="bi bi-send-check me-2"></i> {{ __('common.submit_work_for_review') }}
                                    </button>
                                </form>
                            </div>
                        @elseif($status == 'waiting_for_review')
                            <div class="alert alert-warning border-warning d-inline-block px-4">
                                <i class="bi bi-hourglass-split me-2"></i> {{ __('common.freelancer_submitted_work') }}
                            </div>
                            <div class="mt-2 small text-muted">{{ __('common.please_review_deliverables') }}</div>
                        @elseif($status == 'waiting_for_payment')
                            <div class="alert alert-info border-info d-inline-block px-4">
                                <i class="bi bi-cash-stack me-2"></i> {{ __('common.work_approved_waiting_payment') }}
                            </div>
                        @elseif($status == 'payment_verification')
                            <div class="alert alert-dark border">
                                <p>{{ __('common.i_have_sent_payment') }}</p>
                                <form action="{{ route('contracts.confirm_payment', $contract->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-success btn-lg shadow-sm">
                                        <i class="bi bi-check-circle-fill me-2"></i>
                                        {{ __('common.confirm_payment_received') }}
                                    </button>
                                </form>
                            </div>
                        @elseif($status == 'completed')
                            <div class="alert alert-success d-inline-block px-5">
                                <i class="bi bi-trophy-fill me-2"></i> {{ __('common.contract_completed') }}
                            </div>
                        @endif
                    @elseif(session('active_role') == 'client')
                        @if ($status == 'in_progress')
                            <div class="alert alert-light border d-inline-block px-4">
                                <i class="bi bi-gear-wide-connected me-2"></i> {{ __('common.freelancer_is_working') }}
                            </div>
                        @elseif($status == 'waiting_for_review')
                            <div class="alert alert-warning border bg-warning bg-opacity-10">
                                <p class="fw-bold mb-2">{{ __('common.freelancer_submitted_work') }}</p>
                                <p class="small mb-3">{{ __('common.please_review_deliverables') }}</p>
                                <div class="d-flex gap-2 justify-content-center">
                                    <form action="{{ route('contracts.reject', $contract->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-outline-danger">
                                            <i class="bi bi-x-lg me-1"></i> {{ __('common.request_revision') }}
                                        </button>
                                    </form>
                                    <form action="{{ route('contracts.approve', $contract->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-success px-4">
                                            <i class="bi bi-check-lg me-1"></i> {{ __('common.approve_work') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @elseif($status == 'waiting_for_payment')
                            <div class="alert alert-info border bg-info bg-opacity-10">
                                <p class="fw-bold mb-2">{{ __('common.work_approved_waiting_payment') }}</p>
                                <p class="small mb-3">
                                    {{ __('client.please_send_payment', ['amount' => number_format($contract->final_price)]) ?? 'Please send ' }}
                                    <strong>Rp. {{ number_format($contract->final_price) }}</strong>
                                    {{ __('contracts.to_freelancer') }}.
                                </p>
                                <form action="{{ route('contracts.mark_paid', $contract->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-primary btn-lg">
                                        <i class="bi bi-credit-card me-2"></i> {{ __('common.i_have_sent_payment') }}
                                    </button>
                                </form>
                            </div>
                        @elseif($status == 'payment_verification')
                            <div class="alert alert-secondary d-inline-block px-4">
                                <i class="bi bi-hourglass me-2"></i> {{ __('common.waiting_for_freelancer_confirm') }}
                            </div>
                        @elseif($status == 'completed')
                            <div class="alert alert-success d-inline-block px-5">
                                <i class="bi bi-check-all me-2"></i> {{ __('common.contract_closed') }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold mb-0">{{ __('client.project_details') }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <label class="text-uppercase text-muted small fw-bold">{{ __('client.job_title') }}</label>
                            <p class="fs-5 text-dark fw-bold mb-0">{{ $contract->job->title }}</p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="text-uppercase text-muted small fw-bold">{{ __('client.description') }}</label>
                        <p class="text-secondary" style="white-space: pre-line;">{{ $contract->job->description }}</p>
                    </div>
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <label class="text-uppercase text-muted small fw-bold">{{ __('client.start_date') }}</label>
                            <p class="fw-bold">{{ \Carbon\Carbon::parse($contract->start_date)->format('d M Y') }}</p>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="text-uppercase text-muted small fw-bold">{{ __('client.end_date') }}</label>
                            <p class="fw-bold">
                                {{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('d M Y') : __('common.open') }}
                            </p>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="text-uppercase text-muted small fw-bold">{{ __('client.price') }}</label>
                            <p class="fw-bold text-success">Rp. {{ number_format($contract->final_price) }}</p>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="text-uppercase text-muted small fw-bold">{{ __('client.contract_id') }}</label>
                            <p class="fw-bold">#{{ $contract->id }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4 bg-primary text-white">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">{{ __('client.contact_information') }}</h5>

                    @if (session('active_role') == 'freelancer')
                        {{-- Freelancer sees Client Info --}}
                        <div class="mb-3">
                            <small class="text-white-50 text-uppercase fw-bold">{{ __('client.client') }}</small>
                            <div class="fs-5 fw-bold">
                                {{ $contract->clientProfile->company_name ?? $contract->clientProfile->user->name }}</div>
                        </div>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2 d-flex align-items-center">
                                <i class="bi bi-envelope-fill me-3 opacity-50"></i>
                                {{ $contract->clientProfile->contact_email ?? $contract->clientProfile->user->email }}
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="bi bi-telephone-fill me-3 opacity-50"></i>
                                {{ $contract->clientProfile->contact_phone ?? __('common.no_phone_provided') }}
                            </li>
                        </ul>
                    @else
                        {{-- Client sees Freelancer Info --}}
                        <div class="mb-3">
                            <small class="text-white-50 text-uppercase fw-bold">{{ __('common.freelancer') }}</small>
                            <div class="fs-5 fw-bold">{{ $contract->freelancerProfile->user->name }}</div>
                            <div class="small text-white-50">{{ $contract->freelancerProfile->headline }}</div>
                        </div>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2 d-flex align-items-center">
                                <i class="bi bi-envelope-fill me-3 opacity-50"></i>
                                {{ $contract->freelancerProfile->contact_email ?? $contract->freelancerProfile->user->email }}
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="bi bi-telephone-fill me-3 opacity-50"></i>
                                {{ $contract->freelancerProfile->contact_phone ?? __('common.no_phone_provided') }}
                            </li>
                        </ul>
                    @endif
                </div>
                <div class="card-footer bg-primary border-top border-white border-opacity-25 text-white-50 small">
                    <i class="bi bi-info-circle me-1"></i> {{ __('common.use_this_to_communicate') }}
                </div>
            </div>
        </div>
    </div>
@endsection
