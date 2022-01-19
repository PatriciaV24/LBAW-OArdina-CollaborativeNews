<div id="feupCarousel" class="container-xl carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="containerfeupimg carousel-item active" data-bs-interval="4000">
            <img src="{{ asset('img/feup.jpg') }}" class="feupimg d-block w-100" alt="FEUP">
        </div>
        <div class="containerfeupimg carousel-item" data-bs-interval="4000">
            <img src="{{ asset('img/lbaw.jpg') }}" class="feupimg d-block w-100" alt="LBAW">
        </div>
        <div class="containerfeupimg carousel-item" data-bs-interval="4000">
            <img src="{{ asset('img/covid.jpg') }}" class="feupimg d-block w-100" alt="COVID-19">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#feupCarousel"  data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#feupCarousel"  data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Próximo</span>
    </button>
</div>