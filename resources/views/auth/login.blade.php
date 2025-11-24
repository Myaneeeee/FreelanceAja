@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <h3 class="text-center mb-4">Login</h3>
        
        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Sign In</button>
            </div>
            
            <div class="text-center mt-3">
                <a href="{{ route('register') }}">Don't have an account? Register</a>
            </div>
        </form>
    </div>
</div>
@endsection