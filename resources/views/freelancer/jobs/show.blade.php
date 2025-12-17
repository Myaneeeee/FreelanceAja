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
                    <span class="badge bg-primary me-2">{{ ucwords(str_replace('_', ' ', $job->type)) }}</span>
                    <span class="text-muted">{{ __('freelancer.posted') }} {{ $job->created_at->format('M d, Y') }}</span>
                </div>

                <h5 class="fw-bold mt-4">{{ __('freelancer.description') }}</h5>
                <p class="text-secondary" style="white-space: pre-line;">{{ $job->description }}</p>

                <h5 class="fw-bold mt-4">{{ __('freelancer.required_skills') }}</h5>
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
                <h5 class="alert-heading fw-bold">{{ __('freelancer.proposal_submitted') }}</h5>
                <p>{{ __('freelancer.already_applied') }} {{ $existingProposal->created_at->format('M d, Y') }}.</p>
                <hr>
                <p class="mb-0">{{ __('freelancer.current_status') }} <strong>{{ ucfirst($existingProposal->status) }}</strong></p>
            </div>
        @else
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white pt-4 px-4 border-bottom-0">
                    <h4 class="fw-bold">{{ __('freelancer.submit_proposal') }}</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('freelancer.jobs.proposals.submit', $job->id) }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('freelancer.proposal_bid_amount') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="bid_amount" class="form-control" value="{{ old('bid_amount', $job->budget) }}" step="0.01" required>
                                </div>
                                <small class="text-muted">{{ __('client.budget') }}: ${{ number_format($job->budget) }}</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('freelancer.cover_letter') }}</label>
                            <textarea name="cover_letter" rows="6" class="form-control" placeholder="{{ __('freelancer.cover_letter_placeholder') }}" required>{{ old('cover_letter') }}</textarea>
                            @error('cover_letter') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-light me-2">{{ __('client.cancel') }}</a>
                            <button type="submit" class="btn btn-primary px-4">{{ __('freelancer.submit') }}</button>
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
                <h5 class="fw-bold mb-3">{{ __('freelancer.about_client') }}</h5>
                <p class="fw-bold mb-1">{{ $job->clientProfile->company_name ?? __('freelancer.individual_client') }}</p>
                <p class="text-muted small mb-3">{{ __('freelancer.member_since') }} {{ $job->clientProfile->created_at->format('Y') }}</p>

                @if($job->clientProfile->website_url)
                    <a href="{{ $job->clientProfile->website_url }}" target="_blank" class="btn btn-outline-secondary btn-sm w-100">
                        {{ __('freelancer.visit_website') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body">
                <h6 class="fw-bold">{{ __('freelancer.job_budget') }}</h6>
                <h3 class="fw-bold text-dark mb-0">${{ number_format($job->budget, 2) }}</h3>
                <small class="text-muted">{{ ucwords(str_replace('_', ' ', $job->type)) }}</small>
            </div>
        </div>
    </div>
</div>
@endsection
