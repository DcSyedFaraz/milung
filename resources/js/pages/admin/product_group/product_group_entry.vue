<template>
    <div>
        <section class="section min-vh-100">
            <form @submit.prevent="submitForm" enctype="multipart/form-data">
                <div class="container">
                    <!-- <div class="row">
                        <div class="col-6"></div>
                        <div class="col-md-6 gap-2">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-milung mx-2 px-4" type="submit">Save</button>
                                <button class="btn btn-warning px-4" type="reset">Clear</button>
                            </div>
                        </div>
                    </div> -->

                    <div class="row my-5">
                        <div class="col-md-6">
                            <div class="d-flex col-11 my-2">
                                <div class="col-5">
                                    <p for="v-model">Product Group Name:</p>
                                </div>
                                <div class="col-7"><input type="text" v-model="group_name" class="form-control"></div>
                            </div>
                            <div class="d-flex col-11 my-2">
                                <div class="col-5">
                                    <p for="v-model">Product Group Description:</p>
                                </div>
                                <div class="col-7">
                                    <input type="text" v-model="description" class="form-control">
                                </div>
                            </div>
                            <div class="d-flex col-11 my-2">
                                <div class="col-5">
                                    <p>Choose one:</p>
                                </div>
                                <div class="col-7">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="profitRadio" value="profit" @change="handleOptionChange"
                                            v-model="selectedOption">
                                        <label class="form-check-label" for="profitRadio">
                                            Profit (%)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="amountRadio" checked value="amount" @change="handleOptionChange"
                                            v-model="selectedOption">
                                        <label class="form-check-label" for="amountRadio">
                                            Amount
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex col-11 my-2">
                                <div class="col-5">
                                    <p>{{ selectedOption === 'profit' ? 'Fixed Profit:' : 'Fixed Amount:' }}</p>
                                </div>
                                <div class="col-7">
                                    <div class="input-group">
                                        <input v-if="selectedOption === 'profit'" type="text" max="100"
                                            class="form-control" v-model="profit">
                                        <input v-else type="number" class="form-control" v-model="amount">
                                        <span class="input-group-text" v-if="selectedOption === 'profit'">%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex col-11 my-2">
                                <div class="col-5">
                                    <p for="v-model">HS-DE Code:</p>
                                </div>
                                <div class="col-7">
                                    <input type="number" v-model="hs_de" class="form-control">
                                </div>
                            </div>
                            <div class="d-flex col-11 my-2">
                                <div class="col-5">
                                    <p for="v-model">HS-CN Code:</p>
                                </div>
                                <div class="col-7">
                                    <input type="number" v-model="hs_cn" class="form-control">
                                </div>
                            </div>
                            <div class="d-flex col-11 mt-4">
                                <div class="col-5">
                                    <button class="btn btn-success  px-4" type="submit" :disabled="submitting"><span
                                            v-if="submitting">Submitting...</span>
                                        <span v-else>Save</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            group_name: '',
            selectedOption: '',
            description: '',
            profit: '',
            amount: '',
            hs_de: '',
            hs_cn: '',
            submitting: false
        }
    },
    methods: {
        handleOptionChange() {
            if (this.selectedOption === 'profit') {
                this.amount = 0; // Set amount to null if profit is selected
            } else {
                this.profit = 0; // Set profit to null if amount is selected
            }
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
        },
        submitForm() {
            // Disable submit button to prevent multiple submissions
            this.submitting = true;

            const formData = new FormData();
            formData.append('group_name', this.group_name);
            formData.append('description', this.description);
            formData.append('profit', this.profit);
            formData.append('amount', this.amount);
            formData.append('hs_de', this.hs_de);
            formData.append('hs_cn', this.hs_cn);

            axios.post('/api/product_group', formData)
                .then(response => {
                    // Handle successful user creation
                    console.log(response);

                    // Assuming you want to show a success toastr notification
                    toastr.success(response.data.message);
                    this.$router.push({ name: 'product_group' });
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
                })
                .finally(() => {
                    // Re-enable submit button after form submission is complete
                    this.submitting = false;
                });
        },


        resetForm() {
            // Reset form fields or update component state to clear form data
            this.group_name = '';
            this.description = '';
            this.profit = '';
            this.amount = '';
            this.hs_de = '';
            this.hs_cn = '';
        }

    },
}
</script>

<style scoped></style>
