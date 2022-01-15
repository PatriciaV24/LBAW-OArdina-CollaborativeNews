<ul class="nav nav-pills mb-3 text-white bg-light-dark" id="pills-tab" role="tablist">
    @auth
        @include('partials.tab', ['active' => True, 'type' => 'feed', 'name' => "Feed"])
        @include('partials.tab', ['active' => False, 'type' => 'recent', 'name' => "Recent"])
    @endauth

    @guest            
        @include('partials.tab', ['active' => True, 'type' => 'recent', 'name' => "Recent"])
    @endguest
    
    @include('partials.tab', ['active' => False, 'type' => 'hot', 'name' => "Hot"])
</ul>

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