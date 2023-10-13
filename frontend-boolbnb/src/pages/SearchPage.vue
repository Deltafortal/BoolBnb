<script>
import AppLoader from '../components/AppLoader.vue';
import SearchModal from '../components/search/SearchModal.vue';
import ApartmentsList from '../components/apartment/ApartmentsList.vue';

import axios from 'axios';
const endpoint = 'http://127.0.0.1:8000/api/apartments/filter';


export default {
    components: { ApartmentsList, AppLoader, SearchModal },

    data: () => ({
        apartments: [],
        isLoading: true,
        errorMessage: '',
        address: ''
    }),

    watch: {
        '$route.query': {
            handler(newQuery) {
                this.fetchApartments();
            }
        }
    },

    methods: {
        fetchApartments() {

            this.isLoading = true;
            this.errorMessage = '';

            // Get query
            const params = this.$route.query;
            this.address = this.$route.query.address


            // Call API
            axios.get(endpoint, { params })
                .then(res => {
                    this.apartments = res.data;
                })
                .catch(err => {
                    console.error(err.response.data);
                    const status = err.response.status;

                    if (status === 400) {
                        this.errorMessage = 'Inserisci un indirizzo valido.';
                    } else {
                        this.errorMessage = `Errore ${status}`;
                    }
                })
                .then(() => {
                    this.isLoading = false;
                });
        }
    },
    created() {
        this.fetchApartments();
    }
}
</script>

<template>
    <main>
        <!-- Page Cotent -->
        <div v-if="!isLoading">

            <!-- Error Message -->
            <div v-if="errorMessage" class="container">
                <h4 class="text-danger text-center mt-5">{{ errorMessage }}</h4>
            </div>

            <!-- Apartments -->
            <ApartmentsList v-else :apartments="apartments" :title="`Risultati in questa località: ${address}`"
                infoMessage="Vengono visualizzati per primi i boolbnb consigliati dal nostro team" />
        </div>
    </main>

    <!-- Loader -->
    <AppLoader :is-loading="isLoading" />

    <!-- Search Modal -->
    <SearchModal />
</template>