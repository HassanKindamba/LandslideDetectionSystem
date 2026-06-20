@extends('layouts.admin')

@section('content')

<div class="container py-4">

    <h2 class="mb-4">My Profile</h2>

    <div class="row g-4">

        <!-- Update Profile Info -->
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    Profile Information
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <!-- Update Password -->
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    Update Password
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="col-md-12">
            <div class="card shadow-sm border-danger">
                <div class="card-header bg-danger text-white">
                    Delete Account
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

    </div>

</div>

@endsection