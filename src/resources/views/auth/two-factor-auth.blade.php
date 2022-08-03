@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card shadow p-3">
                <div class="card-body">
                    <main class="auth-form">
                        <form method="POST" id="login-form" action="{{ route('two-factor-authentication.validate') }}">
                            @csrf
                            <h3 class="mb-3 fw-normal text-center">Two Factor Authentication</h3>
                            
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control @error('two_factor_auth') is-invalid @enderror" 
                                    id="two-factor-auth"
                                    placeholder="Two Factor Authentication" name="two_factor_auth">
                                <label for="two-factor-auth">Two Factor Authentication</label>

                                @error('two_factor_auth')
                                <div class="invalid-feedback text-start" id="invalid-feedback-two-factor-auth">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="auth-msg mb-2 text-center">
                                <small>
                                    <i>
                                        Enter the code from the authenticator app on your mobile device.
                                        <br>
                                        If you've lost your device, you may enter one of your
                                        recovery codes.
                                    </i>
                                </small>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3" id="submit-two-factor">Submit</button>
                        </form>
                    </main>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection