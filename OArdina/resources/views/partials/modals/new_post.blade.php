<div class="container-xl">
    <div class="row justify-content-center p-3">
        <div class="col-md-7 col-9">
            <h2 class="text-white text-center">Something New? Share with us!</h2>
        </div>
        <button type="button" class="col-md-2 col-7 btn btn-primary" data-bs-toggle="modal" data-bs-target="#newPost">
            Make new post
        </button>
    </div>
</div>


<!-- Modal -->
<div class="modal fade text-white" id="newPost" tabindex="-1" aria-labelledby="newPostLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-light-dark">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="newPostLabel">New Post</h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/news/create/" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label for="News-modal-title" class="form-label">Title *</label>
                        <input type="text" name="title" class="form-control" id="News-modal-title" value="{{ old('title')}}" required>
                    </div>
                    <div class="mb-3">
                        <label for="News-modal-description" class="form-label">Description *</label>
                        <textarea rows="4" name="body" id="News-modal-description" class="input form-control" required>{{ old('body')}}</textarea>
                    </div>
                    <div class="mb-3">
                        <div class="container" id="file-display-area">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="custom-file-upload form-control" id="modal-image">
                            <input type="file" name="image" class="fileToUpload" value="{{ old('image')}}" accept="image/*">
                            <i class="fa fa-upload"></i> Image to upload
                        </label>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script defer src={{ asset('js/image_preview.js') }}></script>
