<div class="modal fade text-white" id="deleteAccount" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-light-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title text-white">Delete Account</h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/delete_user" class="g-3">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <p>Do you wish to delete your account?</p>
                        <p class="small">Your profile, posts and comments will be hidden. You can recover your account at any time by loggin in.</p>
                    </div>
                    <div class=" mb-3">
                        <label for="inputOldPassword">Password*</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </form>
            </div>
        </div>
    </div>
</div>
