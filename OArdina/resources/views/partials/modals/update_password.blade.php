<div class="modal fade text-white" id="updatePassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-light-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title text-white">Update Password</h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/update_password" class="g-3">
                    {{ csrf_field() }}
                    <div class=" mb-3">
                        <label for="inputOldPassword">Old password*</label>
                        <input type="password" class="form-control" id="inputOldPassword" name="oldPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputNewPassword" class="form-label">New password*</label>
                        <input type="password" class="form-control" id="inputNewPassword" name="newPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputConfirmNewPassword" class="form-label">Confirm new password*</label>
                        <input type="password" class="form-control" id="inputConfirmNewPassword" name="confirmNewPassword" required>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
