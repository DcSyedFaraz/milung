<template>
    <div>
        <h1>Edit User</h1>
        <!-- <button class="btn btn-success" @click="fetchUserDetails">click</button> -->
        <form @submit.prevent="updateUser">
            <div class="row">

                <div class="col-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" v-model="user.name" placeholder="Name" required>
                        <label for="name">Name</label>
                    </div>
                </div>
                <div class="col-6">

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" v-model="user.email" placeholder="Email"
                            required>
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="col-6">

                    <div class="form-floating mb-3">
                        <select class="form-select" id="status" v-model="user.status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <label for="status">Status</label>
                    </div>
                </div>
                <div class="col-6">

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="buyer_id" v-model="user.buyer_id"
                            placeholder="Buyer ID" required>
                        <label for="buyer_id">Buyer ID</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="role" v-model="user.roles" required>
                            <option value="Admin">Admin</option>
                            <option value="Buyer">Buyer</option>
                            <option value="Supplier">Supplier</option>
                        </select>
                        <label for="role">Role</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</template>

<script>

export default {
    data() {
        return {
            user: {
                id: this.$route.params.id,
                name: '',
                email: '',
                status: '',
                buyer_id: '',
                roles: '',
            }
        };
    },
    mounted() {
        // Fetch user details from the API using user ID (replace with your actual API endpoint)
        const userId = this.$route.params.id; // Replace with the actual user ID
        this.fetchUserDetails(userId);
    },
    methods: {
        fetchUserDetails(userId) {

            axios.get(`/api/editusers/${userId}`)
                .then(response => {
                    this.user = {
                        ...response.data,
                        roles: response.data.roles[0], // Make sure 'role' is the correct property in the response
                    };
                    console.log(response.data.status);
                })
                .catch(error => {
                    console.error('Error fetching user details', error);
                    toastr.error('Error fetching user details');
                });
        },
        async updateUser() {
            try {
                const response = await axios.put(`/api/updateusers/${this.user.id}`, this.user);

                if (response.status === 200) {
                    toastr.success('User updated successfully');
                    this.$router.push({ name: 'user' });
                }
            } catch (error) {
                if (error.response.status === 422) {
                    toastr.error('Please fix the validation errors and try again');
                } else {
                    toastr.error('An error occurred while updating the user');
                }
            }
        },
    }
};
</script>
