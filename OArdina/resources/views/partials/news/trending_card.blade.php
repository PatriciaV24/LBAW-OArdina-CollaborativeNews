<div style="cursor: pointer" 
     onclick="location.href='/news/{{$news->content_id}}'" 
     class="card text-black bg-dark position-relative custom_card">

    @if(isset($news->image))
        <img class="card-img" 
             src={{ asset('storage/img/news/' . $news->image) }} 
             alt="Trending Image">
    @else
        <img class="card-img" 
             src={{ asset('img/logop.png') }} alt="Trending Image">
    @endif

    <div class="card-img-overlay d-flex flex-column justify-content-end p-1">
        <h5 class="card-title px-1">{{$news->title}}</h5>

        <div class="d-flex px-1">
            @foreach ($news->tags as $tag)
                <a href="/search?search={{$tag->name}}" 
                   class="card-link link-light text-decoration-none">
                    #{{ $tag->name }}
                </a>
            @endforeach

        </div>
        <div class="row pt-1" style="font-size: smaller;">
            <div class="col">
                <span class="card-text">
                    {{ $news->content->formatDate() }}
                </span>
            </div>
            <div class="col">
                <a href="/user/{{$news->content->author->username  }}" 
                   class="card-link link-light text-decoration-none">
                      {{ $news->content->author->username  }}
                </a>
            </div>
        </div>
    </div>
</div>
