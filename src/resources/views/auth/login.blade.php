@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card shadow p-3">
                <div class="card-body">
                    <main class="form-signin">
                        <form method="POST" id="login-form" action="{{ route('authenticate') }}">
                            @csrf
                            <h1 class="h3 mb-3 fw-normal">Sign in</h1>

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

                            <div class="d-block">
                                <div class="float-start">
                                    <div class="checkbox mb-3">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember me
                                        </label>
                                    </div>
                                </div>
                                <div class="float-end">
                                    <div class="checkbox mb-3">
                                        <a href="/forgot-password">Forgot Password</a>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3" id="submit-login">Sign in</button>

                            Don't have an account? <a class="w-100 " href="/register">Sign up</a>
                            <p class="mt-3 text-muted">&copy; {{ config('app.name') }}
                                {{ \Carbon\Carbon::now()->format('Y') }}</p>
                        </form>
                    </main>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection