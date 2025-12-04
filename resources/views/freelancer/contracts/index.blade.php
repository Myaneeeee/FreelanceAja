@extends('layouts.app')

@section('title', __('freelancer.my_contracts'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">{{ __('freelancer.my_contracts') }}</h2>
</div>

<!-- Active Contracts -->
<div class="card shadow-sm border-0 mb-5">
    <div class="card-header bg-success-subtle text-success fw-bold py-3">
        {{ __('freelancer.active_contracts') }}
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">{{ __('client.job') }}</th>
                        <th>{{ __('freelancer.client') }}</th>
                        <th>{{ __('freelancer.start_date') }}</th>
                        <th>{{ __('freelancer.price') }}</th>
                        <th>{{ __('client.status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activeContracts as $contract)
                    <tr>
                        <td class="ps-4 fw-bold">
                            <a href="{{ route('freelancer.jobs.show', $contract->job_id) }}" class="text-decoration-none">
                                {{ $contract->job->title }}
                            </a>
                        </td>
                        <td>{{ $contract->job->clientProfile->user->name }}</td>
                        <td>{{ $contract->start_date }}</td>
                        <td class="fw-bold">${{ number_format($contract->final_price, 2) }}</td>
                        <td><span class="badge bg-success">{{ __('freelancer.active_contracts') }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">{{ __('freelancer.no_active_contracts') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Contract History -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-light fw-bold py-3">
        {{ __('freelancer.work_history') }}
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">{{ __('client.job') }}</th>
                        <th>{{ __('freelancer.client') }}</th>
                        <th>{{ __('freelancer.end_date') }}</th>
                        <th>{{ __('freelancer.final_price') }}</th>
                        <th>{{ __('client.status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pastContracts as $contract)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $contract->job->title }}</td>
                        <td>{{ $contract->job->clientProfile->user->name }}</td>
                        <td>{{ $contract->end_date ?? __('freelancer.n_a') }}</td>
                        <td>${{ number_format($contract->final_price, 2) }}</td>
                        <td>
                            <span class="badge 
                                {{ $contract->status == 'completed' ? 'bg-secondary' : 'bg-danger' }}">
                                {{ ucfirst($contract->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">{{ __('freelancer.no_past_contracts') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection