@extends('layouts.app')

@section('title', $contract->job->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="mb-3">
            @if(session('active_role') == 'client')
                <a href="{{ route('client.contracts.index') }}" class="text-decoration-none text-muted">&larr; Back to Contracts</a>
            @else
                <a href="{{ route('freelancer.contracts.index') }}" class="text-decoration-none text-muted">&larr; Back to Contracts</a>
            @endif
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-5 text-center">
                <h6 class="text-uppercase text-muted small fw-bold tracking-wide">Current Status</h6>
                
                @php
                    $status = $contract->job->status;
                    $colors = [
                        'in_progress' => 'primary',
                        'waiting_for_review' => 'warning',
                        'waiting_for_payment' => 'info',
                        'payment_verification' => 'dark',
                        'completed' => 'success',
                        'cancelled' => 'danger'
                    ];
                    $color = $colors[$status] ?? 'secondary';
                    $statusLabel = ucwords(str_replace('_', ' ', $status));
                @endphp

                <h2 class="fw-bold text-{{ $color }} display-6 mb-4">{{ $statusLabel }}</h2>

                @if(session('active_role') == 'freelancer')
                    @if($status == 'in_progress')
                        <div class="alert alert-light border">
                            <p>Complete the work and submit it for client review.</p>
                            <form action="{{ route('contracts.submit_work', $contract->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-primary btn-lg shadow-sm">
                                    <i class="bi bi-send-check me-2"></i> Submit Work for Review
                                </button>
                            </form>
                        </div>
                    @elseif($status == 'waiting_for_review')
                        <div class="alert alert-warning border-warning d-inline-block px-4">
                            <i class="bi bi-hourglass-split me-2"></i> Waiting for client approval...
                        </div>
                    @elseif($status == 'waiting_for_payment')
                        <div class="alert alert-info border-info d-inline-block px-4">
                            <i class="bi bi-cash-stack me-2"></i> Work approved! Waiting for payment...
                        </div>
                    @elseif($status == 'payment_verification')
                        <div class="alert alert-dark border">
                            <p>The client has marked the payment as sent. Please confirm receipt.</p>
                            <form action="{{ route('contracts.confirm_payment', $contract->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success btn-lg shadow-sm">
                                    <i class="bi bi-check-circle-fill me-2"></i> Confirm Payment Received
                                </button>
                            </form>
                        </div>
                    @elseif($status == 'completed')
                        <div class="alert alert-success d-inline-block px-5">
                            <i class="bi bi-trophy-fill me-2"></i> Contract Completed
                        </div>
                    @endif

                @elseif(session('active_role') == 'client')
                    @if($status == 'in_progress')
                        <div class="alert alert-light border d-inline-block px-4">
                            <i class="bi bi-gear-wide-connected me-2"></i> Freelancer is working...
                        </div>
                    @elseif($status == 'waiting_for_review')
                        <div class="alert alert-warning border bg-warning bg-opacity-10">
                            <p class="fw-bold mb-2">The freelancer has submitted the work.</p>
                            <p class="small mb-3">Please review the deliverables (via email/external link) and decide.</p>
                            <div class="d-flex gap-2 justify-content-center">
                                <form action="{{ route('contracts.reject', $contract->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-outline-danger">
                                        <i class="bi bi-x-lg me-1"></i> Request Revision
                                    </button>
                                </form>
                                <form action="{{ route('contracts.approve', $contract->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-success px-4">
                                        <i class="bi bi-check-lg me-1"></i> Approve Work
                                    </button>
                                </form>
                            </div>
                        </div>
                    @elseif($status == 'waiting_for_payment')
                        <div class="alert alert-info border bg-info bg-opacity-10">
                            <p class="fw-bold mb-2">Work Approved!</p>
                            <p class="small mb-3">Please send <strong>Rp. {{ number_format($contract->final_price) }}</strong> to the freelancer.</p>
                            <form action="{{ route('contracts.mark_paid', $contract->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-primary btn-lg">
                                    <i class="bi bi-credit-card me-2"></i> I Have Sent Payment
                                </button>
                            </form>
                        </div>
                    @elseif($status == 'payment_verification')
                        <div class="alert alert-secondary d-inline-block px-4">
                            <i class="bi bi-hourglass me-2"></i> Waiting for freelancer to confirm receipt...
                        </div>
                    @elseif($status == 'completed')
                        <div class="alert alert-success d-inline-block px-5">
                            <i class="bi bi-check-all me-2"></i> Contract Closed
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0">Project Details</h5>
            </div>
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="text-uppercase text-muted small fw-bold">Job Title</label>
                        <p class="fs-5 text-dark fw-bold mb-0">{{ $contract->job->title }}</p>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="text-uppercase text-muted small fw-bold">Description</label>
                    <p class="text-secondary" style="white-space: pre-line;">{{ $contract->job->description }}</p>
                </div>
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <label class="text-uppercase text-muted small fw-bold">Start Date</label>
                        <p class="fw-bold">{{ \Carbon\Carbon::parse($contract->start_date)->format('d M Y') }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="text-uppercase text-muted small fw-bold">End Date</label>
                        <p class="fw-bold">{{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('d M Y') : 'Open' }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="text-uppercase text-muted small fw-bold">Price</label>
                        <p class="fw-bold text-success">Rp. {{ number_format($contract->final_price) }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="text-uppercase text-muted small fw-bold">Contract ID</label>
                        <p class="fw-bold">#{{ $contract->id }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4 bg-primary text-white">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Contact Information</h5>
                
                @if(session('active_role') == 'freelancer')
                    {{-- Freelancer sees Client Info --}}
                    <div class="mb-3">
                        <small class="text-white-50 text-uppercase fw-bold">Client</small>
                        <div class="fs-5 fw-bold">{{ $contract->clientProfile->company_name ?? $contract->clientProfile->user->name }}</div>
                    </div>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2 d-flex align-items-center">
                            <i class="bi bi-envelope-fill me-3 opacity-50"></i>
                            {{ $contract->clientProfile->contact_email ?? $contract->clientProfile->user->email }}
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-telephone-fill me-3 opacity-50"></i>
                            {{ $contract->clientProfile->contact_phone ?? 'No phone provided' }}
                        </li>
                    </ul>
                @else
                    {{-- Client sees Freelancer Info --}}
                    <div class="mb-3">
                        <small class="text-white-50 text-uppercase fw-bold">Freelancer</small>
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
                            {{ $contract->freelancerProfile->contact_phone ?? 'No phone provided' }}
                        </li>
                    </ul>
                @endif
            </div>
            <div class="card-footer bg-primary border-top border-white border-opacity-25 text-white-50 small">
                <i class="bi bi-info-circle me-1"></i> Use this to communicate for file sharing or meetings.
            </div>
        </div>
    </div>
</div>
@endsection 