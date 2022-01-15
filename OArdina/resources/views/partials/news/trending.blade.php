<div class="container-xl my-2">
    <h2 class="text-center text-light">Trending News</h2>
    <div class="card-deck row flex-row flex-nowrap overflow-auto g-0 gap-3 w-30">
         @each('partials.news.trending_card', $recentPosts, 'news')
    </div>  
</div>
