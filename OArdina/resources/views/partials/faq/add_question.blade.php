<form class="my-3" method="post" action="/faq/" enctype="multipart/form-data">            
    {{ csrf_field() }}
    <legend>Add new question:</legend>
    <div class="mb-3">
        <label for="question" class="form-label">Question</label>
        <input type="text" class="form-control" name="question" id="question" aria-label="new question">
    </div>
    <div class="mb-3">
        <label for="answer" class="form-label">Answer</label>
        <textarea class="form-control" name="answer" id="answer" rows="4" aria-label="new answer"></textarea>
    </div>
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Add to FAQ</button>
    </div>    
</form>