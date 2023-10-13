<script>
import axios from 'axios';
import { store } from '../../js/store';
const endpoint = 'http://127.0.0.1:8000/api/services';

export default {
    data: () => ({
        servicesList: [],
        filters: {
            rooms: null,
            beds: null,
            radiusKm: 20,
            'services[]': [],
        },
        store: store,

    }),
    computed: {
        radius() {
            return parseInt(this.filters.radiusKm) * 1000;
        }
    },
    methods: {
        fetchServices() {

            axios.get(endpoint)
                .then(res => {
                    this.servicesList = res.data;
                })
                .catch(err => {
                    console.error(err);
                });

        },

        resetFilters() {

            // Reset Filters
            this.filters = {
                rooms: null,
                beds: null,
                radiusKm: 20,
                'services[]': [],
            }

            // Call API
            this.applyFilters();
        },

        applyFilters() {

            // Create query params
            const query = {
                address: this.$route?.query.address,
                lat: this.$route?.query.lat,
                lon: this.$route?.query.lon,
                category: this.$route?.query.category,
                rooms: this.filters.rooms,
                beds: this.filters.beds,
                radius: this.radius,
                'services[]': this.filters['services[]'],
            }

            // Apply query

            this.$router.push({ name: 'search', query })
            this.addFilters();
        },


        // Check if are any filters in the URL
        assignFilters() {

            if (this.$route?.query.rooms && this.$route?.query.rooms > 0) {
                this.filters.rooms = this.$route?.query.rooms;
            };

            if (this.$route?.query.beds && this.$route?.query.beds > 0) {
                this.filters.beds = this.$route?.query.beds;
            };

            if (this.$route?.query.radius && this.$route?.query.radius != 20000) {
                this.filters.radiusKm = parseInt(this.$route?.query.radius) / 1000;
            };

            if (this.$route?.query['services[]'] && this.$route?.query['services[]'].length) {
                this.filters['services[]'] = [...this.$route?.query['services[]']];
            };

        },

        // Update Filters Counter
        addFilters() {

            let totalFilters = 0;


            // Count Filters
            if (this.filters.rooms) {
                totalFilters += 1;
            };

            if (this.filters.beds) {
                totalFilters += 1;
            }

            if (this.filters.radiusKm != 20) {
                totalFilters += 1;
            }

            totalFilters += this.filters['services[]'].length;


            // Update Counter
            this.store.filters = totalFilters;
        }

    },

    created() {
        this.fetchServices();
        this.assignFilters();
        this.addFilters();

    }
}
</script>


<template>
    <div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Filtri</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">

                    <!-- Filters -->
                    <form @submit.prevent="applyFilters" class="container-fluid">
                        <div class="row">

                            <!-- Rooms -->
                            <div class="col-12 col-sm-4 mb-3">
                                <label for="rooms" class="form-label fw-bold">Numero di stanze</label>
                                <input v-model.trim="filters.rooms" type="number" class="form-control" id="rooms" min="0">
                            </div>

                            <!-- Beds -->
                            <div class="col-12 col-sm-4 mb-3">
                                <label for="beds" class="form-label fw-bold">Numero di letti</label>
                                <input v-model.trim="filters.beds" type="number" class="form-control" id="beds" min="0">
                            </div>

                            <!-- Radius -->
                            <div class="col-12 col-sm-4 mb-3">
                                <label for="radiusKm" class="form-label fw-bold">Raggio ricerca [km]</label>
                                <input v-model.trim="filters.radiusKm" type="number" class="form-control" id="radiusKm"
                                    min="0">
                            </div>

                            <!-- Services -->
                            <div class="col-12 mb-3">
                                <p class="fw-bold mb-2">Servizi</p>
                                <div class="row">
                                    <div v-for="service in servicesList" :key="service.id" class="col-6 form-check">

                                        <input v-model.trim="filters['services[]']" class="form-check-input" type="checkbox"
                                            :id="service.id" :value="service.id">

                                        <label class="form-label d-flex align-items-center gap-1" :for="service.id">
                                            <div class="service-icon">
                                                <img :src="`http://127.0.0.1:8000/img/service/${service.icon}`"
                                                    :alt="service.name">
                                            </div>
                                            {{ service.name }}
                                        </label>

                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="col-12 border-top text-end pt-3">
                                <button @click="resetFilters" type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancella
                                    Tutto</button>
                                <button type="submit" class="btn btn-success ms-2" data-bs-dismiss="modal">Mostra</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</template>


<style lang="scss" scoped>
@use '../../assets/scss/vars' as *;

.service-icon {
    @include square(30px);
    overflow: hidden;

    img {
        @include max-size;
        object-fit: contain;
        filter: brightness(0) saturate(100%);
    }
}
</style>