<div class="accordion accordion-flush py-3">
    <div class="accordion-item">
        <h2 class="accordion-header" id="filterSearch">
            <button class="accordion-button collapsed text-white clickable bg-light-dark" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#filterSearchCollapse" 
                    aria-expanded="true" 
                    aria-controls="filterSearchCollapse">
                    <div class="fas fa-chevron-down"></div>
                        &nbsp; Filtrar pesquisa
                    
            </button>
        </h2>
        <div id="filterSearchCollapse" 
             class="accordion-collapse collapse" 
             aria-labelledby="filterSearch" 
             data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    @include('partials.search.options')
                </div>
        </div>
    </div>
</div>


