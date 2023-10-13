@if ($apartment->exists)
    <form id="validation-form" method="POST" action="{{ route('admin.apartments.update', $apartment) }}"
        enctype="multipart/form-data" novalidate>
        @method('PUT')
    @else
        <form id="validation-form" method="POST" action="{{ route('admin.apartments.store') }}"
            enctype="multipart/form-data" novalidate>
@endif
@csrf

<div class="row" id="get-validation" data-validate="form">

    {{-- # Title --}}
    <div class="col-6 mb-4">
        <label for="title" class="form-label @error('title') is-invalid @enderror">
            Titolo
            <span class="form-text text-danger fs-5">*</span>
        </label>

        <input value="{{ old('title', $apartment->title) }}" type="text"
            class="form-control @error('title') is-invalid @enderror" id="title" name="title" required>
        @error('title')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
        <span id="title-error" class="text-danger"></span>
    </div>


    {{-- # Description --}}
    <div class="col-12 mb-4">
        <label for="description" class="form-label">Descrizione</label>
        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
            rows="10">{{ old('description', $apartment->description) }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
        <span id="description-error" class="text-danger"></span>
    </div>


    {{-- # Image Field --}}
    <div class="col-12 mb-4">
        <div class="row align-items-center">

            {{-- # Add file --}}
            <div class="col-8 col-sm-9">
                <label for="image" class="form-label">Immagine</label>

                {{-- Button for change image --}}
                <div class="input-group  @if (!$apartment->image) d-none @endif" id="change-image">
                    <button class="btn btn-outline-secondary" type="button">Cambia immagine</button>
                    <input type="text" class="form-control" placeholder="{{ $apartment->image }}" disabled>
                </div>

                {{-- Input for add image --}}
                <input type="file"
                    class="form-control @error('image') is-invalid @enderror @if ($apartment->image) d-none @endif"
                    id="image" name="image">

                @error('image')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <span id="image-error" class="text-danger"></span>

                {{-- Button for remove image --}}
                <button class="btn btn-danger mt-3 @if (!$apartment->image) d-none @endif" id="remove-image"
                    type="button">Rimuovi immagine</button>
                <input type="checkbox" class="d-none" id="delete_image" name="delete_image" value="1">

            </div>

            {{-- # Preview --}}
            <div class="col-4 col-sm-3">
                <img src="{{ $apartment->image ? $apartment->get_image() : 'https://media.istockphoto.com/id/1147544807/vector/thumbnail-image-vector-graphic.jpg?s=612x612&w=0&k=20&c=rnCKVbdxqkjlcs3xH87-9gocETqpspHFXu5dIGB4wuM=' }}"
                    alt="preview" class="img-fluid" id="image-preview">
            </div>
        </div>
    </div>


    {{-- Categories --}}
    <div class="col-12 mb-4">
        <label for="categories" class="form-label">Categorie</label>
        <select id="categories" class="form-select form-select-lg @error('category_id') is-invalid @enderror"
            name="category_id">
            <option value="">Nessuna categoria</option>
            @foreach ($categories as $category)
                <option @if (old('category_id', $apartment->category_id) == $category->id) selected @endif value="{{ $category->id }}">
                    {{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
    </div>


    {{-- Services --}}
    <div class="col-12 mb-4">

        <label class="form-label">
            Servizi
            <span class="form-text text-danger fs-5">*</span>
        </label>

        <div class="border rounded p-2">
            @foreach ($services as $service)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" @if (in_array($service->id, old('services', $apartment_service_id ?? []))) checked @endif
                        id="service-{{ $service->id }}" value="{{ $service->id }}" name="services[]">
                    <label class="form-check-label me-3"
                        for="service-{{ $service->id }}">{{ $service->name }}</label>
                </div>
            @endforeach
        </div>

        @error('services')
            <span class="text-danger" role="alert">{{ $message }}</span>
        @enderror
        <span id="services-error" class="text-danger"></span>

    </div>


    {{-- # Price --}}
    <div class="col-6 mb-4">
        <label for="price" class="form-label">
            Prezzo
            <span class="form-text text-danger fs-5">*</span>
        </label>
        <input value="{{ old('price', $apartment->price) }}" type="number" min="0" step="0.01"
            class="form-control @error('price') is-invalid @enderror" id="price" name="price" required>
        @error('price')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
        <span id="price-error" class="text-danger"></span>
    </div>


    {{-- # Other Info --}}
    <div class="col-12">
        <div class="row">

            {{-- # Rooms --}}
            <div class="col-12 col-sm-4 mb-4">
                <label for="rooms" class="form-label">
                    Numero di stanze
                    <span class="form-text text-danger fs-5">*</span>
                </label>
                <input value="{{ old('rooms', $apartment->rooms) }}" type="number"
                    class="form-control @error('rooms') is-invalid @enderror" id="rooms" name="rooms"
                    min="0">
                @error('rooms')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <span id="rooms-error" class="text-danger"></span>
            </div>


            {{-- # Beds --}}
            <div class="mb-4 col-12 col-sm-4 mb-4">
                <label for="beds" class="form-label">
                    Numero di letti
                    <span class="form-text text-danger fs-5">*</span>
                </label>
                <input value="{{ old('beds', $apartment->beds) }}" type="number"
                    class="form-control @error('beds') is-invalid @enderror" id="beds" name="beds"
                    min="0">
                @error('beds')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <span id="beds-error" class="text-danger"></span>
            </div>


            {{-- # Bathrooms --}}
            <div class="col-12 col-sm-4 mb-4">
                <label for="bathrooms" class="form-label">
                    Numero di bagni
                    <span class="form-text text-danger fs-5">*</span>
                </label>
                <input value="{{ old('bathrooms', $apartment->bathrooms) }}" type="number"
                    class="form-control @error('bathrooms') is-invalid @enderror" id="bathrooms" name="bathrooms"
                    min="0">
                @error('bathrooms')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <span id="bathrooms-error" class="text-danger"></span>
            </div>

        </div>
    </div>


    {{-- # Square meters --}}
    <div class="col-4 mb-4">
        <label for="square_meters" class="form-label">Metri quadri</label>
        <input value="{{ old('square_meters', $apartment->square_meters) }}" type="number"
            class="form-control @error('square_meters') is-invalid @enderror" id="square_meters"
            name="square_meters" min="0">
        @error('square_meters')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
    </div>


    {{-- # Address --}}
    <div class="col-12 mb-2">
        <label for="address-search" class="form-label">
            Indirizzo
            <span class="form-text text-danger fs-5">*</span>
        </label>

        <div class="position-relative">

            {{-- Search Input --}}
            <input id="address-search" autocomplete="off" value="{{ old('address', $apartment->address) }}"
                type="text" class="form-control @error('address') is-invalid @enderror">

            {{-- Errors --}}
            @error('address')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror

            {{-- API Suggestion List --}}
            <ul id="api-suggestions" class="suggestions-list"></ul>
        </div>
        <span id="address-error" class="text-danger"></span>

        {{-- Chosen Place Input --}}
        <input type="text" readonly name="address" id="address" class="form-control-plaintext p-2 fw-bold"
            value="{{ old('address', $apartment->address) }}">

        {{-- Hidden Latitude and Longitude Fields --}}
        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $apartment->latitude) }}">
        <input type="hidden" name="longitude" id="longitude"
            value="{{ old('longitude', $apartment->longitude) }}">
    </div>

    <div class="col-12 mb-2">
        <div class="dropdown mb-3">
            <button class="button-info" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-question fa-xs"></i>
            </button>
            <div class="dropdown-menu text-danger  ">
                I campi contrassegnati (*) sono obbligatori.
            </div>
        </div>
    </div>




    {{-- # Submit --}}
    <div class="col-12 d-flex justify-content-between align-items-center mb-3">
        {{-- # Is Visible --}}
        <div class="form-check form-switch button-primary">
            <label class="form-check-label" for="is_visible">Pubblica</label>
            <input class="form-check-input" type="checkbox" role="switch" id="is_visible" name="is_visible"
                value="1" @if (old('is_visible', $apartment->is_visible)) checked @endif>
        </div>
        <button type="submit" class="button-primary">Conferma</button>
    </div>

</div>
</form>
