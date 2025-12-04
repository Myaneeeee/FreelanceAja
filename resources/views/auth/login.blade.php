@extends('layouts.app')

@section('title', __('auth.login'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <h3 class="text-center mb-4">{{ __('auth.login') }}</h3>
        
        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">{{ __('auth.email_address') }}</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('auth.password') }}</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">{{ __('auth.sign_in') }}</button>
            </div>
            
            <div class="text-center mt-3">
                <a href="{{ route('register') }}">{{ __('auth.dont_have_account') }} {{ __('auth.register_link') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection