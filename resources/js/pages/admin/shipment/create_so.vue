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
                                    <p for="v-model">SO#:</p>
                                </div>
                                <div class="col-7"><input type="text" v-model="so.so_number" class="form-control"></div>
                            </div>
                            <div class="d-flex col-11 my-2">
                                <div class="col-5 my-auto">
                                    <p for="v-model my-auto">Buyer ID:</p>
                                </div>
                                <div class="col-7">
                                    <!-- <input type="text" v-model="so.buyerid" class="form-control"> -->
                                    <multiselect v-model="selectedBuyerId" :options="buyers" field="id" label="userid"
                                        track-by="id">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="d-flex col-11 my-2">
                                <div class="col-5 my-auto">
                                    <p for="v-model my-auto">Supplier ID:</p>
                                </div>
                                <div class="col-7">
                                    <!-- <input type="text" v-model="so.buyerid" class="form-control"> -->
                                    <multiselect v-model="selectedsupplierId" :options="suppliers" field="id"
                                        label="userid" track-by="id">
                                    </multiselect>
                                </div>
                            </div>


                            <div class="d-flex col-11 my-2">
                                <div class="col-5">
                                    <p for="v-model">Shipment Method:</p>
                                </div>
                                <div class="col-7">
                                    <select class="fw-bold form-select" v-model="so.method">
                                        <option value="Air">Air</option>
                                        <option value="Sea">Sea</option>
                                        <option value="Train">Train</option>
                                        <option value="Courier">Courier</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex col-11 my-2">
                                <div class="col-5">
                                    <p for="v-model">Port Of Loading:</p>
                                </div>
                                <div class="col-7">
                                    <input type="text" v-model="so.port" class="form-control">
                                </div>
                            </div>
                            <div class="d-flex col-11 my-2">
                                <div class="col-5">
                                    <p for="v-model">Final Destination:</p>
                                </div>
                                <div class="col-7">
                                    <input type="text" v-model="so.destination" class="form-control">
                                </div>
                            </div>
                            <div class="d-flex col-11 my-2">
                                <div class="col-5">
                                    <p for="v-model">Incoterm:</p>
                                </div>
                                <div class="col-7">
                                    <input type="text" v-model="so.incoterm" class="form-control">
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
import Multiselect from 'vue-multiselect'
export default {
    components: {
        Multiselect,
    },
    data() {
        return {
            so: {},
            buyers: [],
            suppliers: [],
            selectedsupplierId: [],
            selectedBuyerId: [],
            submitting: false
        }
    },
    mounted() {
        this.fetchBuyers();
        this.fetchSuppliers();
    },
    watch: {
        selectedBuyerId(newValue) {
            // console.log(newValue);
            this.so.buyerid = newValue.id;
        },
        selectedsupplierId(newValue) {
            // console.log(newValue);
            this.so.supplierid = newValue.id;
        },
    },
    methods: {
        fetchSuppliers() {
            axios.get('/api/supplierOrder')
                .then(response => {
                    this.suppliers = response.data;
                    // console.log(this.suppliers);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        fetchBuyers() {
            axios.get('/api/buyerOrder')
                .then(response => {
                    this.buyers = response.data;
                })
                .catch(error => {
                    console.error(error);
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
        },
        submitForm() {
            // Disable submit button to prevent multiple submissions
            this.submitting = true;

            console.log(this.so);
            axios.post('/api/create_so', this.so)
                .then(response => {
                    // Handle successful user creation
                    console.log(response.data);

                    // Assuming you want to show a success toastr notification
                    toastr.success(response.data.message);
                    this.$router.push({ name: 'shipment_overview' });
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

    },
}
</script>

<style scoped></style>
