@extends('layouts.app')

@section('content')
<div class="row mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-dark text-white h5">
                Personal Information
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Update your personal information</h6>

                        @if (session()->has('profile'))
                            <div class="alert alert-success">{{ session('profile') }}</div>
                        @endif

                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{ auth()->user()->name }}" name="name">
                                <label for="name">Name</label>

                                @error('name')
                                    <div class="invalid-feedback text-start">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    placeholder="name@example.com" value="{{ auth()->user()->email }}" name="email">
                                <label for="email">Email address</label>

                                @error('email')
                                    <div class="invalid-feedback text-start">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary w-100">Update Personal Information</button>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6>Update your password</h6>
                        
                        @if (session()->has('password'))
                            <div class="alert alert-success">{{ session('password') }}</div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('profile.update.password') }}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password"
                                    placeholder="New Password" name="new_password">
                                <label for="new-password">New Password</label>
                        
                                @error('new_password')
                                <div class="invalid-feedback text-start">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" id="confirm-password"
                                    placeholder="Confirm Password" name="new_password_confirmation">
                                <label for="confirm-password">Confirm Password</label>
                            
                                @error('new_password_confirmation')
                                <div class="invalid-feedback text-start">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary w-100">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="card mt-3">
            <div class="card-header bg-dark text-white h5">
                Two Factor Authentication
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Additional layer of security to your account.</h6>
                    </div>
                    <div class="col-md-6">
                        

                        @if (is_null(auth()->user()->two_factor_recovery_code) && is_null(auth()->user()->two_factor_secret))
                            <p>
                                <small>
                                    Once two factor authentication is enable. 
                                    You will need your recovery code or authenticator app for authentication.
                                </small>
                            </p>

                            <form action="{{ route('profile.enable-two-factor') }}" method="POST">
                                @csrf
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary w-100">Enable Two Factor Authentication</button>
                                </div>
                            </form>
                            
                        @else
                            @if (session()->has('enable_two_factor'))
                                <p>
                                    <small>
                                        Scan this QR code using any authenticator app such as Google Authenticator and Microsoft Authenticator
                                        You will be needed this during your authentication.
                                    </small>
                                </p>

                                <div class="text-center">
                                    {!! auth()->user()->twoFactorQRImg() !!}
                                </div>

                                @include('users.recovery-code.recovery-code')

                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('profile.disable-recovery-code') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Disable Two Factor Authenticator</button>
                                    </form>

                                    <form action="{{ route('profile.generate-recovery-code') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Generate New Recovery Code</button>
                                    </form>
                                </div>

                            @elseif (session()->has('show_two_factor'))

                                @include('users.recovery-code.recovery-code')
                                
                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('profile.disable-recovery-code') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Disable Two Factor Authenticator</button>
                                    </form>

                                    <form action="{{ route('profile.generate-recovery-code') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Generate New Recovery Code</button>
                                    </form>
                                </div>

                            @else
                                <p >
                                    <small>
                                        Two factor authentication is enabled.
                                    </small>
                                </p>
                                <div class="col-md-12">
                                    <form action="{{ route('profile.show-recovery-code') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary show-recovery-code w-100">
                                            Show Recovery Code
                                        </button>
                                    </form>
                                </div>

                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection