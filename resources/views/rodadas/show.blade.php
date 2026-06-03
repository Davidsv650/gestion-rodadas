@extends('layouts.app')

@section('content')

<style>

/* hero */
.hero-rodada {

    position: relative;

    border-radius: 20px;

    overflow: hidden;

    box-shadow: 0 10px 25px rgba(0,0,0,0.15);

}

/* carrusel */
.carousel-item img {

    height: 500px;

    object-fit: contain;

    background: #111;

    filter: brightness(0.65);

}

/* texto hero */
.hero-text {

    position: absolute;

    top: 50%;

    left: 8%;

    transform: translateY(-50%);

    color: white;

    z-index: 20;

    max-width: 500px;

    text-shadow: 0 2px 10px rgba(0,0,0,0.5);

}

.hero-text h1 {

    font-size: 3rem;

    font-weight: bold;

}

.hero-text p {

    font-size: 1.3rem;

}

/* banda de rodada finalizada */
.ribbon-finalizada {

    position: absolute;

    top: 45px;

    right: -90px;

    transform: rotate(35deg);

    background: #dc3545;

    color: white;

    padding: 14px 100px;

    font-weight: bold;

    font-size: 1rem;

    z-index: 40;

    box-shadow: 0 5px 15px rgba(0,0,0,0.2);

}

/* tarjeatas */
.info-card {

    border: none;

    border-radius: 18px;

    box-shadow: 0 5px 15px rgba(0,0,0,0.08);

}

/* botones */
.btn {

    transition: all 0.25s ease;

}

.btn:hover {

    transform: translateY(-2px);

}

/* responsive */
@media (max-width: 768px) {

    .carousel-item img {

        height: 300px;

    }

    .hero-text {

        left: 25px;

        max-width: 80%;

    }

    .hero-text h1 {

        font-size: 2rem;

    }

    .hero-text p {

        font-size: 1rem;

    }

}

</style>

<div class="container mt-4">

    {{-- titulo --}}
    <div class="d-flex align-items-center mb-4">

        <h1 class="mb-0">

            🏍️ {{ $rodada->titulo }}

        </h1>

    </div>

    {{-- alerta rodada fnalizada --}}
    @if($rodada->finalizada)

    <div class="alert alert-danger shadow-sm mb-4">

        🏁 Esta rodada ya ha sido realizada y no admite nuevas inscripciones.

    </div>

    @endif

    {{-- hero --}}
    <div class="hero-rodada mb-4">

        {{-- banda --}}
        @if($rodada->finalizada)

        <div class="ribbon-finalizada">

            RODADA REALIZADA

        </div>

        @endif

        {{-- carrusel --}}
        <div id="carouselRodada"
             class="carousel slide"
             data-bs-ride="carousel">

            {{-- indicadores --}}
            <div class="carousel-indicators">

                @foreach($rodada->circuito->imagenes->unique('imagen')->values() as $key => $imagen)

                <button type="button"
                        data-bs-target="#carouselRodada"
                        data-bs-slide-to="{{ $key }}"
                        class="{{ $key == 0 ? 'active' : '' }}">
                </button>

                @endforeach

            </div>

            {{-- imagenes --}}
            <div class="carousel-inner">

                @forelse($rodada->circuito->imagenes->unique('imagen')->values() as $key => $imagen)

                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">

                    <img src="{{ asset($imagen->imagen) }}"
                         class="d-block w-100">

                </div>

                @empty

                {{-- fallblack --}}
                <div class="carousel-item active">

                    <img src="{{ asset($rodada->circuito->imagen) }}"
                         class="d-block w-100">

                </div>

                @endforelse

            </div>

            {{-- flecha izquierda --}}
            <button class="carousel-control-prev"
                    type="button"
                    data-bs-target="#carouselRodada"
                    data-bs-slide="prev">

                <span class="carousel-control-prev-icon"></span>

            </button>

            {{-- flecha derecha --}}
            <button class="carousel-control-next"
                    type="button"
                    data-bs-target="#carouselRodada"
                    data-bs-slide="next">

                <span class="carousel-control-next-icon"></span>

            </button>

        </div>

        {{-- texto hero --}}
        <div class="hero-text">

            <h1>

                {{ $rodada->circuito->nombre }}

            </h1>

            <p>

                {{ $rodada->fecha->format('d-m-Y') }}

            </p>

            <p class="mt-4">

                {{ $rodada->circuito->frase ?? 'Vive una experiencia única sobre ruedas.' }}

            </p>

        </div>

    </div>

    {{-- contenido --}}
    <div class="row">

        {{-- INFO --}}
        <div class="col-lg-8 mb-4">

            <div class="card info-card p-4 h-100">

                <h3 class="mb-4">

                    Información de la rodada

                </h3>

                <hr>

                <p class="fs-5">

                    📅 <strong>Fecha:</strong>
                    {{ $rodada->fecha->format('d-m-Y') }}

                </p>

                <p class="fs-5">

                    🏁 <strong>Circuito:</strong>
                    {{ $rodada->circuito->nombre }}

                </p>

                <p class="fs-5">

                    👤 <strong>Organizador:</strong>
                    {{ $rodada->organizador->nombre }}

                </p>

                <p class="fs-5">

                    💰 <strong>Precio:</strong>
                    {{ $rodada->precio }} €

                </p>

                <p class="fs-5">

                    🎟️ <strong>Plazas:</strong>
                    {{ $rodada->plazas }}

                </p>

                {{-- estado --}}
                <p class="fs-5">

                    ℹ️ <strong>Estado:</strong>

                    @if($rodada->finalizada)

                    <span class="badge bg-danger rounded-pill">

                        Finalizada

                    </span>

                    @else

                    <span class="badge bg-success rounded-pill">

                        Disponible

                    </span>

                    @endif

                </p>

            </div>

        </div>

        {{-- sidebar --}}
        <div class="col-lg-4">

            {{-- circuito --}}
            <div class="card info-card p-3 mb-4 text-center">

                <h4 class="mb-3">

                    Circuito

                </h4>

                @if($rodada->circuito->imagen)

                <img src="{{ asset($rodada->circuito->imagen) }}"
                     class="img-fluid rounded mb-3">

                @endif

                <a href="{{ url('/circuitos') }}"
                   class="btn btn-primary">

                    Ver circuitos

                </a>

            </div>

            {{-- organizador --}}
            <div class="card info-card p-3 text-center">

                <h4 class="mb-3">

                    Organizador

                </h4>

                <h5>

                    {{ $rodada->organizador->nombre }}

                </h5>

                <p class="text-muted">

                    Evento oficial organizado por {{ $rodada->organizador->nombre }}

                </p>

            </div>

        </div>

    </div>

    {{-- botones --}}
    <div class="mt-4 d-flex gap-2 flex-wrap">

        <a href="{{ url('/rodadas') }}"
           class="btn btn-secondary">

            ← Volver

        </a>

        <a href="{{ url('/calendario') }}?fecha={{ $rodada->fecha }}"
           class="btn btn-primary">

            📅 Ver en calendario

        </a>

    </div>

    {{-- descripcion --}}
    @if($rodada->descripcion)

    <div class="card info-card p-4 mt-4">

        <h4 class="mb-3">

            Sobre esta rodada

        </h4>

        <p class="mb-0">

            {{ $rodada->descripcion }}

        </p>

    </div>

    @endif

</div>

@endsection