<script>
export default {
  props: {
    isLoading: Boolean,
  },
};
</script>

<template>
  <div class="loader" v-if="isLoading">
    <div class="spinner-border" role="status">
      <span class="visually-hidden">Caricamento...</span>
    </div>
  </div>
</template>
  
<style lang="scss" scoped>
@use '../assets/scss/vars' as *;

.loader {
  position: fixed;
  top: 80px;
  left: 0;
  width: 100%;
  height: calc(100vh - 120px);
  background: $light-grey;
  display: flex;
  justify-content: center;
  align-items: center;
  color: white;
  font-size: 24px;
}

.spinner-border {
  @include circle(100px);
}
</style>