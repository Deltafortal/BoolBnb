<script>
import { store } from '../js/store.js';
import axios from 'axios';
const endpoint = 'http://localhost:8000/api/categories';


export default {

    data: () => ({
        categories: [],
        store: store
    }),

    methods: {
        fetchCategories() {
            axios.get(endpoint).then(res => { this.categories = res.data })
        },

        setQueryParams(category_id) {
            return {
                address: this.$route?.query.address,
                lat: this.$route?.query.lat,
                lon: this.$route?.query.lon,
                category: category_id,
                rooms: this.$route?.query.rooms,
                beds: this.$route?.query.beds,
                radius: this.$route?.query.radius,
                'services[]': this.$route?.query['services[]'],
            };
        }
    },

    created() {
        this.fetchCategories();
    }
}
</script>

<template>
    <nav class="bool-nav">
        <div class="container">
            <div class="row">

                <!-- Categories -->
                <ul class="col-10">
                    <li v-for="category in categories" :key="category.id">
                        <RouterLink :to="{ name: 'search', query: setQueryParams(category.id) }" class="category-link"
                            :class="{ 'active': $route.query?.category == category.id }">
                            <img :src="`src/assets/img/category/${category.img}`" :alt="category.name">
                            <div>{{ category.name }}</div>
                        </RouterLink>
                    </li>
                </ul>

                <!-- Advanced Filters -->
                <div class="col-2 d-flex align-items-center justify-content-end">
                    <button class="filter" data-bs-toggle="modal" data-bs-target="#searchModal"
                        :class="{ 'has-filter': store.filters > 0 }">
                        <font-awesome-icon icon="sliders" />
                        <span v-if="store.filters > 0" class="filter-number">{{ store.filters }}</span>
                        <span class="d-none d-md-inline">Filtri</span>
                    </button>
                </div>

            </div>
        </div>
    </nav>
</template>

<style lang="scss" scoped>
@use '../assets/scss/vars' as *;

//__________________ NAVBAR

.bool-nav {
    padding: 0 12px;
    background-color: white;

    div[class*="col"] {
        padding: 0;
    }

    .row {
        height: 80px;
    }

    ul {
        @include flex(start);
        height: 100%;
        overflow-x: scroll;
        overflow-y: hidden;
        gap: 15px;
    }

    li {
        height: 100%;
    }

    .category-link {
        height: 100%;
        padding: 0 10px;

        @include flex($direction: column);
        gap: 5px;
        color: grey;
        font-size: 12px;
        border-bottom: 3px solid transparent;
        font-weight: 500;
        text-wrap: nowrap;

        transition: all 0.5s;



        img {
            filter: invert(40%) sepia(55%) saturate(0%) hue-rotate(206deg) brightness(113%) contrast(83%);
        }

        &:hover,
        &.active {
            border-bottom: 3px solid grey;
            color: black;

            img {
                filter: brightness(0) saturate(100%);
            }
        }
    }

    img {
        width: 25px;
    }


    .filter {
        @include flex;
        @include circle(40px);
        border: 1px solid $light-grey;
        position: relative;

        .filter-number {
            @include circle(20px);
            @include flex();
            position: absolute;
            top: -8px;
            left: 65%;
            background-color: black;
            font-size: 10px;
            color: white;
        }
    }



    .has-filter {
        border: 2px solid black;
    }

    @media (min-width: 768px) {
        .filter {
            @include circle(auto);
            gap: 10px;
            border-radius: 10px;
            padding: 15px 12px;

            .filter-number {
                left: 85%;
            }
        }
    }
}
</style>