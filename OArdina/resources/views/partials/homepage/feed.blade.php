<div  class="mb-3 text-white bg-light-dark">
    <ul  class="menuprincipal nav nav-pills" id="pills-tab" role="tablist">
        @include('partials.tab', ['active' => True, 'type' => 'recent', 'name' => "Mais Recentes"])  
        @include('partials.tab', ['active' => False, 'type' => 'nacional', 'name' => "Nacional"])     
        @include('partials.tab', ['active' => False, 'type' => 'local', 'name' => "Local"])     
        @include('partials.tab', ['active' => False, 'type' => 'justiça', 'name' => "Justiça"])
        @include('partials.tab', ['active' => False, 'type' => 'politica', 'name' => "Política"])     
        @include('partials.tab', ['active' => False, 'type' => 'mundo', 'name' => "Mundo"])     
        @include('partials.tab', ['active' => False, 'type' => 'economia', 'name' => "Economia"])     
        @include('partials.tab', ['active' => False, 'type' => 'desporto', 'name' => "Desporto"])   
        @include('partials.tab', ['active' => False, 'type' => 'pessoas', 'name' => "Pessoas"])     
        @include('partials.tab', ['active' => False, 'type' => 'inovação', 'name' => "Inovação"])     
        @include('partials.tab', ['active' => False, 'type' => 'cultura', 'name' => "Cultura"])     

    </ul>
</div>
<div class="newsmargin tab-content" id="pills-tabContent">
    <div class="row" data-aos="fade-up">

        <div class="col-lg-12 stretch-card grid-margin p-3">
        @include('partials.tab_content', ['active'=>True, 'type'=>'recent', 'posts'=>$recentPosts]) 
        @include('partials.tab_content', ['active'=>False, 'type'=>'desporto', 'posts'=>$hotPosts]) 
        <!--ACRECENTAR PESQUISA PELAS TAGS--> 
        </div>
    </div>
</div>
