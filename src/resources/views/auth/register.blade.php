@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card shadow p-3">
                <div class="card-body">
                    <main class="form-signin">
                        <form method="POST" id="register-form" autocomplete="off">
                            @csrf
                            <h1 class="h3 mb-3 fw-normal">Create an Account</h1>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="name" placeholder="name">
                                <label for="name">Name</label>

                                <div class="invalid-feedback text-start" id="invalid-feedback-name"></div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" placeholder="name@example.com">
                                <label for="email">Email address</label>


                                <div class="invalid-feedback text-start" id="invalid-feedback-email">
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" placeholder="Password">
                                <label for="password">Password</label>

                                <div class="invalid-feedback text-start" id="invalid-feedback-password"></div>
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