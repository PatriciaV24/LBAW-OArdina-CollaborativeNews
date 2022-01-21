<div class="modal fade text-black" 
     id="editComment_{{$comment->content_id}}" 
     tabindex="-1" 
     aria-labelledby="deletePost-modal-label" 
     aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-light text-black">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="deletePost-modal-label">Editar comentário</h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="post" action="/comment/{{$comment->content_id}}/">
                @method('patch')
                {{csrf_field()}}
                <div class="mb-3">
                    <label for="editComment-modal-description_{{$comment->content_id}}" class="form-label">
                        Editar comentário
                    </label>
                    <textarea id="editComment-modal-description_{{$comment->content_id}}" 
                              name="body" 
                              class="input form-control" 
                              role="textbox" 
                              rows="3" 
                              contenteditable aria-multiline="true">
                                {{$comment->content->body}}
                    </textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submeter</button>
                </form>
            </div>

        </div>
    </div>
</div>
