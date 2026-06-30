<x-guest-layout>

<style>
    :root {
        --primary-blue: #0d47a1;
        --light-blue: #1976d2;
        --accent-green: #2e7d32;
        --light-green: #66bb6a;
        --soft-white: #f8f9fa;
    }

    body {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--accent-green) 100%);
        min-height: 100vh;
    }

    .login-card {
        background-color: var(--soft-white);
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        overflow: hidden;
        max-width: 420px;
        margin: 60px auto;
    }

    .login-header {
        background: linear-gradient(90deg, var(--primary-blue), var(--light-blue));
        color: #fff;
        padding: 10px 20px;
        text-align: center;
        margin-top:20px;
        margin-bottom:20px;
        margin-left:20px;
        margin-right:20px;
        border-radius:12px;
    }

    .login-header h1 {
        font-size: 1.4rem;
        margin: 0;
        font-weight: 600;
    }

    .login-body {
        padding: 30px;
    }

    .form-label {
        font-weight: 500;
        color: var(--primary-blue);
    }

    .form-control:focus {
        border-color: var(--accent-green);
        box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
    }

    .form-control {
        width: 100%;
        border-radius: 10px;
        padding: 10px 14px;
        border: 1px solid #ced4da;
    }

    .form-control:focus {
        border-color: var(--accent-green);
        box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
    }

        .login-card {
        ...
        width: 100%;
    }

    .btn-success-custom {
        background-color: var(--accent-green);
        border: none;
        color: #fff;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 8px;
        transition: background 0.3s ease;
    }

    .btn-success-custom:hover {
        background-color: var(--light-green);
        color: #fff;
    }

    .forgot-link {
        color: var(--light-blue);
        text-decoration: none;
        font-size: 0.9rem;
    }

    .forgot-link:hover {
        color: var(--accent-green);
        text-decoration: underline;
    }

    .form-check-input:checked {
        background-color: var(--accent-green);
        border-color: var(--accent-green);
    }
</style>

<div class="container">
    <div class="login-card">
        <div class="login-header">
            <h1>Login to access admin dashboard</h1>
        </div>

        <div class="login-body">

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email')" class="form-label" />
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="form-control" placeholder="Enter your email">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-danger small" />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-input-label for="password" :value="__('Password')" class="form-label" />
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="form-control" placeholder="Enter your password">
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-danger small" />
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label class="form-check-label" for="remember_me">
                        {{ __('Remember me') }}
                    </label>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <button type="submit" class="btn btn-success-custom">
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

</x-guest-layout>