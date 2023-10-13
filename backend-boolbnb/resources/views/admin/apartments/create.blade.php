@extends('layouts.app')

@section('title', 'Aggiungi un Boolbnb')

@section('main')
    <section id="admin-create" class="container">
        {{-- Header --}}
        <header>
            {{-- Title --}}
            <div class="d-flex align-items-center gap-3">
                <h2>Aggiungi un nuovo Boolbnb</h2>
                <div class="button-primary">
                    <i class="fa-solid fa-house-medical fa-beat"></i>
                </div>
            </div>
            {{-- Back Button --}}
            <div class="circle-button">
                <a href="{{ route('admin.apartments.index') }}">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            </div>
        </header>
        <hr>
        {{-- Form --}}
        @include('includes.form')
    </section>
@endsection


{{-- Scripts --}}
@section('scripts')
    @vite(['resources/js/handle-address-geocode.js'])
    @vite(['resources/js/image-form'])
    @vite(['resources/js/frontend-validation.js'])
@endsection
