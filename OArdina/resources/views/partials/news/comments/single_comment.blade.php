<?php use App\Models\Content; ?>
<div class="row mb-3">
    @for ($i = 0; $i < $comment->level; $i++)
        <div class="col-auto ps-4"></div>
    @endfor

    <div class="col">
        <div class="d-flex">
            @include('partials.news.comments.comment_header', ['comment' => $comment])
        </div>

        <div class="row ms-4">
            <p class="text-black m-0 pb-1">
                {{ $comment->content->body }}
                @if($comment->content->is_edited)
                    <small class="text-muted">(edited)</small>
                @endif
            </p>
            <div class="row align-items-center text-muted">
                <div class="col-auto d-flex flex-row pe-1 align-items-center">
                    <button onclick='vote("{{ $comment->content->id }}", true, "")' class="clickable-big ">
                        @if ($comment->content->getVoteFromContent() === "upvote")
                            <i id="arrow_up_{{$comment->content_id}}_" 
                               class="fas fa-angle-up text-primary" 
                               data-bs-toggle="tooltip" 
                               data-bs-placement="top" 
                               title="Gosto">
                            </i>
                        @else
                            <i id="arrow_up_{{$comment->content_id}}_" 
                               class="fas fa-angle-up text-black" 
                               data-bs-toggle="tooltip" 
                               data-bs-placement="top" 
                               title="Gosto">
                            </i>
                        @endif
                    </button>
                    <span class="col-auto ps-0 text-black mx-1" id="n-votes_{{$comment->content_id}}_">{{$comment->content->nr_votes}}</span>
                    <button onclick='vote("{{ $comment->content->id }}", false, "")' class="clickable-big">

                        @if ($comment->content->getVoteFromContent() === "downvote")
                            <i id="arrow_down_{{$comment->content_id}}_" 
                               class="fas fa-angle-down text-danger" 
                               data-bs-toggle="tooltip" 
                               data-bs-placement="top" 
                               title="Não Gosto">
                            </i>
                        @else
                            <i id="arrow_down_{{$comment->content_id}}_" 
                               class="fas fa-angle-down text-black" 
                               data-bs-toggle="tooltip" 
                               data-bs-placement="top" 
                               title="Não Gosto">
                            </i>
                        @endif
                    </button>
                </div>
                <button onclick="addReplyBox('{{$comment->content_id}}')" 
                        type="button" 
                        class="col-auto clickable text-black" 
                        data-bs-toggle="modal" 
                        data-bs-target="#exampleModal">
                    <i class="fas fa-reply text-black" 
                       data-bs-toggle="tooltip" 
                       data-bs-placement="top" 
                       title="Responder">
                    </i> Responder
                </button>
            </div>
        </div>

        <form id="reply_form{{$comment->content_id}}" 
              action="/comment/create/" 
              class="container-xl mb-3 p-3 bg-light-dark" 
              style="display: none;" 
              method="post">

            @csrf
            <input name="news_id" type="hidden" value="{{$comment->news->content_id}}">
            <input name="reply_to_id" type="hidden" value="{{$comment->content_id}}">

            <label for="postComment_{{$comment->content_id}}" class="form-label text-black">
                Deixe uma resposta:
            </label>

            <div class="row">
                <div class="col-10">
                    <textarea name="body" 
                              class="form-control" 
                              id="postComment_{{$comment->content_id}}" 
                              rows="1" 
                              required>{{ old('postComment')}}
                    </textarea>
                </div>
                <div class="col-2">
                    <button type="submit" class="col-auto btn btn-primary ms-auto">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</div>

