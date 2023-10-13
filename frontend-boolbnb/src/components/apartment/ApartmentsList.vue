<script>
import ApartmentCard from './ApartmentCard.vue';
export default {
    props: {
        apartments: Array,
        title: String,
        infoMessage: String
    },
    components: { ApartmentCard }
}
</script>

<template>
    <div class="container">

        <h5 v-if="title">{{ title }}</h5>

        <div class="d-flex align-items-center gap-1 mb-3">
            <h6>Come ordiniamo i risultati</h6>
            <button class="button-info" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <font-awesome-icon :icon="['fas', 'question']" size="xs" />
            </button>
            <div class="dropdown-menu">{{ infoMessage }} </div>
        </div>

        <div v-if="apartments.length"
            class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 g-5 g-sm-3">
            <div v-for="apartment in apartments" :key="apartment.id" class="col">
                <!--Card-->
                <ApartmentCard :apartment="apartment" />
            </div>
        </div>
        <h4 v-else class="text-center mt-5">Nessun risultato</h4>
    </div>
</template>

<style lang="scss" scoped>
@use '../../assets/scss/vars' as *;

.container {
    margin: 20px auto;
}

h6 {
    font-size: 12px;
    color: #717171;
    font-weight: 300;
}

.button-info {
    @include circle(15px);
    @include flex;
    border: 2px solid#717171;
    color: #717171;
}

.dropdown-menu {
    font-size: 14px;
    padding: 8px 10px;
}
</style>
