<template>
    <div class="container">
        <h1 class="my-4 text-center">Add User</h1>
        <form @submit.prevent="addUser" method="post">
            <div class="row">
                <div class="form-group col-md-6"> <label for="name" class="form-label">Name</label> <input type="text"
                        class="form-control" id="name" v-model="user.name" placeholder="Name" required> </div>
                <div class="form-group col-md-6"> <label for="email" class="form-label">Email</label> <input type="email"
                        class="form-control" id="email" v-model="user.email" placeholder="Email" required> </div>

            </div>
            <div class="row">
                <div class="form-group col-md-6"> <label for="status" class="form-label">Status</label> <select
                        class="form-control" id="status" v-model="user.status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select> </div>
                <div class="form-group col-md-6"> <label for="buyer_id" class="form-label">User ID</label> <input
                        type="text" class="form-control" id="buyer_id" v-model="user.userid" placeholder="User ID" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6"> <label for="role" class="form-label">Role</label> <select
                        class="form-control" id="role" v-model="user.roles" required>
                        <option value="Admin">Admin</option>
                        <option value="Buyer">Buyer</option>
                        <option value="Supplier">Supplier</option>
                    </select>
                </div>
                <div class="form-group col-md-6"> <label for="password" class="form-label">Password</label> <input
                        type="password" class="form-control" id="password" v-model="user.password" placeholder="password"
                        required> </div>
            </div>
            <div class="my-3 text-center"> <button type="submit" class="btn btn-primary">Add User</button> </div>
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
                status: '',
                userid: '',
                roles: '',
            },
        };
    },
    methods: {
        addUser() {
            // Send a POST request to the API endpoint with the user data
            axios.post('/api/addusers', this.user)
                .then(response => {
                    // Handle successful user creation
                    console.log(response);

                    // Assuming you want to show a success toastr notification
                    toastr.success('User added successfully');
                    this.$router.push({ name: 'user' });
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
