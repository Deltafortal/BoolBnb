<script>
import AppLoader from '../components/AppLoader.vue';

import axios from 'axios';
// TomTom Map
import tt from "@tomtom-international/web-sdk-maps";
import '@tomtom-international/web-sdk-maps/dist/maps.css';

const apartment_endpoint = 'http://localhost:8000/api/apartments/';
const services_endpoint = 'http://localhost:8000/api/services';
const message_endpoint = 'http://localhost:8000/api/messages';

export default {
    components: { AppLoader },
    data() {
        return {
            apartment: '',
            services: [],
            isLoading: true,
            form: {
                name: '',
                email: '',
                content: '',
            },
            errors: {},
            successMessage: '',
            loadingMessage: false
        }
    },
    methods: {
        // Get all services
        fetchServices() {
            axios.get(services_endpoint).then(res => { this.services = res.data })
        },
        // Get apartment details
        getApartment() {
            axios.get(apartment_endpoint + this.$route.params.id)
                .then(res => { this.apartment = res.data })
                .catch(error => { this.$router.push({ name: 'not-found', query: { error: 404, message: 'La pagina non è stata trovata.' } }) })
                .then(() => { this.isLoading = false; });
        },
        // Send a message to the host
        sendMessage() {
            // Validation
            this.validation();

            // If there isn't errors
            if (!this.hasErrors) {
                // Small loader
                this.loadingMessage = true;
                // Send message
                axios.post(message_endpoint, {
                    name: this.form.name,
                    email: this.form.email,
                    content: this.form.content,
                    apartment_id: this.apartment.id
                })
                    .then(() => { this.form = { name: '', email: '', content: '', apartment_id: '' }; this.errors = {}; this.successMessage = 'Messaggio inviato'; })
                    .catch(err => {
                        if (err.response.status === 400) {
                            const { errors } = err.response.data;
                            const errorMessages = {};
                            for (let field in errors) errorMessages[field] = errors[field][0];
                            this.errors = errorMessages;

                        } else {
                            this.errors = { network: 'si è verificato un errore' }
                        }
                        this.successMessage = ''
                    })
                    .then(() => { this.loadingMessage = false })
            }
        },
        validation() {
            this.errors = {};
            if (!this.form.name) { this.errors.name = 'Il nome è obbligatorio' }
            if (!this.form.content) { this.errors.content = 'Il contenuto della mail è obbligatorio' }
            if (!this.form.email) {
                this.errors.email = 'La mail è obbligatoria'
            } else if (!this.form.email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)) {
                this.errors.email = 'La mail inserita non è valida'
            }
        },
        // Get First letter of a string
        getFirstLetter: (word) => (word.substring(0, 1).toUpperCase()),
        // Capitalize a string
        capitalizeString: (word) => (word.charAt(0).toUpperCase() + word.slice(1)),
        // // TomTom Map
        getMap() {
            if (this.apartment.address) {
                const mapContainer = document.getElementById('map');
                const lat = mapContainer.dataset.latitude;
                const lon = mapContainer.dataset.longitude;
                const map = tt.map({
                    key: import.meta.env.VITE_TT_API_KEY,
                    container: mapContainer,
                    center: [lon, lat],
                    zoom: 8
                });
                map.addControl(new tt.NavigationControl());
                const marker = new tt.Marker().setLngLat([lon, lat]).addTo(map);
            }
        },
        // Services not available in the apartment
        serviceNotAvailable() {
            // Services of the apartament (Available Services)
            const avServ = this.apartment.services;

            // Array with ids of available services
            let avServId = [];
            avServ.forEach(s => {
                avServId.push(s.id)
            });

            // Array with services not available
            let notAv = [];
            this.services.forEach(s => {
                if (!avServId.includes(s.id)) {
                    notAv.push(s);
                }
            });

            return notAv;
        },
        getServiceClass() {
            if (this.apartment.services.length <= 5) {
                return 'services-small'
            } else if (this.apartment.services.length <= 10) {
                return 'services-medium'
            } else if (this.apartment.services.length > 10) {
                return 'services-large'
            }
        },
        isEmpty(obj) {
            return Object.entries(obj).length
        },

    },
    created() {
        this.getApartment();
        this.fetchServices();
    },
    mounted() {
        setTimeout(() => {
            this.getMap();
        }, 1000);
    },
    computed: {
        hasErrors() {
            return Object.entries(this.errors).length
        }
    }
}
</script>

<template>
    <main>
        <div v-if="!isLoading">
            <!-- Header -->
            <header>
                <div class="container">
                    <div class="d-flex align-items-center justify-content-between">
                        <h2>{{ apartment.title }}</h2>
                        <div class="circle-button">
                            <button @click="$router.back()"><font-awesome-icon :icon="['fas', 'chevron-left']" />
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <div class="container">
                <!-- Image -->
                <div class="slider">
                    <div></div>
                    <div v-if="apartment.image" class="image-container">
                        <img :src="`http://127.0.0.1:8000/storage/${apartment.image}`" :alt="apartment.title">
                    </div>
                    <!-- Without image -->
                    <div v-else class="no-image">
                        <div class="icon">
                            <img src="../assets/img/camera.png" alt="camera">
                        </div>
                        <h3>L'host non ha ancora inserito immagini, contattalo per saperne di più!</h3>
                        <a href="#message-form"><font-awesome-icon :icon="['fas', 'arrow-down']" bounce size="2xl" /></a>
                    </div>
                    <div></div>
                </div>

                <!-- Information -->
                <section id="apartments-details">
                    <div>
                        <!-- Address -->
                        <h3 class="mb-2">{{ apartment.address }}</h3>
                        <!-- Rooms -->
                        <ul>
                            <li>{{ apartment.rooms + ' ' + (apartment.rooms == 1 ? 'camera' : 'camere') }}</li>
                            <span>-</span>
                            <li>{{ apartment.beds + ' ' + (apartment.beds == 1 ? 'letto' : 'letti') }}</li>
                            <span>-</span>
                            <li>{{ apartment.bathrooms + ' ' + (apartment.bathrooms == 1 ? 'bagno' : 'bagni') }}</li>
                        </ul>
                    </div>
                    <!-- Host information -->
                    <hr v-if="apartment.user.name">
                    <div v-if="apartment.user.name" class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-4">
                            <div class="user">{{ getFirstLetter(apartment.user.name) }}</div>
                            <h3>Nome dell'host: {{ capitalizeString(apartment.user.name) }}</h3>
                        </div>

                        <a href="#message-form" class="button button-light">Contatta {{
                            capitalizeString(apartment.user.name)
                        }}</a>
                    </div>
                    <hr>
                    <!-- Description -->
                    <div>
                        <h3 class="mb-2">Descrizione</h3>
                        <p>{{ apartment.description }}</p>
                    </div>
                    <hr>
                    <!-- Services -->
                    <div :id="getServiceClass()">
                        <h3 class="mb-3">Cosa troverai</h3>
                        <div>
                            <ul class="service-list onPage">
                                <li v-for="service in apartment.services">
                                    <div><img :src="`http://127.0.0.1:8000/img/service/${service.icon}`"
                                            :alt="service.name"></div>
                                    <span>{{ service.name }}</span>
                                </li>
                            </ul>
                            <div class="service-all">
                                <h2>Scopri tutti i servizi</h2>
                                <div>
                                    <!-- Modal Button -->
                                    <button type="button" class="services-button button button-light" data-bs-toggle="modal"
                                        data-bs-target="#serviceModal">Mostra tutti i {{ services.length }}
                                        servizi </button>
                                </div>
                            </div>

                            <!-- Service modal -->
                            <div class="modal fade modal-lg" id="serviceModal" tabindex="-1"
                                aria-labelledby="serviceModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h3 class="mb-3">Cosa troverai</h3>
                                            <ul class="service-list modal-services">
                                                <li v-for="service in apartment.services">
                                                    <div><img :src="`http://127.0.0.1:8000/img/service/${service.icon}`"
                                                            :alt="service.name"></div>
                                                    <span>{{ service.name }}</span>
                                                </li>
                                            </ul>
                                            <div v-if="serviceNotAvailable().length">
                                                <h3 class="mt-5 mb-3">Non incluso</h3>
                                                <ul class="service-list modal-services">
                                                    <li v-for="service in serviceNotAvailable()">
                                                        <div><img :src="`http://127.0.0.1:8000/img/service/${service.icon}`"
                                                                :alt="service.name"></div>
                                                        <span class="text-decoration-line-through">{{ service.name }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Map -->
                    <hr v-if="apartment.address">
                    <div v-if="apartment.address">
                        <h3 class="mb-3">Dove ti troverai</h3>
                        <div id="map" :data-latitude="apartment.latitude" :data-longitude="apartment.longitude"
                            style="height:480px"></div>
                        <div class="mt-2 fw-">{{ apartment.address }}</div>
                    </div>
                    <hr>
                    <!-- Messages -->
                    <section id="message-form">
                        <h3 class="mb-3">Hai domande? Invia un messaggio all'host</h3>

                        <!-- Form -->
                        <form class="form-floating needs-validation" @submit.prevent="sendMessage" novalidate>
                            <!-- Name -->
                            <div class="mb-4">
                                <label for="name" class="form-label">Inserisci il tuo nome <span
                                        class="form-text text-danger fs-5">*</span></label>
                                <input type="text" class="form-control" :class="{ 'is-invalid': errors.name }" id="name"
                                    v-model.trim="form.name" required>
                                <span v-if="errors.name" class="invalid-feedback" role="alert">{{ errors.name }}</span>
                                <span id="title-error" class="text-danger"></span>

                            </div>
                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label" required>Inserisci la tua email <span
                                        class="form-text text-danger fs-5">*</span></label>
                                <input type="email" class="form-control" :class="{ 'is-invalid': errors.email }" id="email"
                                    placeholder="nome@esempio.com" v-model.trim="form.email">
                                <span v-if="errors.email" class="invalid-feedback" role="alert">{{ errors.email }}</span>
                            </div>
                            <!-- Content -->
                            <div class="mb-2">
                                <label for="exampleFormControlTextarea1" class="form-label">Contenuto del messaggio <span
                                        class="form-text text-danger fs-5">*</span></label>
                                <textarea class="form-control" :class="{ 'is-invalid': errors.content }"
                                    placeholder="Scrivi un messaggio" id="floatingTextarea" style="height: 160px;"
                                    v-model.trim="form.content" required></textarea>
                                <span v-if="errors.content" class="invalid-feedback" role="alert">{{ errors.content
                                }}</span>
                            </div>
                            <div class="dropdown mb-3">
                                <button class="button-info" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <font-awesome-icon :icon="['fas', 'question']" size="xs" />
                                </button>
                                <div class="dropdown-menu text-danger  ">
                                    I campi contrassegnati (*) sono obbligatori.
                                </div>
                            </div>

                            <!-- Send form -->
                            <div class="d-flex align-items-center gap-4">
                                <button type="submit" class="button button-light">Invia messaggio</button>
                                <!-- Small loader -->
                                <div v-if="loadingMessage">
                                    <div class="spinner-border" role="status">
                                    </div>
                                </div>
                                <!-- Alert success -->
                                <div v-if="successMessage" class="alert alert-success alert-dismissible fade show"
                                    role="alert">
                                    <strong>{{ successMessage }} <font-awesome-icon :icon="['fas', 'thumbs-up']" bounce
                                            size="lg" /></strong>
                                    <button type="button" class="button-close" data-bs-dismiss="alert"
                                        aria-label="Close"><font-awesome-icon :icon="['fas', 'x']" /></button>
                                </div>

                                <!-- Alert error -->
                                <div v-if="isEmpty(errors)" class="alert alert-danger alert-dismissible fade show"
                                    role="alert">
                                    <strong>Si è verificato un errore!</strong>
                                    <button type="button" class="button-close" data-bs-dismiss="alert"
                                        aria-label="Close"><font-awesome-icon :icon="['fas', 'x']" /></button>
                                </div>
                            </div>
                        </form>
                    </section>
                </section>
            </div>
        </div>
    </main>

    <!-- Loader -->
    <AppLoader :is-loading="isLoading" />
</template>

<style lang="scss" scoped>
@use '../assets/scss/vars' as *;

//_______ HEADER
header {
    padding: 24px 0;
}

// Apartment image
.slider {
    display: flex;
}

.slider div:empty {
    background-color: $light-grey;
    flex-grow: 1;
    border-radius: 20px;
}

// If there is
.image-container {
    @include square(calc(100vw - 24px), 20px);
    @include max-size($max: true, $max-width: 100%, $max-height: 360px);
    overflow: hidden;
}

img {
    @include max-size;
    object-fit: cover;
}

// If there in not image
.no-image {
    border: 1px solid $light-grey;
    border-radius: 15px;
    padding: 15px;
    @include flex($direction: column, $gap: 20px);

    .icon {
        @include flex;
        width: 30%;

        img {
            width: 100%;
            filter: invert(44%) sepia(52%) saturate(6771%) hue-rotate(329deg) brightness(101%) contrast(101%);
        }
    }
}

// INFORMATION
#apartments-details>div {
    padding: 24px 0;
}

h3 {
    font-size: 18px;
    text-wrap: wrap
}

ul {
    display: flex;
    gap: 20px;
    font-size: 16px;
}

// Host information
.user {
    @include circle(calc(40px + 2vw));
    @include flex;
    font-size: calc(10px + 2vw);
    color: white;
    background-color: black;
}

// _____________SERVICES
// LEFT PART
// Service list generics
.service-list {
    @include flex(stretch, stretch, column, wrap, 10px);
    flex-grow: 1;

    li {
        @include flex(start, center, $gap: 7px);
        border: 1px solid $light-grey;
        border-radius: 15px;
        padding: 10px;

        div {
            @include square(20px);
            overflow: hidden;

            img {
                @include max-size;
                object-fit: contain;
                filter: brightness(0) saturate(100%);
                display: block
            }
        }
    }
}

// Service list on apartment page
.service-list.onPage {
    max-height: 270px;
    overflow: hidden;
    flex-wrap: nowrap;
}

// RIGHT PART
.service-all {
    @include flex(center, center, column, $gap: 10px);
    padding: 20px 0;

    h2 {
        display: none;
    }
}

// Button modal
.services-button {
    display: flex;
}

#services-small>div,
#services-medium>div,
#services-large>div {
    display: flex;
    flex-direction: column;
}

// Service list on modal
.service-list.modal-services {
    @include flex(center, stretch, column, wrap, 10px);

    li div {
        @include square(30px);
    }
}

// Map
#map {
    height: 480px;
    border-radius: 15px;
}

// Section message
#message-form {
    padding: 24px 0;
}

// Alert messages
.alert {
    margin: 0;
    padding: 12px;
    border-radius: 20px;
}

.button-close {
    padding-left: 10px;
}

// Small loader
.spinner-border {
    @include circle(40px);
    color: $brand-color;
}

.dropdown-menu {
    @include font;
    padding: 8px 5px;
}

/////////////////
// MEDIA QUERY //
/////////////////

@media (min-width: 576px) {
    .service-list.onPage {
        flex-wrap: wrap;
    }

    #services-large .service-list.onPage {
        gap: 5px;

        li {
            width: calc(50% - 7px / 2);
        }
    }

    .service-all {
        flex-basis: 50%;
    }
}

@media (min-width: 768px) {

    #services-small,
    #services-medium {
        flex-basis: 45%;

        &>div {
            flex-direction: row;
        }

        h2 {
            display: flex;
        }
    }

    #services-large .service-list.onPage {
        li {
            width: 32%
        }
    }

    .service-list.onPage {
        gap: 7px;
    }

    .service-list.modal-services {
        @include flex(start, center, row, wrap, 10px);

        li {
            flex: 0 0 calc(50% - 5px);
        }
    }

    .image-container {
        @include max-size($max: true, $max-width: 696px, $max-height: 400px);
    }

    .no-image {
        margin: 0 20px;
    }
}

@media (min-width: 992px) {
    .service-list.onPage {
        gap: 10px;
    }

    #services-large .service-list.onPage {
        gap: 7px;
    }

    .service-all {
        flex-basis: 50%;
    }

    .slider {
        gap: 20px;
    }

    .no-image {
        margin: 0;
    }
}
</style>