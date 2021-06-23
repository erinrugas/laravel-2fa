@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card shadow p-3">
                <div class="card-body">
                    <main class="auth-form">
                        <form method="POST" id="search-form" action="{{ route('password.update') }}">
                            @csrf
                            @method("PUT")
                            <h3 class="mb-3 fw-normal">Reset Password</h3>

                            @if (session()->has('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                            @endif
                            <input type="hidden" name="token" value="{{ request()->route('token') }}">

                            <div class="form-floating mb-2">
                                <input type="hidden" class="form-control @error('email') is-invalid @enderror" id="email"
                                    placeholder="Email" name="email" value="{{ request('email') }}">
                                <label for="email">Email</label>

                                @error('email')
                                    <div class="invalid-feedback text-start">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-floating mb-2">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="New Password"
                                    name="password">
                                <label for="password">New Password</label>
                            
                                @error('password')
                                <div class="invalid-feedback text-start">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-floating mb-2">
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password-confirmation"
                                    placeholder="Confirm Password" name="password_confirmation" >
                                <label for="password-confirmation">Confirm Password</label>
                            
                                @error('password_confirmation')
                                    <div class="invalid-feedback text-start">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3" id="submit-reset-password">
                                Submit
                            </button>
                        </form>
                    </main>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection