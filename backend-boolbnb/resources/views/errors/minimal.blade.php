@extends('layouts.app')


@section('main')
    <section id="error" class="container mt-5">

        <div class="row">

            {{-- Text Column --}}
            <div class="col-12 col-sm-6">

                {{-- Title --}}
                <h1 class="display-3 fw-bold mb-4">Oops!</h1>

                {{-- Error Message --}}
                <h2 class="mb-4">@yield('message')</h2>

                {{-- Error Code --}}
                <p class="mb-4"><strong>Errore: </strong>{{ $exception->getStatusCode() }}</p>

                {{-- Useful link nav --}}
                <nav>
                    <p class="mb-2">
                        Eccoti alcuni link utili:
                    </p>

                    <ul>
                        <li>
                            <a class="text-primary d-inline-block pb-2" href="{{ route('admin.apartments.index') }}">I miei
                                Boolbnb</a>
                        </li>
                        <li>
                            <a class="text-primary d-inline-block pb-2" href="{{ route('admin.home') }}">Il mio Profilo</a>
                        </li>
                        <li>
                            <a class="text-primary d-inline-block pb-2" href="{{ route('admin.apartments.create') }}">Apri
                                un Boolbnb</a>
                        </li>
                    </ul>
                </nav>
            </div>

            {{-- Error Code Column --}}
            <div class="col-12 col-sm-6 d-flex flex-column justify-content-center align-items-center">
                <img src="{{ asset('img/pages/lighthouse.png') }}" alt="lighthouse illustration" class="img-fluid">
            </div>
        </div>

    </section>
@endsection
