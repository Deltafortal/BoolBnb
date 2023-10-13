@extends('layouts.app')

@section('title', 'I tuoi Boolbnb')

@section('main')
    <section id="admin-show" class="container">
        {{-- Alerts --}}
        @include('includes.alerts')

        {{-- header --}}
        <header>
            {{-- Title --}}
            <h2>{{ $apartment->title }}</h2>

            <div class="d-flex justify-content-between align-items-center gap-2">
                {{-- Back Button --}}
                <div class="circle-button">
                    <a href="{{ route('admin.apartments.index') }}">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                </div>

                {{-- Actions --}}
                @if (Auth::id() === $apartment->user_id)
                    <div class="dropdown">
                        <button class="circle-button dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-gear"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                {{-- Toggle Button --}}
                                <form method="POST" action="{{ route('admin.apartments.toggle', $apartment) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="admin-action {{ $apartment->is_visible ? 'secondary' : 'success' }}">
                                        <i class="fas fa-{{ $apartment->is_visible ? 'eye-slash' : 'eye' }}"></i>
                                        {{ $apartment->is_visible ? 'Cambia in Bozza' : 'Pubblica' }}
                                    </button>
                                </form>
                            </li>
                            <li>
                                {{-- Edit Button --}}
                                <a href="{{ route('admin.apartments.edit', $apartment) }}" class="admin-action warning">
                                    <i class="fas fa-pencil"></i> Modifica
                                </a>
                            </li>
                            <hr>
                            <li>
                                {{-- Delete Button --}}
                                <form action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST"
                                    class="delete-form" data-title="{{ $apartment->title }}" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-action danger">
                                        <i class="fas fa-trash"></i>Elimina
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </header>

        {{-- image --}}
        <div class="slider">
            <div></div>
            @if ($apartment->image)
                {{-- With image --}}
                <div class="image-container">
                    <img src="{{ $apartment->image ? asset('storage/' . $apartment->image) : 'https://marcolanci.it/utils/placeholder.jpg' }}"
                        alt="{{ $apartment->title }}">
                </div>
            @else
                {{-- Without image --}}
                <div class="no-image">
                    <div class="icon">
                        <img src="{{ asset('img/camera.png') }}" alt="camera">
                    </div>
                    <h3>Non hai ancora inserito nessuna immagine</h3>
                </div>
            @endif
            <div></div>
        </div>

        {{-- Information --}}
        <section id="apartments-details" class="mt-4">
            <div class="card flex-column">
                <h3>Comandi rapidi</h3>
                <ul class="short-actions">
                    <li><a href="#messages">Vedi messaggi</a></li>
                    <li><a href="#map-card">Vedi mappa</a></li>
                    <li><a href="#stats">Mostra grafici statistiche</a></li>
                </ul>
            </div>

            {{-- Planimetry --}}
            <div class="card flex-column flex-md-row">
                <div>
                    <h4>Planimetria</h4>
                </div>

                <div>
                    <ul>
                        <li>{{ $apartment->rooms . ' ' . ($apartment->rooms == 1 ? 'Camera da letto' : 'Camere da letto') }}
                        </li>
                        <li>{{ $apartment->beds . ' ' . ($apartment->beds == 1 ? 'Letto' : 'Letti') }}
                        </li>
                        <li>{{ $apartment->bathrooms . ' ' . ($apartment->bathrooms == 1 ? 'Bagno' : 'Bagni') }}</li>
                    </ul>
                </div>


                <div>
                    <ul>
                        <li>{{ $apartment->square_meters }} Metri quadrati</li>
                    </ul>
                </div>
            </div>


            {{-- Category & Price --}}
            <div class="card flex-column flex-md-row">
                <div>
                    <h4 class="d-md-none">Categoria & Prezzo</h4>
                    <h4 class="d-none d-md-block">Categoria <br>&<br>Prezzo</h4>
                </div>

                <div>
                    {{-- Category --}}
                    @if ($apartment->category)
                        <span>
                            {{ $apartment->category->name }}
                        </span>
                    @else
                        <span>
                            Nessuna Categoria
                        </span>
                    @endif
                </div>

                <div>
                    <span>{{ $apartment->price }}€ a notte</span>
                </div>
            </div>

            {{-- Description --}}
            <div class="card">
                <div>
                    <h4>Descrizione</h4>
                </div>

                <div>
                    <p>{{ $apartment->description }}</p>
                </div>
            </div>

            {{-- Map & Position --}}
            <section id="map-card" class="card">
                <div>
                    <h4>Posizione</h4>
                </div>

                <div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="address">{{ $apartment->address }}</div>

                        <!-- Map modal button -->
                        <button type="button" id="map-button" class="button-dark" data-bs-toggle="modal"
                            data-bs-target="#mapModal">
                            <span class="d-none d-sm-inline">Mostra la mappa</span> <i class="fa-solid fa-map"></i>
                        </button>
                    </div>
                </div>
            </section>

            {{-- Services --}}
            <div class="card">
                <div>
                    <h4>Servizi offerti</h4>
                </div>

                <div>
                    <div class="d-flex flex-wrap gap-2">
                        @forelse ($apartment->services as $service)
                            <span class="service-badge">
                                <div class="service-image">
                                    <img src="{{ asset('img/service/' . $service['icon']) }}" alt="{{ $service->name }}"
                                        width="20px">
                                </div>
                                <span>{{ $service->name }}</span>
                            </span>
                        @empty
                            -
                        @endforelse
                    </div>
                </div>
            </div>

            <section id="messages">
                <h2 class="text-center">Messaggi <i class="fa-solid fa-comments"></i></h2>
                <div>
                    <div class="message-list accordion accordion-flush" id="accordionFlushExample">
                        @forelse ($apartment->messages as $message)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse{{ $message->id }}" aria-expanded="false"
                                        aria-controls="flush-collapse{{ $message->id }}">
                                        Messaggio ricevuto da {{ $message->name }}
                                        <div class="text-gradient" style="font-size: 12px">
                                            {{ $message->created_at->format('d/m/y') }}
                                            alle
                                            {{ $message->created_at->format('H:i') }}
                                        </div>
                                    </button>
                                </h2>
                                <div id="flush-collapse{{ $message->id }}" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <p>{{ $message->content }}</p>
                                        <hr>
                                        <div><i class="fa-solid fa-envelope"></i> <i> {{ $message->email }} </i></div>

                                    </div>
                                </div>
                            </div>
                        @empty
                            {{-- Empty message --}}
                            <div class="message-empty">
                                <img src="{{ asset('img/pages/message.svg') }}" alt="">
                                <img class="logo" src="{{ asset('img/logo.png') }}" alt="">
                            </div>
                            <div>
                                Non hai ricevuto nessun messaggio, promuovi i tuoi boolbnb con boolbnb premium per ottenere
                                più visualizzazioni!
                                <a href="{{ route('admin.apartments.index') }}" class="button-primary">Vedi di più</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="stats" class="card">
                <div>
                    <h4>Statistiche</h4>
                </div>

                <div>
                    <a class="button-dark" href="{{ route('admin.apartments.statistics', $apartment) }}">Grafici
                        visualizzazioni e messaggi ricevuti</a>
                </div>

            </section>

            <!-- Map Modal -->
            <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content text-center">
                        {{-- Map --}}
                        @if ($apartment->address)
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body flex-column flex-lg-row">
                                {{-- Title & Address --}}
                                <div class="description ">
                                    <h3>{{ $apartment->title }}</h3>
                                    <hr>
                                    <h5>Si trova a </h5>
                                    <h6>{{ $apartment->address }}</h6>
                                </div>
                                {{-- Map --}}
                                <div class="map">
                                    <div id="map" data-latitude="{{ $apartment->latitude }}"
                                        data-longitude="{{ $apartment->longitude }}">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        {{-- Delete Modal --}}
        @include('includes.delete-modal')
    @endsection



    @section('scripts')
        @vite(['resources/js/confirm-delete.js', 'resources/js/map-viewer.js'])
    @endsection
