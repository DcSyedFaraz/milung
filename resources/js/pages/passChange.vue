<template>
    <div class="container flex justify-content-center align-items-center">
      <div class="password-change-form card">
        <h2 class="text-center">Change Password</h2>
        <form @submit.prevent="submitForm">
          <div class="p-fluid">
            <div class="p-field">
              <label for="password">New Password</label>
              <InputText id="password" v-model="user.password" required type="password" />
            </div>
            <div class="p-field">
              <label for="confirmPassword">Confirm Password</label>
              <InputText id="confirmPassword" v-model="user.confirmPassword" required type="password" />
            </div>
            <Button type="submit" label="Change Password" class="p-button-primary" />
          </div>
        </form>
      </div>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        user: {},
      };
    },
    methods: {
      handleValidationErrors(validationErrors) {
        console.log(validationErrors);
        for (const key in validationErrors) {
          if (Object.hasOwnProperty.call(validationErrors, key)) {
            const messages = validationErrors[key];
            messages.forEach(message => {
              toastr.error(message);
            });
          }
        }
      },
      async submitForm() {
        console.log(this.user);
        try {
          const response = await axios.post("/api/passChange", this.user);

          console.log(response.data);
          if (response.status == 200) {
            toastr.success(response.data.message);
          } else {
            toastr.error(response.data.message);
          }

          this.$router.push('/');
        } catch (error) {
          if (error.response.status === 422) {
            const validationErrors = error.response.data.errors;
            this.handleValidationErrors(validationErrors);
          } else if (error.response && error.response.status === 400) {
            console.error(error);
            toastr.error(error.response.data.message);
          } else {
            toastr.error('An error occurred while updating the user');
          }
        }
      },
    },
  };
  </script>

  <style scoped>
  .container {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .password-change-form {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .card {
    border: none;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .p-button-primary {
    margin-top: 1rem;
  }

  .text-center {
    text-align: center;
  }
  </style>
