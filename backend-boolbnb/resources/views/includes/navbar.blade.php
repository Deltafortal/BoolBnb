<nav class="bool-nav">
    <div class="container">
        <div class="row">
            <ul class="col col-11 col-md-10 col-lg-11">
                @foreach ($categories as $category)
                    <li>
                        <img src="{{ asset('img/category/' . $category['img']) }}" alt="{{ $category['label'] }}">
                        <div>{{ $category['label'] }}</div>
                    </li>
                @endforeach
            </ul>
            <div class="d-none d-md-flex col col-md-2 col-lg-1 align-items-center justify-content-end">
                <button class="filter"><!-- Filtri avanzati (DA FARE) -->
                    <i class="fa-solid fa-sliders"></i>
                    <span>Filtri</span>
                </button>
            </div>
            <div class="col-1 d-flex d-md-none align-items-center justify-content-end">
                <div class="filter"><i class="fa-solid fa-sliders"></i></div> <!-- Filtri avanzati (DA FARE) -->
            </div>
        </div>
    </div>
</nav>
