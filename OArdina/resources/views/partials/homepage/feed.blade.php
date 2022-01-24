<div  class="mb-3 text-white bg-light-dark">
    <ul  class="menuprincipal nav nav-pills" id="pills-tab" role="tablist">
    @auth
        @include('partials.tab', ['active' => True, 'type' => 'feed', 'name' => "Página Principal"])
        @include('partials.tab', ['active' => False, 'type' => 'recent', 'name' => "Mais Recente"])
    @endauth

    @guest
        @include('partials.tab', ['active' => True, 'type' => 'recent', 'name' => "Página Principal"])
    @endguest
        @include('partials.tab', ['active' => False, 'type' => 'hot', 'name' => "Tendências"])
    </ul>
</div>
<div class="newsmargin tab-content" id="pills-tabContent">
    @auth
        @include('partials.tab_content', ['active'=>True, 'type'=>'feed', 'posts'=>$feedPosts])
        @include('partials.tab_content', ['active'=>False, 'type'=>'recent', 'posts'=>$recentPosts]) 
    @endauth
    @guest
        @include('partials.tab_content', ['active'=>True, 'type'=>'recent', 'posts'=>$recentPosts]) 
    @endguest 
    @include('partials.tab_content', ['active'=>False, 'type'=>'hot', 'posts'=>$hotPosts]) 

</div>
