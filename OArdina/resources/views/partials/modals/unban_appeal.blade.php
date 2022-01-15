
<div class="modal fade text-white" id="unban" tabindex="-1"
    aria-labelledby="Unban-modal-label" aria-hidden="true">


<div class="modal-dialog text-white">
    <div class="modal-content bg-light-dark text-white">
        <div class="modal-header">
            <h5 class="modal-title text-white" id="Unban-modal-label">Unban Appeal form</h5>
            <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal"
                aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <form method="post" action="/user/{{auth()->user()->username}}/unban_appeal/" enctype="multipart/form-data">

            {{ csrf_field() }}
            <div class="mb-3">
                <label for="Unban-modal-description" class="form-label">Explain us why you should be unbanned</label>
                <textarea name="body" id="Report-modal-description" class="input form-control" role="textbox"
                    rows="4"></textarea>
            </div>

            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

    </div>
</div>
</div>
