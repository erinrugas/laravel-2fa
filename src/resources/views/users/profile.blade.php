@extends('layouts.app')

@section('content')
<div class="row mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Profile
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="fw-bold">Personal Information</h5>
                        <p><small>Update your personal information</small></p>

                        @if (session()->has('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
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

                            <div class="float-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h5 class="fw-bold">Two Factor Authentication</h5>
                        <p><small>Additional layer of security to your account.</small></p>
                    </div>
                    <div class="col-md-6">
                        <p>
                            <small>
                                Once two factor authentication is enable. During authentication, you will need your recovery code or authenticator app.
                            </small>
                        </p>

                        @if (is_null(auth()->user()->two_factor_recovery_code) && is_null(auth()->user()->two_factor_secret))
                            <form action="{{ route('profile.enable-two-factor') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-dark">Enable two factor authentication</button>
                            </form>
                        @else
                            @if (session()->has('enable_two_factor'))
                                <p>
                                    <small>
                                        Scan this QR code using any authenticator app such as Google Authenticator and Microsoft Authenticator
                                        You will be needed this during your authentication
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

                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('profile.show-recovery-code') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-dark show-recovery-code">Show Recovery Code</button>
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