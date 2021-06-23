@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card shadow p-3">
                <div class="card-body">
                    <main class="form-signin">
                        <form method="POST" id="search-form" action="{{ route('forgot-password.search') }}">
                            @csrf
                            <h3 class="mb-3 fw-normal">Forgot Password</h3>
                            <div class="auth-msg mb-2">
                                <small>
                                    <i>
                                        Enter your email address you want to reset the password.
                                    </i>
                                </small>
                            </div>

                            @if (session()->has('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                            @endif

                            <div class="form-floating mb-2">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" placeholder="Email" name="email"
                                    value="{{ old('email') }}">
                                <label for="email">Email</label>

                                @error('email')
                                    <div class="invalid-feedback text-start">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3"
                                id="submit-forgot-password">Submit
                            </button>
                        </form>
                    </main>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection