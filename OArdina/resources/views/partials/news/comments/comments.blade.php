<form action="/comment/create/" 
      class="container-xl mb-3 p-3 bg-light-dark" 
      method="post">
    @csrf

    <input name="news_id" type="hidden" value="{{$news->content_id}}">

    <div class="mb-3">
        <label for="postComment" 
               class="form-label text-black fs-5">
                Deixe aqui o seu comentario:
        </label>
        <textarea name="body" 
                  class="form-control" 
                  id="postComment" 
                  rows="3" 
                  required>
                    {{ old('postComment')}}
        </textarea>
    </div>
    <div class="row pe-3">
        <button type="submit" class="col-auto btn btn-primary ms-auto">Enviar</button>
    </div>
</form>

<div class="container-xl p-3 bg-light-dark">
    @each('partials.news.comments.single_comment', $news->getParentComments, "comment", "partials.news.comments.no_comments")
</div>
