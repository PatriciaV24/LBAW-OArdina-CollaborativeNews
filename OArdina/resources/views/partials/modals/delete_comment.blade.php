<div class="modal fade text-white" id="deletePostModal_{{$comment->content_id}}" tabindex="-1" aria-labelledby="deletePost-modal-label" aria-hidden="true">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-light-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="deletePost-modal-label">Delete Comment</h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="post" action="/comment/{{$comment->content_id}}/">
                @method('delete')
                {{csrf_field()}}
                <div class="mb-3">
                    <label for="deletePost-modal-description_{{$comment->content_id}}" class="form-label">Confirm by typing your password</label>
                    <input type="password" id="deletePost-modal-description_{{$comment->content_id}}" name="password" class="input form-control" role="textbox" rows="3" contenteditable aria-multiline="true">
                </div>

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

        </div>
    </div>
</div>
