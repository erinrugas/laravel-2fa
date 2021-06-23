@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card shadow p-3">
                <div class="card-body">
                    <main class="auth-form">
                        <form method="POST" id="register-form" autocomplete="off"
                            action="{{ route('register.store') }}">
                            @csrf
                            <h3 class="mb-3 fw-normal">Create an Account</h3>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    placeholder="name" name="name" value="{{ old('name') }}">
                                <label for="name">Name</label>

                                @error('name')
                                <div class="invalid-feedback text-start" id="invalid-feedback-name">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    placeholder="name@example.com" name="email" value="{{ old('email') }}">
                                <label for="email">Email address</label>

                                @error('email')
                                <div class="invalid-feedback text-start" id="invalid-feedback-email">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" placeholder="Password" name="password">
                                <label for="password">Password</label>

                                @error('password')
                                <div class="invalid-feedback text-start" id="invalid-feedback-password">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3" id="submit-register">Sign
                                up</button>

                            Have an account? <a class="w-100" href="/login">Sign in</a>
                            <p class="mt-2 text-muted">&copy; {{ config('app.name') }}
                                {{ \Carbon\Carbon::now()->format('Y') }}</p>
                        </form>
                    </main>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection