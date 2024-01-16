<template>
    <div id="login-page">
      <h1>Login</h1>
   <form @submit.prevent="login">
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" v-model="password" required>

        <button type="submit">Login</button>
      </form>
    </div>
  </template>

  <script>
export default {
  data() {
    return {
      username: '',
      password: '',
      loading: false,
      error: null,
    };
  },
  methods: {
    async login() {
      // Reset previous error
      this.error = null;

      // Set loading to true
      this.loading = true;

      try {
        // Make API request (replace with your actual API endpoint)
        const response = await this.$axios.post('/api/login', {
          username: this.username,
          password: this.password,
        });

        // Handle successful login (you may want to store the token or redirect)
        console.log('Login successful:', response.data);

        // Reset form fields
        this.username = '';
        this.password = '';
      } catch (error) {
        // Handle login error
        console.error('Login failed:', error);

        // Set error message
        this.error = 'Invalid credentials';
      } finally {
        // Set loading back to false
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
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
  }
  </style>
