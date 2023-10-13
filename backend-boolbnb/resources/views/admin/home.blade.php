@extends('layouts.app')

@section('main')
    <?php
    $name = Auth::user()->name ? strtoupper(Auth::user()->name) : null;
    $firstLetter = substr($name, 0, 1);
    ?>

    <section id="admin-home">
        <div class="container py-5">
            {{-- Card with name --}}
            @if (Auth::user()->name)
                <div class="card">
                    <div class="profile-img">{{ $firstLetter }}</div>
                    <h1>{{ $name }}</h1>
                </div>
            @endif

            <div class="card my-3">
                <div class="row">
                    {{-- Personal info --}}
                    <div class="col-12 col-md-6">
                        @if (Auth::user()->name)
                            <h3>Informazioni di {{ Auth::user()->name }}</h3>
                        @else
                            <h2>Informazioni personali</h2>
                        @endif
                        <ul>
                            <li><span>Nome</span> {{ Auth::user()->name ?? 'Non fornito' }}</li>
                            <li><span>Cognome</span> {{ Auth::user()->surname ?? 'Non fornito' }}</li>
                            <li><span>Data di nascita</span> {{ Auth::user()->date_of_birth ?? 'Non fornito' }}</li>
                            <li><span>Indirizzo email</span> {{ Auth::user()->email }}</li>
                        </ul>
                    </div>

                    {{-- Personal Boolbnb --}}
                    @if (count(Auth::user()->apartments))
                        <div class="col-12 col-md-6">
                            <h3>I tuoi Boolbnb</h3>
                            <a class="button-primary" href="{{ route('admin.apartments.index') }}">
                                Vai ai tuoi boolbnb
                            </a>
                        </div>
                    @else
                        {{-- Add Boolbnb --}}
                        <div class="col-12 col-md-6">
                            <h2>Apri un Boolbnb</h2>
                            <div class="fs-6">Mettere casa su Boolbnb è facile!</div>
                            <a class="button-primary" href="{{ route('admin.apartments.create') }}">
                                <i class="fa-solid fa-house-medical pe-1"></i> Boolbnb Start
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <h3>Esci</h3>
                <div class="logout">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();  document.getElementById('logout-form').submit();">Esci</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
