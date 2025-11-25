@extends('layouts.app')

@section('title', 'My Contracts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">My Contracts</h2>
</div>

<!-- Active Contracts -->
<div class="card shadow-sm border-0 mb-5">
    <div class="card-header bg-success-subtle text-success fw-bold py-3">
        Active Contracts
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Job Title</th>
                        <th>Client</th>
                        <th>Start Date</th>
                        <th>Price</th>
                        <th>Status</th>
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
                        <td><span class="badge bg-success">Active</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">You have no active contracts.</td>
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
        Work History
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Job Title</th>
                        <th>Client</th>
                        <th>End Date</th>
                        <th>Final Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pastContracts as $contract)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $contract->job->title }}</td>
                        <td>{{ $contract->job->clientProfile->user->name }}</td>
                        <td>{{ $contract->end_date ?? 'N/A' }}</td>
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
                        <td colspan="5" class="text-center py-4 text-muted">No past contracts found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection