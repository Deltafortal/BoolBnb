import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '../pages/HomePage.vue';
import ApartmentPage from '../pages/ApartmentPage.vue';
import SearchPage from '../pages/SearchPage.vue';
import NotFoundPage from '../pages/NotFoundPage.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {path:'/', name: 'home', component: HomePage},
        {path:'/apartments/:id', name: 'apartment', component: ApartmentPage},
        { path: '/search', name: 'search', component: SearchPage},

        {path: '/not-found', name:'not-found', component:NotFoundPage },
        { path: '/:pathMatch(.*)*', redirect: '/not-found' },
    ]
});

export { router };