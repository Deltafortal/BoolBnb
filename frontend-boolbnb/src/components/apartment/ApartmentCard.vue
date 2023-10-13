<script>
export default {
    props: {
        apartment: Object
    },
    methods: {
        /**
        * Get main searched services
        */
        mainServices() {
            const services = this.apartment.services.sort((a, b) => {
                const firstService = this.filteredServiceIds.includes(a.id.toString()) ? 1 : 0;
                const secondService = this.filteredServiceIds.includes(b.id.toString()) ? 1 : 0;
                return secondService - firstService
            });
            return services.slice(0, 4);
        }
    },
    computed: {

        /**
         * Get distance in Km (only Search Page)
         */
        distance() {
            if (!this.apartment.distance === undefined) return '';
            return Math.ceil(parseInt(this.apartment.distance) / 1000) + ' Km';
        },


        /**
         * Get the list of services filters applyed
         */
        filteredServiceIds() {
            if (!this.$route.query['services[]']) return [];
            return this.$route.query['services[]'];
        }
    }
};
</script>

<template>
    <div class="card">

        <RouterLink :to="{ name: 'apartment', params: { id: apartment.id } }">

            <!-- Card Img -->
            <div class="card-img">

                <img v-if="apartment.image" :src="`http://127.0.0.1:8000/storage/${apartment.image}`"
                    :alt="apartment.title">

                <!-- Placeholder -->
                <img v-else
                    src="https://media.istockphoto.com/id/1147544807/vector/thumbnail-image-vector-graphic.jpg?s=612x612&w=0&k=20&c=rnCKVbdxqkjlcs3xH87-9gocETqpspHFXu5dIGB4wuM="
                    alt="placeholder">

                <!-- Promoted Badge -->
                <div v-if="apartment.promotions_max_apartment_promotionend_date" class="promoted-badge">
                    Consigliato
                </div>

            </div>

            <!-- Card Info -->
            <div class="card-content">
                <!-- Title -->
                <h6>{{ apartment.title }}</h6>

                <!-- Address -->
                <div>
                    {{ apartment.address }}
                </div>

                <!-- Distance -->
                <div v-if="apartment.distance !== undefined">
                    Distanza dal centro {{ distance }} <font-awesome-icon :icon="['fas', 'location-dot']" class="me-1" />
                </div>

                <!-- Services -->
                <div v-if="apartment.distance !== undefined" class="services-icon">
                    Servizi principali
                    <ul>
                        <!-- :class="{ 'order-1': !filteredServiceIds.includes(service.id.toString()) }" -->
                        <li v-for="service in mainServices()" :key="service.id">
                            <div class="service-icon"
                                :class="{ 'selected': filteredServiceIds.includes(service.id.toString()) }"
                                :title="service.name">
                                <img :src="`http://127.0.0.1:8000/img/service/${service.icon}`" :alt="service.name">
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Price -->
                <div class="price"><b>{{ apartment.price }}€</b> a notte</div>
            </div>

        </RouterLink>

    </div>
</template>

<style lang="scss" scoped>
@use '../../assets/scss/vars' as *;

.card {
    border: none;
    border-radius: 0;
}

.card-img {
    position: relative;
    @include square(calc(100vw - 24px), 15px);
    max-width: 100%;
    overflow: hidden;

    img {
        @include square(100%);
        transition: all 0.3s;
        object-fit: cover;
    }

    // Promoted Badge
    .promoted-badge {
        position: absolute;
        left: -40px;
        top: 18px;
        padding: 0.5rem;
        width: 150px;

        text-align: center;
        font-weight: bold;
        color: #fff;
        background-color: $brand-color;

        transform: rotate(315deg);
        box-shadow: 0 0 8px 4px rgba($color: #000, $alpha: 0.1);
    }
}

.card-content {
    @include flex(center, start, column, $gap: 7px);
    color: #717171;
    font-size: 17px;
    font-weight: 300;
    padding: 10px 0;
    overflow: hidden;

    h6,
    .price {
        font-size: 16px;
        color: black
    }

    .service-icon {
        @include square(20px);
        overflow: hidden;

        img {
            @include max-size;
            object-fit: contain;
            filter: contrast(0.1);
            display: block;

        }

        &.selected {
            @include square(25px);
            padding: 2px;

            // border: 1px solid $brand-color;
            background-color: #000;
            border-radius: 0.25rem;

            img {
                // filter: contrast(1);
                filter: invert(100%) sepia(0%) saturate(19%) hue-rotate(285deg) brightness(105%) contrast(104%);
            }
        }
    }
}

.services-icon {
    @include flex(start, $wrap: nowrap, $gap: 3px);
    max-width: 100%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;

    ul {
        @include flex($gap: 5px);
    }
}


// Media Query
// Square images
@media (min-width: 576px) {
    .card-img {
        max-height: 234px;
    }
}

@media (min-width: 768px) {
    .card-img {
        max-height: 334px;
    }
}

@media (min-width: 992px) {
    .card-img {
        max-height: 293px;
    }
}

@media (min-width: 1200px) {
    .card-img {
        max-height: 259px;
    }
}

@media (min-width: 1400px) {
    .card-img {
        max-height: 238px;
    }
}
</style>