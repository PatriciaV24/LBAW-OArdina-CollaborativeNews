<div class="card m-1">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5 grid-margin">
                <div class="position-relative">
                    <div class="p-1">
                        @foreach ($news->tags as $tag) 
                            <a href="/search?search={{$tag->name}}" 
                                class="btn btn-primary-login col-auto clickable text-black px-1 text-decoration-none">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                    
                    @isset($news->image)
                        <img src={{ asset('storage/img/news/' . $news->image) }} 
                            class="card-img-top" 
                            alt="{{$news->title}} Image" 
                            draggable="false">
                    @endisset
                   
                </div>
                <div class="row align-items-center p-3 ">
                    <div class="col-9">
                        <a class="row text-muted text-decoration-none autordata" >
                            <h6>{{ $news->content->formatDate() }}</h6>
                        </a>
                        <a class="row clickable text-muted text-decoration-none autordata" 
                            href="{{url('/user/' . $news->content->author->username)}}">
                            <h3>{{ $news->content->author->username  }}</h3>
                        </a>                            
                    </div>
                    @include('partials.news.vote',['news'=>$news, 'type'=>$type])

                    <button class="col-1 clickable text-black p-">
                        <a href="/news/{{$news->content_id}}" 
                            class="text-decoration-none text-black">
                                <i class="fas fa-comment text-black" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    title="Comentários">
                                </i>
                                &nbsp;
                                {{$news->nr_comments}}
                        </a>
                    </button>
                    
                </div>
            </div>
            <div class="col-sm-7  grid-margin">
                <ul class="list-group list-group-flush flex-row-reverse">
                    @if (Auth::user() && $news->content->author_id === Auth::user()->id)
                        <button type="button" 
                                class="col-auto card-report clickable-big text-danger p-2 preventer" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deletePostModal_{{$news->content_id}}">
                                <i class="fas fa-trash" 
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                title="Eliminar">
                                </i>
                        </button>
                        <button type="button" 
                                class="card-report clickable-big text-black p-2 preventer" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editPost_{{$news->content_id}}">
                                <i class="fa fa-pencil" 
                                    aria-hidden="true" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    title="Editar">
                                </i>
                        </button>
                    <?php $type="news" ?>

                    @include('partials.modals.delete_post', ['news' => $news])
                    @include('partials.modals.edit_post', ['news' => $news])

                    @elseif (Auth::user() && Auth::user()->is_admin)
                        <button type="button" 
                                class="col-auto card-report clickable-big text-danger p-2 preventer" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deletePostModal_{{$news->content_id}}">
                                    <i class="fas fa-trash" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    title="Eliminar">
                                    </i>
                        </button>

                        @include('partials.modals.delete_post', ['news' => $news])

                    @elseif(Auth::user() && $news->content->author_id != Auth::user()->id)
                        <button type="button" id="toastbtn" 
                                class="col-1 card-report clickable-big text-black preventer" 
                                data-bs-toggle="modal" 
                                data-bs-target="#reportContent_{{$news->content_id}}_{{$type}}">
                                <i class="fas fa-exclamation-triangle"></i>
                        </button>
                        @include('partials.modals.report', ['report_to_id' => $news->content_id, 'type'=>"news", 'tab'=>$type])
                    @endif
                </ul>
                <ul class="list-group list-group-flush flex-row-reverse">
                    <p class="card-text mt-3 text-black">
                        @if($news->content->is_edited)
                            <small class="text-muted">
                                (editado)
                            </small>
                        @endif
                    </p>
                </ul>
                <div class="">
                    <h2 class="mb-1 font-weight-600">
                        {{$news->title}}
                    </h2>
                    <p class="card-text">
                        {!! nl2br(e($news->content->body)) !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@once
    <script defer src="{{ asset('js/vote.js') }}"></script>
    <script defer src="{{ asset('js/reply.js') }}"></script>
@endonce
