<script>
import AppHeader from './components/AppHeader.vue';
import AppFooter from './components/AppFooter.vue';
import {store} from './js/store.js';
export default {

  components: { AppHeader, AppFooter},

  data() {
    return {
      store: store,
      
    }
  },
  methods: {

    hide() {
      this.store.show = false;
    }
  }
} 
</script>

<template>
  <div @click="hide">
    <!-- Header -->
    <AppHeader />
    
    <RouterView />
    
    <!-- Footer -->
    <AppFooter />

  </div>
</template>

<style lang="scss">
@use './assets/scss/style.scss';
</style>
