@extends('layouts.app')

@section('title', 'Cestino')

@section('main')

    <section id="trash" class="container">
        {{-- Header --}}
        <header>
            {{-- Title --}}
            <div class="d-flex align-items-center gap-3">
                <h2>Cestino</h2>
                <div class="button-primary">
                    <i class="fa-solid fa-trash-can fa-beat"></i>
                </div>
            </div>

            <div>
                {{-- Back Button --}}
                <div class="circle-button">
                    <a href="{{ route('admin.apartments.index') }}">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                </div>
                <!-- Svuota cestino commentato -->
                {{-- Drop All --}}
                <!--<form class="delete-form ms-2 delete-all d-inline-block" method="POST"
                                                                                        action="{{-- {{ route('admin.apartments.dropAll') }} --}}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                                                        {{-- @csrf
                    @method('DELETE') --}}
                                                                                        <button class="btn btn-danger">
                                                                                            <span class="d-none d-md-flex">Svuota cestino</span>
                                                                                            <i class="d-inline-block d-md-none fa-solid fa-broom"></i>
                                                                                        </button>
                                                                                    </form>-->

            </div>
        </header>

        {{-- Alerts --}}
        <div class="container my-2">
            @include('includes.alerts')
        </div>

        {{-- Apartment List --}}
        @include('includes.apartments.apartment-list')
    </section>

    {{-- Delete Modal --}}
    @include('includes.delete-modal')
@endsection

{{-- Scripts --}}
@section('scripts')
    @vite('resources/js/confirm-delete.js')
@endsection
