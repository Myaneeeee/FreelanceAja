@extends('layouts.app')
@section('title', 'Edit Client Profile')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3"><h5 class="fw-bold mb-0">Edit Profile</h5></div>
            <div class="card-body p-4">
                <form action="{{ route('client.profile.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $client->company_name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="company_description" class="form-control" rows="3">{{ old('company_description', $client->company_description) }}</textarea>
                    </div>
                    
                    <h6 class="mt-4 mb-3 text-uppercase small text-muted fw-bold">Contact Details (Shared with hired freelancers)</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Contact Email</label>
                            <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $client->contact_email) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $client->contact_phone) }}">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection