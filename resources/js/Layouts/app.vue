<template>
  <div>
    <router-view :key="routerViewKey"></router-view>
  </div>
</template>

<script>
  export default {
    computed: {
    routerViewKey() {
      // Use the full path or a combination of route name and params as the key
      return this.$route.fullPath;
      // Alternatively:
      // return this.$route.name + '-' + (this.$route.params.id || '');
    },
  },
  }
</script>

<style lang="scss" scoped>

</style>
