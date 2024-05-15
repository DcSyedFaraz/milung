<template>
    <div class="container">
        <h1 class="my-4 text-center">Edit Profile</h1>
        <form @submit.prevent="profile" method="post">
            <div class="row">
                <div class="form-group col-md-6"> <label for="name" class="form-label">Name</label> <input type="text"
                        class="form-control" id="name" v-model="user.name" placeholder="Name" required> </div>
                <div class="form-group col-md-6"> <label for="email" class="form-label">Email</label> <input
                        type="email" class="form-control" id="email" v-model="user.email" placeholder="Email" required>
                </div>

            </div>

            <div class="row my-3">

                <div class="form-group col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" v-model="user.password"
                        placeholder="password">
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" v-model="user.confirmPassword"
                        placeholder="confirm-password">
                </div>
                <div class="">
                    <small class="text-danger">*Leave Password fields empty if do not want to change password.</small>
                </div>
            </div>
            <div class="my-3 text-center"> <button type="submit" class="btn btn-primary"> Submit </button> </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: {
                name: '',
                email: '',

            },
        };
    },
    mounted() {
        this.userDetail();

    },
    methods: {
        userDetail() {
            axios.get('/api/userDetails').then(response => {

                this.user.email = response.data.email;
                this.user.name = response.data.name;
                // console.log('det ', this.user);

            }).catch(error => {
                console.error('Error fetching details:', error);
            });

        },
        profile() {
            // Send a POST request to the API endpoint with the user data
            axios.post('/api/profile', this.user)
                .then(response => {
                    // Handle successful user creation
                    console.log(response);

                    // Assuming you want to show a success toastr notification
                    toastr.success(response.data.message);
                    this.$emit('profile-updated');
                })
                .catch(error => {
                    // Handle errors
                    if (error.response && error.response.status === 422) {
                        const validationErrors = error.response.data.errors;
                        this.handleValidationErrors(validationErrors);
                    } else {
                        // Non-validation error, log the error
                        console.error(error);

                        // Show a toastr error notification
                        toastr.error('An error occurred while adding the user');
                    }
                });
        },
        handleValidationErrors(validationErrors) {
            // Assuming you have a function to display toastr error messages
            for (const key in validationErrors) {
                if (validationErrors.hasOwnProperty(key)) {
                    const messages = validationErrors[key];
                    // Display each validation error message
                    messages.forEach(message => {
                        toastr.error(message);
                    });
                }
            }
        }
    },


};
</script>

<style>
/* Add Bootstrap 5 styles here */
</style>
