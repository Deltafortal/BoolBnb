@extends('layouts.app')

@section('title', 'Messages')

@section('main')

    <div class="container my-5">

        {{-- Alerts --}}
        <div class="my-2">
            @include('includes.alerts')
        </div>

        <!--Header-->
        <header class="d-flex align-items-center justify-content-between pb-4">

            {{-- Page Title --}}
            <h2>Lista Messaggi</h2>

            {{-- Page Actions --}}
            <!--
                <div>
                    <a href="{{-- {{ route('admin.messages.create') }} --}}" class="btn btn-success">
                        <span>
                           Manda un nuovo messaggio <i class="fa-regular fa-envelope"></i>
                        </span>
                        <i class="d-inline-block d-md-none fa-solid fa-plus"></i>
                    </a>
                </div>-->

        </header>

        <table class="table table-white table-hover align-middle mt-5">

            {{-- Table Headers --}}
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Titolo</th>
                    <th scope="col">Contenuto</th>
                    <th scope="col">Email</th>
                    <th scope="col">Appartamento</th>
                    <th scope="col" class="d-none d-lg-table-cell">Data</th>
                    <th scope="col"></th>
                </tr>
            </thead>

            {{-- Table Body --}}
            <tbody>
                @forelse ($messages as $message)
                    <tr>
                        {{-- ID --}}
                        <th scope="row">{{ $message->id }}</th>

                        {{-- Title --}}
                        <td>{{ $message->name }}</td>

                        {{-- Content --}}
                        <td>{{ $message->content }}</td>

                        {{-- Mail --}}
                        <td>{{ $message->email }}</td>

                        {{-- Apartment_id --}}
                        <td>{{ $message->apartment_id }}</td>

                        {{-- Dates --}}
                        <td class="d-none d-lg-table-cell">{{ $message->getDate('created_at') }}</td>
                    </tr>

                    {{-- Empty message --}}
                @empty
                    <tr>
                        <td class="text-center" colspan="8">
                            <h3>Non ci sono messaggi</h3>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

@endsection
