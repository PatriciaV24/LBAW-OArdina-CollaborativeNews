@if ($active == True)            
    <div class="tab-pane fade show active" id="pills-{{$type}}" role="tabpanel" aria-labelledby="pills-{{$type}}-tab">
        @if(count($posts) === 0)
            <p class="text-white text-center h6 pt-4 pb-3">No results found</p>
        @else
            @foreach($posts as $post)
                @include('partials.news.post', ['news'=>$post,'type'=>$type])
            @endforeach         
        @endif
    </div>
@else
    <div class="tab-pane fade show" id="pills-{{$type}}" role="tabpanel" aria-labelledby="pills-{{$type}}-tab">
        @if(count($posts) === 0)
            <p class="text-white text-center h6 pt-4 pb-3">No results found</p>
        @else
            @foreach($posts as $post)
                @include('partials.news.post', ['news'=>$post,'type'=>$type])
            @endforeach
        @endif    
    </div>  
@endif

