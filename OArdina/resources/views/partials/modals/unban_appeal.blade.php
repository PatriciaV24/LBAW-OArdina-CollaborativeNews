
<div class="modal fade text-black" id="unban" tabindex="-1"
    aria-labelledby="Unban-modal-label" aria-hidden="true">


<div class="modal-dialog text-black">
    <div class="modal-content bg-light text-black">
        <div class="modal-header">
            <h5 class="modal-title text-black" id="Unban-modal-label">
                Pedido de remoção de banição
            </h5>
            <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal"
                aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <form method="post" action="/user/{{auth()->user()->username}}/unban_appeal/" enctype="multipart/form-data">

            {{ csrf_field() }}
            <div class="mb-3">
                <label for="Unban-modal-description" class="form-label">
                    Explique porque deve ter a banição removida:
                </label>
                
                <textarea name="body" id="Report-modal-description" class="input form-control" role="textbox"
                    rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submeter</button>
            </form>
        </div>

    </div>
</div>
</div>
