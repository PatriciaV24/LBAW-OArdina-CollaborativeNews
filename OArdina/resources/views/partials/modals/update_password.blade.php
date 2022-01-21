<div class="modal fade text-black"
     id="updatePassword" 
     tabindex="-1" 
     aria-hidden="true">

    <div class="modal-dialog modal-lg text-black">
        <div class="modal-content bg-light text-black">
            <div class="modal-header">
                <h5 class="modal-title text-black">Atualizar Password</h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="/update_password" class="g-3">
                    {{ csrf_field() }}
                    <div class=" mb-3">
                        <label for="inputOldPassword">Password Antiga *</label>
                        <input type="password" class="form-control" id="inputOldPassword" name="oldPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputNewPassword" class="form-label">Passoword Nova*</label>
                        <input type="password" class="form-control" id="inputNewPassword" name="newPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputConfirmNewPassword" class="form-label">Confirme Passoword Nova *</label>
                        <input type="password" class="form-control" id="inputConfirmNewPassword" name="confirmNewPassword" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submeter</button>
                </form>
            </div>
        </div>
    </div>
</div>
