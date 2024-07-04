<template>
    <div>
        <section class="section min-vh-100">
            <form @submit.prevent="submitForm" enctype="multipart/form-data">
                <div class="container">

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
                                        <input class="form-check-input" type="radio" id="profitRadio" value="profit"
                                            @change="handleOptionChange" v-model="selectedOption">
                                        <label class="form-check-label" for="profitRadio">
                                            Profit (%)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="amountRadio" checked
                                            value="amount" @change="handleOptionChange" v-model="selectedOption">
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
                                        <input v-else type="text" class="form-control" v-model="amount">
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
                            <!-- Add button to add additional fields -->
                            <div class="d-flex col-11 my-2">
                                <div class="col-5">
                                    <p>Additional Fields:</p>
                                </div>
                                <div class="col-7">
                                    <button type="button" class="btn btn-primary" @click="addField">Add Field</button>
                                </div>
                            </div>
                            <!-- Render additional fields dynamically -->
                            <div class="d-flex col-11 my-2" v-for="(field, index) in additionalFields" :key="index">
                                <div class="col-5">
                                    <input type="text" v-model="field.name" placeholder="Field Name"
                                        class="form-control">
                                </div>
                                <div class="col-7 d-flex">
                                    <input type="text" v-model="field.value" placeholder="Field Value"
                                        class="form-control">
                                    <button type="button" class="btn btn-danger ml-2"
                                        @click="removeField(index)">Remove</button>
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
            id: '',
            group_name: '',
            selectedOption: '',
            description: '',
            profit: '',
            amount: '',
            hs_de: '',
            hs_cn: '',
            additionalFields: [],
            submitting: false
        }
    },
    mounted() {
        // Fetch product group data when editing
        if (this.$route.params.id) {
            this.id = this.$route.params.id;
            this.fetchProductGroupData();
        }
    },
    methods: {
        addField() {
            this.additionalFields.push({ name: '', value: '' });
        },
        removeField(index) {
            this.additionalFields.splice(index, 1);
        },
        fetchProductGroupData() {
            axios.get(`/api/product_group/${this.id}`)
                .then(response => {
                    const productGroup = response.data;
                    console.log(productGroup);
                    this.group_name = productGroup.group_name;
                    this.description = productGroup.description;
                    this.profit = productGroup.profit;
                    this.amount = productGroup.amount ? parseFloat(productGroup.amount).toFixed(2) : ''; // Ensure amount is in 2 decimal points
                    this.hs_de = productGroup.hs_de;
                    this.hs_cn = productGroup.hs_cn;
                    this.additionalFields = productGroup.additional_fields  || [];
                })
                .catch(error => {
                    console.error(error);
                });
        },
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
        prepareFormData() {
            const formData = new FormData();
            formData.append('group_name', this.group_name);
            formData.append('description', this.description);
            formData.append('profit', this.profit ?? 0);
            formData.append('amount', this.amount ? parseFloat(this.amount).toFixed(2) : 0); // Format amount to 2 decimal points
            formData.append('hs_de', this.hs_de);
            formData.append('hs_cn', this.hs_cn);
            this.additionalFields.forEach((field, index) => {
                formData.append(`additionalFields[${index}][name]`, field.name);
                formData.append(`additionalFields[${index}][value]`, field.value);
            });
            return formData;
        },
        submitFormData(formData) {
            if (this.id) {
                // Update product group
                axios.post(`/api/product_group/${this.id}`, formData)
                    .then(response => {
                        console.log(response);
                        toastr.success(response.data.message);
                        this.submitting = false;
                        this.$router.push({ name: 'product_group' });
                    })
                    .catch(error => {
                        this.submitting = false;
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
            } else {
                // Create new product group
                axios.post('/api/product_group', formData)
                    .then(response => {
                        console.log(response);
                        toastr.success(response.data.message);
                        this.submitting = false;
                        this.$router.push({ name: 'product_group' });
                    })
                    .catch(error => {
                        this.submitting = false;
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
            }
        },
        submitForm() {
            this.submitting = true;
            const formData = this.prepareFormData();
            this.submitFormData(formData);
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
