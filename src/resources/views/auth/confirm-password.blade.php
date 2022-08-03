@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card shadow p-3">
                <div class="card-body">
                    <main class="auth-form">
                        <form method="POST" id="confirm-password-form" action="{{ route('confirmed.authenticate') }}">
                            @csrf
                            <h3 class="mb-3 fw-normal text-center">Confirm Password</h3>

                            <div class="form-floating mb-2">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="confirm-password" placeholder="Confirm Password" name="password" autofocus>
                                <label for="confirm-password">Password</label>

                                @error('password')
                                <div class="invalid-feedback text-start">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="auth-msg mb-2">
                                <small>
                                    <p class="m-0">
                                        You need to confirm your password for two factor authentication. </p>
                                
                                    <p class="m-0">
                                        We won't asked for your password for a few hours once confirmed.
                                    </p>
                                </small>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3"
                                id="submit-confirm-password">Confirm Password
                            </button>
                        </form>
                    </main>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection