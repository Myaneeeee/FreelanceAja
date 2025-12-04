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
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('freelancer.professional_headline') }}</label>
                        <input type="text" name="headline" class="form-control" value="{{ old('headline', $profile->headline) }}" placeholder="{{ __('freelancer.headline_placeholder') }}">
                        @error('headline') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('freelancer.hourly_rate') }}</label>
                        <input type="number" name="rate_per_hour" class="form-control" value="{{ old('rate_per_hour', $profile->rate_per_hour) }}" step="0.01">
                        @error('rate_per_hour') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('freelancer.portfolio_url') }}</label>
                        <input type="url" name="portfolio_url" class="form-control" value="{{ old('portfolio_url', $profile->portfolio_url) }}" placeholder="{{ __('freelancer.portfolio_placeholder') }}">
                        @error('portfolio_url') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ __('freelancer.bio_summary') }}</label>
                        <textarea name="bio" rows="6" class="form-control">{{ old('bio', $profile->bio) }}</textarea>
                        @error('bio') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('freelancer.profile.show') }}" class="btn btn-light">{{ __('client.cancel') }}</a>
                        <button type="submit" class="btn btn-primary">{{ __('freelancer.save_changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection