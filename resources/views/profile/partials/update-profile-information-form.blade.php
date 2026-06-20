@extends('layouts.admin')

@section('page-title', 'My Profile')
@section('page-subtitle', 'Manage your account settings and profile information')

@section('styles')
<style>
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06) !important;
    }

    .card-header {
        border-bottom: 1px solid #eef1f5;
        border-radius: 12px 12px 0 0 !important;
        padding: 18px 22px;
    }

    .card-header h5 {
        font-weight: 700;
    }

    .card-body {
        padding: 25px;
    }

    .form-label {
        font-weight: 500;
        color: #444;
        font-size: 0.9rem;
    }

    .form-control {
        border-radius: 8px;
        padding: 10px 14px;
        border: 1px solid #dde3ea;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.15);
    }

    .btn-primary {
        border-radius: 8px;
        font-weight: 600;
        padding: 9px 26px;
    }

    .text-success {
        font-weight: 500;
    }

    .alert-warning {
        border: none;
        border-left: 4px solid #f0ad4e;
        border-radius: 8px;
        background: #fff8ec;
    }
</style>
@endsection

@section('content')
<section>

    <!-- PROFILE INFORMATION -->
    <div class="card mb-4">

        <div class="card-header bg-white">
            <h5 class="mb-0">Profile Information</h5>
            <small class="text-muted">
                Update your account's profile information and email address.
            </small>
        </div>

        <div class="card-body">

            <!-- Send verification -->
            <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <!-- FORM -->
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <!-- Name -->
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}"
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="alert alert-warning mt-3">
                            Your email is not verified.

                            <button form="send-verification" class="btn btn-link p-0">
                                Resend verification email
                            </button>

                            @if (session('status') === 'verification-link-sent')
                                <div class="text-success mt-2">
                                    Verification link sent.
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- SAVE -->
                <button type="submit" class="btn btn-primary" style="background-color: green; border-color: green;">
                    Save
                </button>

                @if (session('status') === 'profile-updated')
                    <span class="text-success ms-2">Saved.</span>
                @endif

            </form>

        </div>
    </div>

    <!-- UPDATE PASSWORD -->
    @include('profile.partials.update-password-form')

    <!-- DELETE ACCOUNT -->
    @include('profile.partials.delete-user-form')

</section>
@endsection