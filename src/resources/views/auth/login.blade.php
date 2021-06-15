@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card shadow p-3">
                <div class="card-body">
                    <main class="form-signin">
                        <form method="POST" id="login-form">
                            <h1 class="h3 mb-3 fw-normal">Sign in</h1>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" placeholder="name@example.com">
                                <label for="email">Email address</label>

                                <div class="invalid-feedback text-start" id="invalid-feedback-email">
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" placeholder="Password">
                                <label for="password">Password</label>

                                <div class="invalid-feedback text-start" id="invalid-feedback-password">
                                </div>
                            </div>

                            <div class="d-block">
                                <div class="float-start">
                                    <div class="checkbox mb-3">
                                        <label>
                                            <input type="checkbox" v-model="remember"> Remember me
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