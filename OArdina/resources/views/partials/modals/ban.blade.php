<div class="modal fade text-white" id="banUser_{{ $user_id }}" tabindex="-1"
     aria-labelledby="Report-modal-label" aria-hidden="true">
    <div class="modal-dialog text-white">
        <div class="modal-content bg-light-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="Report-modal-label">Ban form</h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/user/{{ $user_id }}/ban/">
                    {{ csrf_field() }}
                    <div class="mb-2">
                        <label for="Report-{{ $user_id }}-modal-description" class="form-label">Reason to Ban</label>
                        <textarea 
                            name="reason" 
                            id="Report-{{ $user_id }}-modal-description" 
                            class="input form-control" 
                            role="textbox" 
                            rows="3"
                        ></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="Report-{{ $user_id }}-modal-date" class="form-label">Ban Until</label>
                        <input name="end_date" id="Report-{{ $user_id }}-modal-date" class="input form-control" disabled type="date"/>
                        <input 
                            name="end_date_forever" 
                            id="Report-{{ $user_id }}-modal-date-forever" 
                            class="input" 
                            type="checkbox"
                            onclick="toggleEndDate(this, {{$user_id}})" 
                            checked
                        /> Forever
                    </div>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

@once
    <script defer src="{{ asset('js/ban.js') }}"></script>
@endonce
