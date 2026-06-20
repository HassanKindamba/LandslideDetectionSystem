<div class="card shadow-sm mb-4">

    <div class="card-header bg-white">
        <h5 class="mb-0">Update Password</h5>
        <small class="text-muted">
            Ensure your account is using a long, random password to stay secure.
        </small>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <!-- Current Password -->
            <div class="mb-3">
                <label class="form-label">Current Password</label>

                <input type="password"
                       name="current_password"
                       class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                       autocomplete="current-password">

                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- New Password -->
            <div class="mb-3">
                <label class="form-label">New Password</label>

                <input type="password"
                       name="password"
                       class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                       autocomplete="new-password">

                @error('password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>

                <input type="password"
                       name="password_confirmation"
                       class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                       autocomplete="new-password">

                @error('password_confirmation', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="d-flex align-items-center gap-3">

                <button type="submit" class="btn btn-primary" style="background-color: green; border-color: green;">
                    Save
                </button>

                @if (session('status') === 'password-updated')
                    <span class="text-success">
                        <i class="bi bi-check-circle-fill"></i> Saved.
                    </span>
                @endif

            </div>

        </form>

    </div>
</div>