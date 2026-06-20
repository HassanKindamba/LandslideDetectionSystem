<div class="card shadow-sm border-danger mb-4">

    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">
            <i class="bi bi-exclamation-octagon me-2"></i>
            Delete Account
        </h5>
    </div>

    <div class="card-body">

        <p class="text-muted">
            Once your account is deleted, all related Landslide Detection System data including sensor logs, alerts history, and monitoring records will be permanently removed from the system.

            This action is irreversible. Please ensure you have exported or saved any important monitoring data before proceeding.
        </p>

        <!-- Trigger Button -->
        <button type="button"
                class="btn btn-danger"
                data-bs-toggle="modal"
                data-bs-target="#deleteAccountModal">

            <i class="bi bi-trash me-1"></i>
            Delete Account
        </button>

    </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirm Account Deletion</h5>

                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <p class="mb-2">
                        Are you sure you want to delete your account?
                        This action cannot be undone.
                    </p>

                    <p class="text-muted">
                        Enter your password to confirm.
                    </p>

                    <input type="password"
                           name="password"
                           class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                           placeholder="Password"
                           required>

                    @error('password', 'userDeletion')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Delete Account
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>