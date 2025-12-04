@extends('layouts.app')

@section('title', __('auth.register'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="text-center mb-4 fw-bold">{{ __('auth.create_account') }}</h3>
                
                <form method="POST" action="{{ route('register.submit') }}">
                    @csrf
                    
                    {{-- Role Selection --}}
                    <div class="mb-4 p-3 bg-light rounded border">
                        <label class="form-label fw-bold mb-2">{{ __('auth.i_want_to') }}</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="role_freelancer" value="freelancer" {{ old('role', 'freelancer') == 'freelancer' ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_freelancer">
                                    {{ __('auth.work_as_freelancer') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="role_client" value="client" {{ old('role') == 'client' ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_client">
                                    {{ __('auth.hire_for_project') }}
                                </label>
                            </div>
                        </div>
                        @error('role') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('auth.full_name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus placeholder="{{ __('auth.placeholder_name') }}">
                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('auth.email_address') }}</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="{{ __('auth.placeholder_email') }}">
                        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('auth.password') }}</label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('auth.confirm_password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">{{ __('auth.create_account_btn') }}</button>
                    </div>

                    <div class="text-center mt-3">
                        <span class="text-muted">{{ __('auth.already_have_account') }}</span> 
                        <a href="{{ route('login') }}" class="text-decoration-none">{{ __('auth.login_link') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection