@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">{{ __('client.company_profile') }}</h2>
                <a href="{{ route('client.profile.edit') }}" class="btn btn-outline-primary">
                    <i class="bi bi-pencil me-1"></i> {{ __('client.edit_profile') }}
                </a>
            </div>

            @if (session('status'))
                <div class="alert alert-success border-0 shadow-sm mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                </div>
            @endif

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start">
                        <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-4"
                            style="width: 80px; height: 80px; font-size: 2rem;">
                            {{ substr($client->company_name ?? Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="fw-bold mb-1">{{ $client->company_name }}</h3>
                            <p class="text-muted mb-2">{{ __('client.client_account') }}</p>
                            @if ($client->website_url)
                                <a href="{{ $client->website_url }}" target="_blank" class="text-decoration-none">
                                    <i class="bi bi-link-45deg"></i> {{ $client->website_url }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <h5 class="fw-bold mb-3">{{ __('client.about_company') }}</h5>
                    <p class="text-secondary" style="white-space: pre-line;">
                        {{ $client->company_description ?? __('client.no_description_added') }}
                    </p>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">{{ __('client.contact_information') }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-light border mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        <small>{{ __('client.details_shared_with_freelancers') }}
                            <strong>{{ __('client.only_after') }}</strong> {{ __('client.you_hire_them') }}.</small>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="text-uppercase text-muted small fw-bold">{{ __('client.contact_email') }}</label>
                            <p class="fs-5 text-dark mb-0">
                                {{ $client->contact_email ?? 'Not set' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-uppercase text-muted small fw-bold">{{ __('client.phone_number') }}</label>
                            <p class="fs-5 text-dark mb-0">
                                {{ $client->contact_phone ?? 'Not set' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
