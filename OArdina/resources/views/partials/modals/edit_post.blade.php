<div class="modal fade text-black" 
     id="editPost_{{$news->content_id}}" 
     tabindex="-1" 
     aria-labelledby="newPostLabel" 
     aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content bg-light-dark">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="newPostLabel">Editar publicação</h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/news/{{$news->content_id}}/" enctype="multipart/form-data">
                    {{csrf_field()}}
                    @method('patch')
                    <div class="mb-3">
                        <label for="News-modal-title_{{$news->content_id}}" class="form-label">
                            Editar publicação
                        </label>
                        <input type="text" name="title" class="form-control" id="News-modal-title_{{$news->content_id}}" value="{{$news->title}}">
                    </div>

                    <div class="mb-3">
                        <label for="News-modal-description_{{$news->content_id}}" class="form-label">Descriçõ</label>
                        <textarea id="News-modal-description_{{$news->content_id}}" 
                                  name="body" 
                                  class="input form-control" 
                                  role="textbox" 
                                  rows="3" 
                                  contenteditable aria-multiline="true">
                                    {{$news->content->body}}
                        </textarea>
                    </div>
                    <div class="mb-3">
                        <div class="container" id="file-display-area">
                            @isset($news->image)
                                <img src="{{ asset('storage/img/news/' . $news->image)}}" style="object-fit: contain; width:225px;"></img>
                            @endisset
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="custom-file-upload form-control" id="modal-image">
                            <input type="file" 
                                   name="image" 
                                   class="fileToUpload" 
                                   value="{{ asset('storage/img/news/' . $news->image)}}" 
                                   accept="image/*">
                            <i class="fa fa-upload"></i> Imagem
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">Submeter</button>
                </form>
            </div>
        </div>
    </div>
</div>

@once
    <script defer src={{ asset('js/image_preview.js') }}></script>
@endonce
