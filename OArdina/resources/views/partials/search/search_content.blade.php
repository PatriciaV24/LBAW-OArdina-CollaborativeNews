       


<ul class="nav nav-pills mb-3 text-white bg-light-dark" id="search-tab" role="tablist">
    <li class="nav-item " role="presentation">
        <button class="nav-link active text-white" id="search-news-tab" data-bs-toggle="pill" data-bs-target="#search-news" type="button" role="tab" aria-controls="search-news" aria-selected="true">News</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link text-white" id="search-users-tab" data-bs-toggle="pill" data-bs-target="#search-users" type="button" role="tab" aria-controls="search-users" aria-selected="false">Users</button>
</ul>
<section class="tab-content"> 
    <!-- News tab -->
    <div class="tab-pane fade show active" id="search-news" role="tabpanel" aria-labelledby="search-news-tab">
        @if(count($news) === 0)
            <p class="text-white text-center h6 pt-4 pb-3">No results found</p>
        @else


            <div id="posts-result">
                @foreach($news as $post)
                    @include('partials.news.post', ['news'=>$post,'type'=>""])
                @endforeach
            </div>
        @endif
    </div>

    <!-- Users tab -->
    <div class="tab-pane fade" id="search-users" role="tabpanel" aria-labelledby="search-users-tab">
        <div class="row text-white pt-4 justify-content-evenly">   
            @if(count($users) === 0)
                <p class="text-white text-center h6 pt-4 pb-3">No results found</p>
            @else
                @each('partials.users.user_card', $users, 'user')
            @endif  

        </div>        
        
    </div>

</section>

<script defer src={{ asset('js/filter_search.js') }} defer></script>

