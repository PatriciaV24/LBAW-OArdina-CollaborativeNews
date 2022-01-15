<div class="modal fade text-white" id="editFAQ_{{$topic->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content bg-light-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit FAQ</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/faq/{{$topic->id}}/" enctype="multipart/form-data">
                    @method('patch')
                    {{csrf_field()}}
                    <div class="mb-3">
                        <label for="faq_question_{{$topic->id}}"" class="col-form-label">Question:</label>
                        <input id="faq_question_{{$topic->id}}" name="question" type="text" class="form-control" value="{{$topic->question}}">
                    </div>
                    <div class="mb-3">
                        <label for="faq_answer_{{$topic->id}}" class="col-form-label">Answer:</label>
                        <textarea id="faq_answer_{{$topic->id}}" name="answer" class="form-control">{{$topic->answer}}</textarea>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>