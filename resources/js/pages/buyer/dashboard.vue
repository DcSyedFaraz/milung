<template>
    <div>
        Buyer
        <button @click="logout">Logout</button>
    </div>
</template>

<script>
export default {
  methods: {
    logout() {
      // Dispatch the logout action from Vuex store
      this.$store.dispatch('logout');

      // Redirect the user to the login page or another route
      this.$router.push({ name: 'login' });
    },
  },
};
</script>

<style lang="scss" scoped>

</style>
