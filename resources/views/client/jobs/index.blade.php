@extends('layouts.app')

@section('title', 'My Jobs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">My Job Postings</h2>
    <a href="{{ route('client.jobs.create') }}" class="btn btn-primary">+ Post Job</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4" style="width: 40%;">Job Title</th>
                        <th>Created</th>
                        <th>Budget</th>
                        <th>Proposals</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold d-block">{{ $job->title }}</span>
                            <small class="text-muted text-truncate d-block" style="max-width: 300px;">{{ Str::limit($job->description, 50) }}</small>
                        </td>
                        <td>{{ $job->created_at->format('M d, Y') }}</td>
                        <td>${{ number_format($job->budget) }}</td>
                        <td>
                            @if($job->new_proposals_count > 0)
                                <span class="badge bg-danger rounded-pill">{{ $job->new_proposals_count }} New</span>
                            @endif
                            <span class="text-muted small ms-1">{{ $job->proposals_count }} Total</span>
                        </td>
                        <td>
                            @if($job->status == 'open')
                                <span class="badge bg-success-subtle text-success">Open</span>
                            @elseif($job->status == 'in_progress')
                                <span class="badge bg-primary-subtle text-primary">In Progress</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($job->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('client.jobs.proposals', $job->id) }}" class="btn btn-sm btn-outline-primary">
                                Manage
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <p class="text-muted mb-2">You haven't posted any jobs yet.</p>
                            <a href="{{ route('client.jobs.create') }}" class="btn btn-sm btn-primary">Create Your First Job</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $jobs->links() }}
</div>
@endsection