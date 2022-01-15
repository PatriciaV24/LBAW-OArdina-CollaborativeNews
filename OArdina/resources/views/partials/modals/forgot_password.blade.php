<div class="modal fade text-white" id="forgotPassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-light-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="Forgot-modal-label">Esqueci Palavra-Passe</h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <p> Insira o meu email e irá receber um email com instruções para proceder à alteração da palavra-passe.</p>
                </div>
                <div class="mb-3">
                <form method="POST" action="{{route('forgot-password')}}">
                    {{ csrf_field() }}
                    <div class="form mb-3">
                        <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email" value="{{ old('email') }}" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </form>
            </div>
        </div>
    </div>
</div>
