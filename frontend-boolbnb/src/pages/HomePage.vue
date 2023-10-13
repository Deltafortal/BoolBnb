<script>
import AppNavbar from '../components/AppNavbar.vue';
import AppLoader from '../components/AppLoader.vue';
import ApartmentsList from '../components/apartment/ApartmentsList.vue';

import axios from 'axios';
const baseUri = 'http://127.0.0.1:8000/api/apartments'

export default {
    components: { AppNavbar, ApartmentsList, AppLoader },
    data: () => ({ apartmentsPromoted: [], apartmentsRandom: [], isLoading: true }),
    methods: {
        fetchApartments(endpoint = '', successCallback) {
            axios.get(baseUri + endpoint)
                .then(successCallback)
                .catch(err => {
                    console.error(err);
                })
                .then(() => {
                    this.isLoading = false
                });
        }
    },

    created() {
        // Fetch Promoted List
        this.fetchApartments('/promoted', res => { this.apartmentsPromoted = res.data; });

        // Fetch Random List
        this.fetchApartments('/random', res => { this.apartmentsRandom = res.data; });
    }
}
</script>

<template>
    <main>

        <!-- Promoted Appartments -->
        <ApartmentsList v-if="!isLoading && apartmentsPromoted.length" :apartments="apartmentsPromoted"
            infoMessage="I boolbnb in evidenza sono consigliati dal nostro team!" title="Boolbnb in evidenza" />

        <!-- Random Appartments -->
        <ApartmentsList v-if="!isLoading" :apartments="apartmentsRandom" title="I nostri boolbnb"
            infoMessage="I boolbnb vengono ordinati in modo randomico" />
    </main>
    <!-- Loader -->
    <AppLoader :is-loading="isLoading" />
</template>