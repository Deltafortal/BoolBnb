@extends('layouts.app')

@section('title', 'Modifica un Boolbnb')

@section('main')
    <section id="admin-edit" class="container">
        {{-- Header --}}
        <header>
            {{-- Title --}}
            <div class="d-flex align-items-center gap-3">
                <h2>Modifica il tuo Boolbnb</h2>
                <div class="button-primary">
                    <i class="fa-solid fa-pencil fa-beat"></i>
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
    @vite(['resources/js/handle-address-geocode.js', 'resources/js/image-form', 'resources/js/frontend-validation.js'])
@endsection
