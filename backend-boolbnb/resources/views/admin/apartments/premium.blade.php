@extends('layouts.app')

@section('title', 'premium')

@section('main')
    <section id="premium-page">
        {{-- JUMBOTRON --}}
        <div class="jumbotron">
            <div class="container">
                <div class="d-flex justify-content-end">
                    {{-- Back Button --}}
                    <div class="circle-button">
                        <a href="{{ route('admin.apartments.index') }}">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    </div>
                </div>
                {{-- Header --}}
                <header>
                    <div class="logo">
                        <img src="{{ asset('img/logo.png') }}" alt="logo">
                        <h1>boolbnb premium</h1>
                    </div>
                </header>
            </div>
            {{-- Content --}}
            <div>
                <div class="px-3">
                    <h2 class="text-center my-2 my-sm-3 my-md-4">Promuovi i tuoi boolbnb per renderli subito visibili a
                        tutti!</h2>
                    <p>Promuovendo un boolbnb comparirà per primo alle ricerche sul nostro sito aumentandone la visibilità e
                        aumentando la probabilità di essere contattato dai nostri utenti. <br> Scopri tutte le nostre
                        offerte scegliendo quella più adatta alle tue esigenze. <br> Aumenta la visibilità senza impegno,
                        scegli tu se rinnovare il servizio una volta terminato</p>
                </div>
                <div class="mt-3">
                    <p>Decidi quale boolbnb sponsorizzare e clicca sul pulsante
                        <span class="upgrade"><i class="fa-solid fa-arrow-up "></i></span>
                        per visualizzzare le offerte
                    </p>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')

    @vite('resources/js/confirm-delete.js')

@endsection
