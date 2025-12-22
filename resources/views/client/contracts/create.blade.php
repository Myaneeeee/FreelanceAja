@extends('layouts.app')

@section('title', 'Finalize Contract')

@section('content')

    {{-- Case 1: No Proposals to process --}}
    @if ($acceptedProposals->isEmpty())
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <div class="mb-4">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-file-earmark-text text-muted h1 mb-0"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold">{{ __('client.no_accepted_proposals_found') }}</h3>
                    <p class="text-muted mb-4">{{ __('client.accept_a_proposal_msg') }}</p>
                    <a href="{{ route('client.jobs.index') }}"
                        class="btn btn-primary btn-lg">{{ __('client.go_to_my_jobs') }}</a>
                </div>
            </div>
        </div>

        {{-- Case 2: We have data, show the form --}}
    @else
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center mb-4">
                    <a href="{{ route('client.home') }}" class="btn btn-outline-light text-muted border-0 me-2"><i
                            class="bi bi-arrow-left"></i></a>
                    <div>
                        <h3 class="fw-bold mb-0">{{ __('client.create_contract') }}</h3>
                        <p class="text-muted mb-0 small">{{ __('client.finalize_terms_step') }}</p>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="{{ route('client.contracts.store') }}" method="POST">
                            @csrf

                            {{-- 1. Proposal Selector --}}
                            <div class="mb-4">
                                <label
                                    class="form-label fw-bold text-uppercase small text-secondary">{{ __('client.select_freelancer_and_job') }}</label>
                                <select name="proposal_id" class="form-select form-select-lg bg-light border-0"
                                    id="proposalSelect" onchange="updateFormDetails(this)">
                                    @foreach ($acceptedProposals as $p)
                                        <option value="{{ $p->id }}" data-price="{{ $p->bid_amount }}"
                                            data-freelancer="{{ $p->freelancerProfile->user->name }}"
                                            data-headline="{{ $p->freelancerProfile->headline }}"
                                            data-initial="{{ substr($p->freelancerProfile->user->name, 0, 1) }}"
                                            data-job="{{ $p->job->title }}"
                                            {{ $selectedProposalId == $p->id ? 'selected' : '' }}>
                                            {{ $p->freelancerProfile->user->name }} — {{ $p->job->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- 2. Visual Summary Card (Dynamic) --}}
                            <div class="card bg-light border-0 mb-4">
                                <div class="card-body d-flex align-items-center">
                                    <div class="avatar bg-primary text-white rounded-circle text-center me-3 d-flex align-items-center justify-content-center fw-bold fs-4"
                                        style="width: 56px; height: 56px;" id="summaryAvatar">
                                        -
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0" id="summaryFreelancer">-</h5>
                                        <div class="text-muted small" id="summaryHeadline">-</div>
                                        <div class="badge bg-white text-dark border mt-1" id="summaryJob">-</div>
                                    </div>
                                </div>
                            </div>

                            {{-- 3. Terms --}}
                            <div class="row g-3 mb-4">
                                <div class="col-md-12">
                                    <label
                                        class="form-label fw-bold text-uppercase small text-secondary">{{ __('client.agreed_final_price') }}</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-white text-muted border-end-0">Rp.</span>
                                        <input type="number" name="final_price" id="finalPrice"
                                            class="form-control border-start-0 fw-bold text-dark" step="0.01" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label
                                        class="form-label fw-bold text-uppercase small text-secondary">{{ __('client.start_date') }}</label>
                                    <input type="date" name="start_date" class="form-control"
                                        value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label
                                        class="form-label fw-bold text-uppercase small text-secondary">{{ __('client.end_date') }}
                                        (Optional)</label>
                                    <input type="date" name="end_date" class="form-control">
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('client.jobs.index') }}"
                                    class="text-decoration-none text-muted">{{ __('client.cancel') }}</a>
                                <button type="submit" class="btn btn-success btn-lg px-5">
                                    {{ __('client.start_contract') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function updateFormDetails(select) {
                const option = select.options[select.selectedIndex];

                document.getElementById('finalPrice').value = option.dataset.price;

                document.getElementById('summaryFreelancer').innerText = option.dataset.freelancer;
                document.getElementById('summaryHeadline').innerText = option.dataset.headline || 'Freelancer';
                document.getElementById('summaryJob').innerText = "{{ __('client.job_label') }}: " + option.dataset.job;
                document.getElementById('summaryAvatar').innerText = option.dataset.initial;
            }

            document.addEventListener('DOMContentLoaded', function() {
                const select = document.getElementById('proposalSelect');
                if (select && select.options.length > 0) {
                    updateFormDetails(select);
                }
            });
        </script>
    @endif

@endsection
