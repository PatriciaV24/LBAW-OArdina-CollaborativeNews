<div class="tab-content" id="pills-tabContent">
    @auth
        @include('partials.tab_content', ['active'=>True, 'type'=>'feed', 'posts'=>$feedPosts])
        @include('partials.tab_content', ['active'=>False, 'type'=>'recent', 'posts'=>$recentPosts]) 
    @endauth

    @guest
        @include('partials.tab_content', ['active'=>True, 'type'=>'recent', 'posts'=>$recentPosts]) 
    @endguest 

    @include('partials.tab_content', ['active'=>False, 'type'=>'hot', 'posts'=>$hotPosts]) 
</div>