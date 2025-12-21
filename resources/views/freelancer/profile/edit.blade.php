@extends('layouts.app')

@section('title', __('freelancer.edit_profile'))

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h4 class="fw-bold mb-0">{{ __('freelancer.edit_profile') }}</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('freelancer.profile.update') }}" method="POST">
                    @csrf
                    
                    {{-- Professional Details --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('freelancer.professional_headline') }}</label>
                        <input type="text" name="headline" class="form-control" value="{{ old('headline', $profile->headline) }}" placeholder="{{ __('freelancer.headline_placeholder') }}">
                        @error('headline') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('freelancer.hourly_rate') }} (Rp)</label>
                            <input type="number" name="rate_per_hour" class="form-control" value="{{ old('rate_per_hour', $profile->rate_per_hour) }}" step="0.01">
                            @error('rate_per_hour') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('freelancer.portfolio_url') }}</label>
                            <input type="url" name="portfolio_url" class="form-control" value="{{ old('portfolio_url', $profile->portfolio_url) }}" placeholder="https://...">
                            @error('portfolio_url') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Contact Information (NEW) --}}
                    <h6 class="mt-4 mb-3 text-uppercase small text-muted fw-bold">Contact Details (Shared with clients after hiring)</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Contact Email</label>
                            <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $profile->contact_email) }}" placeholder="Public email for work">
                            @error('contact_email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Phone / WhatsApp</label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $profile->contact_phone) }}" placeholder="+62...">
                            @error('contact_phone') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Bio --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('freelancer.bio_summary') }}</label>
                        <textarea name="bio" rows="6" class="form-control">{{ old('bio', $profile->bio) }}</textarea>
                        @error('bio') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('freelancer.profile.show') }}" class="btn btn-light">{{ __('client.cancel') }}</a>
                        <button type="submit" class="btn btn-primary px-4">{{ __('freelancer.save_changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection