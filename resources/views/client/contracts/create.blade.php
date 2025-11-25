@extends('layouts.app')

@section('title', 'Finalize Contract')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white py-3">
                <h4 class="fw-bold mb-0">Create Contract</h4>
                <p class="mb-0 opacity-75">Review details and start the project.</p>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('client.contracts.store') }}" method="POST">
                    @csrf
                    
                    {{-- Proposal Selection (Auto-selected if ID passed) --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Select Accepted Proposal</label>
                        <select name="proposal_id" class="form-select bg-light" id="proposalSelect" onchange="updateFormDetails(this)">
                            @foreach($acceptedProposals as $p)
                                <option value="{{ $p->id }}" 
                                    data-price="{{ $p->bid_amount }}" 
                                    data-freelancer="{{ $p->freelancerProfile->user->name }}"
                                    data-job="{{ $p->job->title }}"
                                    {{ $selectedProposalId == $p->id ? 'selected' : '' }}>
                                    {{ $p->job->title }} - {{ $p->freelancerProfile->user->name }} (${{ $p->bid_amount }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Read-only Summary --}}
                    <div class="alert alert-light border mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted d-block">Freelancer</small>
                                <strong id="summaryFreelancer">-</strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Job Title</small>
                                <strong id="summaryJob">-</strong>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Agreed Final Price ($)</label>
                            <input type="number" name="final_price" id="finalPrice" class="form-control form-control-lg fw-bold" step="0.01" required>
                            <div class="form-text">You can adjust the final amount if discussed with the freelancer.</div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">End Date (Optional)</label>
                            <input type="date" name="end_date" class="form-control">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">Start Contract</button>
                        <a href="{{ route('client.home') }}" class="btn btn-link text-muted">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Simple script to update the UI based on selected dropdown
    function updateFormDetails(select) {
        const option = select.options[select.selectedIndex];
        document.getElementById('finalPrice').value = option.dataset.price;
        document.getElementById('summaryFreelancer').innerText = option.dataset.freelancer;
        document.getElementById('summaryJob').innerText = option.dataset.job;
    }

    // Run on load
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('proposalSelect');
        if(select.options.length > 0) {
            updateFormDetails(select);
        }
    });
</script>
@endsection