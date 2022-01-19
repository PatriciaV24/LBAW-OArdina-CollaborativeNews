<div class="container">
    <div class="row p-3">
        <button type="button" class="col-md-1 col-3 btn btn-primary-login" data-bs-toggle="modal" data-bs-target="#newPost">
            <i class="fas fa-plus"></i>
            <i class=" fas fa-newspaper"></i>
        </button>
    </div>
</div>


<div class="modal fade text-black" 
     id="newPost" 
     tabindex="-1" 
     aria-labelledby="newPostLabel" 
     aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content bg-light">
            <div class="modal-header ">
                <h5 class="modal-title text-black" id="newPostLabel">Nova publicação</h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form method="post" action="/news/create/" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label for="News-modal-title" class="form-label">Título *</label>
                        <input type="text" name="title" class="form-control" id="News-modal-title" value="{{ old('title')}}" required>
                    </div>
                    <div class="mb-3">
                        <label for="News-modal-description" class="form-label">Descrição *</label>
                        <textarea rows="4" name="body" id="News-modal-description" class="input form-control" required>{{ old('body')}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="custom-file-upload form-control" id="modal-image">
                            <input type="file" name="image" class="fileToUpload" value="{{ old('image')}}" accept="image/*">
                            <i class="fa fa-upload"></i> Imagem
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">Submeter</button>
                </form>
            </div>
        </div>
    </div>
</div>
