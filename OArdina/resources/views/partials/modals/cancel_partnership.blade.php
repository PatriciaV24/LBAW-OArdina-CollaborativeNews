<div class="modal fade text-white" id="cancelPartnership" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-light-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title text-white">Cancel Partnership</h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/user/{{Auth::user()->username}}/stop_partnership" class="g-3">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <p>Do you wish to cancel your partnership with us?</p>
                    </div>
                    <div class=" mb-3">
                        <label for="password">Password*</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Back</button>
                    <button type="submit" class="btn btn-danger">Cancel Partnership</button>
                </form>
            </div>
        </div>
    </div>
</div>
