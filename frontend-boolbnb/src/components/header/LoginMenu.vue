<script>
const user_endpoint = 'http://localhost:8000/api/user';
import axios from 'axios';


export default {

    data() {
        return {
            user: '',
            loading: false
        };
    },

    methods: {
        // Get user details
        fetchUser() {
            this.loading = true;

            axios.get(user_endpoint)
                .then(res => { this.user = res.data; this.loading = false })
                .catch(err => { console.error(err.response.data) })
                .then(() => { this.loading = false });
        },

        // Get First letter of a string
        getFirstLetter: (word) => (word.substring(0, 1).toUpperCase()),
    },

    created() {
        this.fetchUser();
    }

}
</script>


<template>
    <div class="login-menu dropdown">

        <!-- Generic Menu Togle -->
        <button class="dropdown-toggle d-none d-md-flex align-items-center" data-bs-toggle="dropdown">
            <font-awesome-icon icon="bars" />

            <div v-if="loading" class="user ms-2">
                <div class="spinner-border" role="status" style="width: 15px; height: 15px;">
                </div>
            </div>

            <div v-else-if="user.length && !loading" class="user ms-2">
                <span id="admin-name">{{ getFirstLetter(user[0]['name']) }}</span>
            </div>

            <div v-else class="user ms-2">
                <font-awesome-icon icon="user" />
            </div>

        </button>

        <!-- Logged Menu Toggle -->
        <button class="dropdown-toggle d-flex d-md-none align-items-center" data-bs-toggle="dropdown">
            <div class="user">
                <div v-if="loading" class="spinner-border" role="status" style="width: 15px; height: 15px;">
                </div>

                <span v-else-if="user.length && !loading" id="admin-name">{{
                    getFirstLetter(user[0]['name'])
                }}</span>

                <font-awesome-icon v-else icon="user" />
            </div>
        </button>

        <!-- Account Menu -->
        <ul v-if="user.length" class="dropdown-menu">
            <li><a class="dropdown-item" href="http://127.0.0.1:8000/admin/apartments">I miei
                    Boolbnb</a>
            </li>
            <li><a class="dropdown-item " href="http://127.0.0.1:8000/admin">Il mio Profilo</a></li>
            <li><a class="dropdown-item" href="http://127.0.0.1:8000/login">Messaggi</a></li>
            <li><a class="dropdown-item disabled" href="#">Notifiche</a></li>
            <hr>
            <li><a class="dropdown-item" href="http://127.0.0.1:8000/admin/apartments/create">Apri un
                    Boolbnb</a>
            </li>
            <li><a class="dropdown-item" href="http://127.0.0.1:8000/profile">Account</a></li>
            <hr>
            <li>
                <RouterLink class="dropdown-item" :to="{ name: 'home' }">Torna alla Home</RouterLink>
            </li>
        </ul>

        <!-- Login Menu -->
        <ul v-else class="dropdown-menu">
            <li><a class="dropdown-item" href="http://127.0.0.1:8000/login"><b>Accedi</b></a></li>
            <li><a class="dropdown-item" href="http://127.0.0.1:8000/register">Registrati</a></li>
            <li>
                <RouterLink class="dropdown-item" :to="{ name: 'home' }">Torna alla Home</RouterLink>
            </li>
        </ul>

    </div>
</template>


<style lang="scss" scoped>
@use '../../assets/scss/vars' as *;

.login-menu {
    @include flex;

    .dropdown-toggle:after {
        display: none;
    }

    .user {
        @include circle(40px);
        @include flex;
        color: white;
        background-color: black;
    }

    ul.dropdown-menu.show {
        @include font();
    }
}

@media (min-width: 768px) {
    .login-menu {
        padding: 0 6px 0 10px;
        border: 1px solid $light-grey;
        border-radius: 40px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08), 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: box-shadow 0.2s cubic-bezier(0.2, 0, 0, 1);

        &:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.18);
        }

        .user {
            @include circle(30px);
        }
    }

}
</style>