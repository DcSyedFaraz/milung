<template>
    <div class="password-change-form">
        <h2>Change Password</h2>
        <form @submit.prevent="submitForm">
            <div class="p-fluid">
                <!-- <div class="p-field">
                    <label for="otp">OTP</label>
                    <InputText id="otp" v-model="user.otp" required />
                </div> -->
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
                } else {
                    toastr.error('An error occurred while updating the user');
                }

            }
        },
    },
};
</script>

<style scoped>
.p-button-primary {
    margin-top: 1rem;
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
</style>
