@extends('layouts.app')

@section('title', 'Promuovi i tuoi boolbnb')

@section('cdn')
    <script src=" https://js.braintreegateway.com/web/dropin/1.40.2/js/dropin.min.js "></script>
@endsection

@section('main')
    <section id="promotion-page">
        <div class="container">
            {{-- PAYMENTS FORM --}}
            <form id="payment-form" action="{{ route('admin.apartments.sponsorize', $apartment) }}" method="post"
                data-token="{{ $clientToken }}">
                @csrf
                {{-- Back Button --}}
                <div class="circle-button back">
                    <a href="{{ route('admin.apartments.index') }}">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                </div>
                {{-- Form header --}}
                <header>
                    <div class="logo">
                        <img src="{{ asset('img/logo.png') }}" alt="logo">
                        <h1>boolbnb premium</h1>
                    </div>
                </header>
                <!-- Questions modal button -->
                <button type="button" class="d-md-none text-decoration-underline mb-3" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    Ulteriori informazioni
                </button>

                {{-- Carousel --}}
                <div id="carouselExampleIndicators" class="carousel slide d-md-none">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                            class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        @foreach ($promotions as $promotion)
                            <div id="carousel-{{ $promotion->id }}"
                                class="carousel-item @if ($loop->first) active @endif ">
                                {{-- Promotions --}}
                                <div class="card p-1 pb-4">
                                    <div class="carousel-label-{{ $promotion->id }}">
                                        <h2>{{ $promotion->name }}</h2>
                                    </div>

                                    <div class="pt-3">
                                        <h3 class="mb-3">Boolbnb {{ $promotion->name }}</h3>
                                        <p>Il tuo boolbnb comparirà in cima alla lista delle ricerche effettuate sul nostro
                                            sito.
                                            Aumentando la visibilità dei tuoi magnifici boolbnb avrai la possibilità di
                                            essere
                                            sempre
                                            contattato d anuovi clienti facendo accrescere i tuoi guadagni.
                                            Quaesto servizio sarà attivo per <b>{{ $promotion->duration }}</b> ore al
                                            prezzo di
                                            <b>€{{ $promotion->price }}</b>
                                        </p>
                                        <p>Rendi visiile a più persone <i class="fs-6">{{ $apartment->title }}</i>
                                            per
                                            {{ $promotion->duration }}</p>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                {{-- Button payment modal --}}
                <div class="d-flex justify-content-start mt-2 d-md-none">
                    <button type="button" class="button-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
                        Promuovi il boolbnb
                    </button>
                </div>


                {{-- Promotion cards --}}
                <div class="d-none d-md-block">
                    <div class="mb-2 d-flex justify-content-between">
                        <h2>Confronta le nostre offerte</h2>
                        <!-- Questions modal button -->
                        <button type="button" class="text-decoration-underline" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Ulteriori informazioni
                        </button>
                    </div>

                    <div class="row text-center">
                        @foreach ($promotions as $promotion)
                            <div id="promo-card-{{ $promotion->id }}" class="col-4">
                                <button type="button" id="button-{{ $promotion->id }}" class="promo-text">
                                    <h2>{{ $promotion->name }}</h2>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        {{-- Promotions details --}}
                        @foreach ($promotions as $promotion)
                            <div id="promo-details-{{ $promotion->id }}" class="promo-details d-none col-12">
                                <h3 class="mb-3">Boolbnb {{ $promotion->name }}</h3>
                                <p>Il tuo boolbnb comparirà in cima alla lista delle ricerche effettuate sul nostro sito.
                                    Aumentando la visibilità dei tuoi magnifici boolbnb avrai la possibilità di essere
                                    sempre
                                    contattato d anuovi clienti facendo accrescere i tuoi guadagni.
                                    Quaesto servizio sarà attivo per <b>{{ $promotion->duration }}</b> ore al prezzo di
                                    <b>€{{ $promotion->price }}</b>
                                </p>
                                <p>Promuovi <i class="fs-6">{{ $apartment->title }}</i> per
                                    {{ $promotion->duration }} ore</p>

                                {{-- Button payment modal --}}
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="button-primary" data-bs-toggle="modal"
                                        data-bs-target="#paymentModal">
                                        Acquista
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


                <!-- Questions modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Possibili domande</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                aria-expanded="false" aria-controls="flush-collapseOne">
                                                Le offerte si rinnovano in automatico?
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">Allo scadere del tempo di durata
                                                dell'offerta (Gold 144 ore, Silver 72 ore, Bronze 24 ore) si perdono
                                                i vantaggi e non verrà rinnovata in automatico</div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                                aria-expanded="false" aria-controls="flush-collapseTwo">
                                                E' possibile acquistare più offerete relative allo stesso boolbnb?
                                            </button>
                                        </h2>
                                        <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">Le offerte sono cumulabili con altre
                                                iniziative promozionali, acquistando più offerte relative allo
                                                stesso boolbnb verranno sommati i periodi di durata.</div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                                aria-expanded="false" aria-controls="flush-collapseThree">
                                                E' possibile annullare l'offerta dopo averla attivata?
                                            </button>
                                        </h2>
                                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">Una volta attivata un offerta non è più
                                                possibile annullare l'operazione, si dovrà quindi attendere il
                                                termine del tempo previsto
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment modal -->
                <div class="modal fade" class="modal-dialog modal-dialog-centered" id="paymentModal" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h3 class="mb-1">Seleziona il tipo di promozione</h3>
                                {{-- Promotions --}}
                                @foreach ($promotions as $promotion)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="promotion"
                                            id="promotion-{{ $promotion->id }}" value="{{ $promotion->id }}"
                                            @if ($loop->first) checked @endif>
                                        <label class="form-check-label" for="promotion-{{ $promotion->id }}">
                                            boolbnb {{ $promotion->name }} €{{ $promotion->price }} /
                                            {{ $promotion->duration }} ore
                                        </label>
                                    </div>
                                @endforeach
                                <div id="dropin-container"></div>
                                <input type="submit" class="btn button-primary" value="Ordina e Paga" />
                                <input type="hidden" id="nonce" name="payment_method_nonce" />
                            </div>

                        </div>
                    </div>
                </div>
            </form>

        </div>

    </section>
@endsection

@section('scripts')
    @vite('resources/js/handle-braintree.js')
    @vite('resources/js/confirm-delete.js')
    @vite('resources/js/promotion-card.js')

@endsection
