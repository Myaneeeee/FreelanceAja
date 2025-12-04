@extends('layouts.app')

@section('title', __('freelancer.my_profile'))

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm border-0 overflow-hidden">
            <!-- Cover / Header -->
            <div class="bg-primary p-5 text-center text-white">
                <div class="bg-white text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: bold;">
                    {{ substr($profile->user->name, 0, 1) }}
                </div>
                <h2 class="fw-bold">{{ $profile->user->name }}</h2>
                <p class="mb-0 opacity-75">{{ $profile->user->email }}</p>
            </div>
            
            <div class="card-body p-5">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h4 class="fw-bold text-primary">{{ $profile->headline ?? __('freelancer.no_headline') }}</h4>
                        <h5 class="text-muted">${{ number_format($profile->rate_per_hour, 2) }} / hr</h5>
                    </div>
                    <a href="{{ route('freelancer.profile.edit') }}" class="btn btn-outline-primary">
                        {{ __('freelancer.edit_profile') }}
                    </a>
                </div>

                <hr>

                <div class="mb-4">
                    <h5 class="fw-bold mb-3">{{ __('freelancer.about_me') }}</h5>
                    @if($profile->bio)
                        <p class="text-secondary" style="white-space: pre-line;">{{ $profile->bio }}</p>
                    @else
                        <p class="text-muted fst-italic">{{ __('freelancer.no_bio') }}</p>
                    @endif
                </div>

                <div class="mb-4">
                    <h5 class="fw-bold mb-3">{{ __('freelancer.skills') }}</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @forelse($profile->skills as $skill)
                            <span class="badge bg-light text-dark border px-3 py-2">{{ $skill->name }}</span>
                        @empty
                            <span class="text-muted fst-italic">{{ __('freelancer.no_skills') }} <a href="{{ route('freelancer.skills.edit') }}">{{ __('freelancer.add_skills') }}</a></span>
                        @endforelse
                    </div>
                </div>

                @if($profile->portfolio_url)
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">{{ __('freelancer.portfolio') }}</h5>
                    <a href="{{ $profile->portfolio_url }}" target="_blank" class="text-decoration-none fw-bold">
                        {{ __('freelancer.visit_portfolio') }} &rarr;
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection