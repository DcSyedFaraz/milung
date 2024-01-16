<template>
    <div class="bg-gradient-primary">
        <div class="container">
            <!-- Outer Row -->
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 backg-gradi">
                                    <div class="logo-img"><img src="../../../public/imgs/logo-1.png" /></div>
                                    <div class="p-5">
                                        <div class="text-left">
                                            <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                            <p>
                                                If you have an account. you can login here, otherwise,
                                                contact us.
                                            </p>
                                        </div>
                                        <form class="user" @submit.prevent="login">
                                            <div class="form-group">
                                                <input type="email" v-model="email" required
                                                    class="form-control form-control-user" id="exampleInputEmail"
                                                    aria-describedby="emailHelp" placeholder="Enter Email Address..." />
                                            </div>
                                            <div class="form-group">
                                                <input type="password" v-model="password" required
                                                    class="form-control form-control-user" id="exampleInputPassword"
                                                    placeholder="Password" />
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck" />
                                                    <label class="custom-control-label" for="customCheck">Remember
                                                        Me</label>
                                                </div>
                                            </div>
                                            <button  class="btn btn-primary btn-user btn-block float-right">
                                                {{ loading ? "Logging in..." : "Login" }}
                                            </button>
                                        </form>
                                        <hr />
                                        <div class="text-left">
                                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <link href="./style.css" rel="stylesheet" scoped/> -->
    <!-- <style src="./style.css"></style> -->

    <!-- <div id="login-page">
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
    </div> -->
</template>

<script>
import './style.css';
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
            const { token, role } = response.data;

            // Store the token in local storage
            this.$store.dispatch('login', { token, role });
            // localStorage.setItem('authToken', token);

            console.log("Login successful:", response.data);
            toastr.success('Login successful', role);
            this.email = "";
            this.password = "";

            this.redirectBasedOnRole(role);

        } catch (error) {

            console.error("Login failed:", error);
            toastr.error('Email or Password is not correct.');
            // this.error = "Invalid credentials";

        } finally {
            this.loading = false;
        }
    },
    redirectBasedOnRole(role) {
        // Redirect based on the user's role using Vue Router
        if (role === 'Admin') {
            this.$router.push({ name: 'admin' });
        }
        else if (role === 'Supplier') {
            this.$router.push({ name: 'supplier' });
        }
        else if (role === 'Buyer') {
            this.$router.push({ name: 'buyer' });
        }
        else {
            // Default redirection or handle unknown roles
            this.$router.push('/default-dashboard');
        }
    },
},
};
</script>
<!-- <style scoped>
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
</style> -->
