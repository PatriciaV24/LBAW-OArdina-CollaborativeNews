<div class="modal fade text-black" 
     id="deleteAccount" 
     tabindex="-1" 
     aria-hidden="true">

    <div class="modal-dialog text-black">
        <div class="modal-content bg-light text-black">
            <div class="modal-header">
                <h5 class="modal-title text-black">Eliminar conta</h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/delete_user" class="g-3">
                    {{ csrf_field() }}
                    
                    <div class="mb-3">
                        <p>Tem a certeza deque pretende eliminar a sua conta?</p>
                        <p class="small">O seu perfil, publicaçẽs e comentarios ficarão ocultos. Pode recuperá-los fazendo login.</p>
                    </div>
                    <div class=" mb-3">
                        <label for="inputOldPassword">Password *</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar conta</button>
                </form>
            </div>
        </div>
    </div>
</div>
