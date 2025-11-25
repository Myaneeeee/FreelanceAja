@extends('layouts.app')

@section('title', $job->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Job Details -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-3">{{ $job->title }}</h2>
                
                <div class="mb-4">
                    <span class="badge bg-primary me-2">{{ ucfirst($job->type) }}</span>
                    <span class="text-muted">Posted {{ $job->created_at->format('M d, Y') }}</span>
                </div>

                <h5 class="fw-bold mt-4">Description</h5>
                <p class="text-secondary" style="white-space: pre-line;">{{ $job->description }}</p>

                <h5 class="fw-bold mt-4">Required Skills</h5>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    @foreach($job->skills as $skill)
                        <span class="badge bg-secondary-subtle text-secondary border">{{ $skill->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Proposal Form -->
        @if($existingProposal)
            <div class="alert alert-success border-0 shadow-sm">
                <h5 class="alert-heading fw-bold">Proposal Submitted!</h5>
                <p>You have already applied for this job on {{ $existingProposal->created_at->format('M d, Y') }}.</p>
                <hr>
                <p class="mb-0">Current Status: <strong>{{ ucfirst($existingProposal->status) }}</strong></p>
            </div>
        @else
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white pt-4 px-4 border-bottom-0">
                    <h4 class="fw-bold">Submit a Proposal</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('freelancer.jobs.proposals.submit', $job->id) }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Your Bid Amount ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="bid_amount" class="form-control" value="{{ old('bid_amount', $job->budget) }}" step="0.01" required>
                                </div>
                                <small class="text-muted">Client's budget: ${{ number_format($job->budget) }}</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Cover Letter</label>
                            <textarea name="cover_letter" rows="6" class="form-control" placeholder="Introduce yourself and explain why you're the best fit for this job..." required>{{ old('cover_letter') }}</textarea>
                            @error('cover_letter') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-light me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Submit Proposal</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar Info -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">About the Client</h5>
                <p class="fw-bold mb-1">{{ $job->clientProfile->company_name ?? 'Individual Client' }}</p>
                <p class="text-muted small mb-3">Member since {{ $job->clientProfile->created_at->format('Y') }}</p>
                
                @if($job->clientProfile->website_url)
                    <a href="{{ $job->clientProfile->website_url }}" target="_blank" class="btn btn-outline-secondary btn-sm w-100">
                        Visit Website
                    </a>
                @endif
            </div>
        </div>

        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body">
                <h6 class="fw-bold">Job Budget</h6>
                <h3 class="fw-bold text-dark mb-0">${{ number_format($job->budget, 2) }}</h3>
                <small class="text-muted">{{ ucfirst($job->type) }}</small>
            </div>
        </div>
    </div>
</div>
@endsection