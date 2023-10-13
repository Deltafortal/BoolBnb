<script>
import AppLoader from '../components/AppLoader.vue';

export default {
    data() {
        return {
            errorType: this.$route.query.error,
        }
    },
    methods: {
        // Set error message
        setErrorMessage() {
            if (this.errorType == 404) {
                return 'La pagina non è stata trovata'
            } else {
                return 'Errore generico'
            }
        }
    }
}
</script>

<template>
    <main>
        <section id="error" class="container mt-5">

            <div class="row">

                <!-- Text Column -->
                <div class="col-12 col-sm-6">

                    <!-- Title  -->
                    <h1 class="display-3 fw-bold mb-4">Oops!</h1>

                    <!-- Error Message -->
                    <h2 class="mb-4">{{ setErrorMessage() }}</h2>

                    <!-- Error Code -->
                    <p class="mb-4"><strong>Errore: {{ errorType }}</strong></p>

                    <!-- Useful link nav -->
                    <nav>
                        <p class="mb-2">
                            Eccoti alcuni link utili:
                        </p>

                        <ul>
                            <li><a class="text-primary d-inline-block pb-2"
                                    href="http://127.0.0.1:8000/login"><b>Accedi</b></a></li>
                            <li><a class="text-primary d-inline-block pb-2"
                                    href="http://127.0.0.1:8000/register">Registrati</a></li>
                            <li>
                                <RouterLink class="text-primary d-inline-block pb-2" :to="{ name: 'home' }">Torna alla Home
                                </RouterLink>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Error Code Column -->
                <div class="col-12 col-sm-6 d-flex flex-column justify-content-center align-items-center">
                    <img src="http://127.0.0.1:8000/img/pages/lighthouse.png" alt="lighthouse illustration"
                        class="img-fluid">
                </div>
            </div>

        </section>
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

/* -----------------------------------------
* ERROR PAGE
-------------------------------------------*/

#error {
    position: relative;

    img {
        position: absolute;
        top: 0;
        right: 0;
        max-width: 350px;

        opacity: 0.3;
        z-index: -1;
    }

}

// MEDIA SM
@media screen and (min-width: 576px) {
    #error {
        img {
            position: static;
        }
    }
}
</style>