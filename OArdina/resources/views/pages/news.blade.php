@extends('layouts.app')

@section('title', 'O Ardina | ' . $news->title)

@section('content')

<div class="mb-3 text-white bg-light-dark">
    &nbsp;
</div>
<div class="container-xl">
    <div class="row mt-4">
        <div class="col-lg-9">
            @include('partials.news.post', ['news'=>$news,'type'=>""])
            @include('partials.news.comments.comments')
        </div>
        <sidebar class="row hidden-md-down col-lg-3">
            <form action="/comment/create/" 
                class="container-sm mb-3 p-3 bg-light" 
                method="post">
                @csrf

                <input name="news_id" type="hidden" value="{{$news->content_id}}">

                <div class="mb-3">
                    <label for="postComment" 
                        class="form-label text-black fs-6">
                            Deixe aqui o seu comentario:
                    </label>
                    <textarea name="body" 
                            class="form-control" 
                            id="postComment" 
                            rows="9" 
                            required>
                                {{old('postComment')}}
                    </textarea>
                </div>
                <div class="row pe-3">
                    <button type="submit" class="col-auto btn btn-primary ms-auto">Enviar</button>
                </div>
            </form>
        </sidebar>
    </div>
</div>

@endsection
