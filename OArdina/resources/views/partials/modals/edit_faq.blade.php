<div class="modal fade text-black" 
     id="editFAQ_{{$topic->id}}" 
     tabindex="-1" 
     aria-labelledby="editModalLabel" 
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content bg-light-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar FAQ</h5>
                <button type="button" class="btn-close text-black" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/faq/{{$topic->id}}/" enctype="multipart/form-data">
                    @method('patch')
                    {{csrf_field()}}
                    <div class="mb-3">
                        <label for="faq_question_{{$topic->id}}"" class="col-form-label">Questão:</label>
                        <input id="faq_question_{{$topic->id}}" 
                               name="question" 
                               type="text" 
                               class="form-control" 
                               value="{{$topic->question}}">
                    </div>
                    <div class="mb-3">
                        <label for="faq_answer_{{$topic->id}}" class="col-form-label">
                            Resposta:
                        </label>
                        <textarea id="faq_answer_{{$topic->id}}" 
                                  name="answer" 
                                  class="form-control">
                                  {{$topic->answer}}
                        </textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>