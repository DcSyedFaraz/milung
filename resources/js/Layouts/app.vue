<template>
  <div id="login-page">
    <h1>Login</h1>
    <form @submit.prevent="login">
      <label for="email">Email:</label>
      <input type="email" id="email" v-model="email" required />

      <label for="password">Password:</label>
      <input type="password" id="password" v-model="password" required />

      <button type="submit" :disabled="loading">
        {{ loading ? "Logging in..." : "Login" }}
      </button>
    </form>
    <!-- <p v-if="error" class="error">{{ error }}</p> -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      password: "",
      loading: false,
    //   error: null,
    };
  },
  methods: {
    async login() {
      this.error = null;

      this.loading = true;

      try {
        const response = await axios.post("/api/login", {

          email: this.email,
          password: this.password,
          
        });
        const token = response.data.token;

        // Store the token in local storage
        localStorage.setItem('authToken', token);

        console.log("Login successful:", response.data);
        toastr.success('Login successful');
        this.email = "";
        this.password = "";

      } catch (error) {

        console.error("Login failed:", error);
        toastr.error('Email or Password is not correct.');
        // this.error = "Invalid credentials";

      } finally {
        this.loading = false;
      }
    },
  },
};
</script>
<style scoped>
#login-page {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 100px;
}

form {
  display: flex;
  flex-direction: column;
  width: 300px;
}

label {
  margin-bottom: 5px;
}

input {
  margin-bottom: 10px;
  padding: 5px;
}

button {
  padding: 5px 10px;
  background-color: #4caf50;
  color: white;
  border: none;
  cursor: pointer;
}
</style>
