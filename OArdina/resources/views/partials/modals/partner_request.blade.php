<div class="modal fade text-white" id="askForPartner" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-light-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="Report-modal-label">Ask for Partner</h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/partner_request">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <p>Please tell us why you would be a great partner:</p>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                        <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="I should become a partner because..." required></textarea>
                    </div>
                    </div>
                    
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        
        </div>
    </div>
</div>
