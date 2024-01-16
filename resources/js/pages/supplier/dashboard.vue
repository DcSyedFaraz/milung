<template>
    <div>
        Supplier
        <button @click="logout">Logout</button>
    </div>
</template>

<script>
export default {
  methods: {
    logout() {
      // Dispatch the logout action from Vuex store
      this.$store.dispatch('logout');
      toastr.success('You have been logged out successfully!');
      // Redirect the user to the login page or another route
      this.$router.push({ name: 'login' });
    },
  },
};
</script>

<style lang="scss" scoped>

</style>
