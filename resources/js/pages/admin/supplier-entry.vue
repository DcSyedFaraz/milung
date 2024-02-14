<template>
    <div>
        <div class="container mt-5">
            <div class=" justify-content-start">
                <div class="col-md-12">
                    <h3 class="fw-bold mb-4" style="color: #14245c;">Supplier Entry</h3>
                    <form @submit.prevent="submitForm">
                        <div class=" ">

                            <div class="row">
                                <div class="d-flex col-6  ">
                                    <div class="col-6">
                                        <p for="name">Supplier Name:</p>
                                    </div>
                                    <div class="col-6"><input type="text" v-model="name" class="form-control"></div>
                                </div>
                                <div class="d-flex col-6  ">
                                    <div class="col-6">
                                        <p for="name">Contact person:</p>
                                    </div>
                                    <div class="col-6"><input type="text" v-model="contact" class="form-control"></div>
                                </div>
                            </div>
                            <div class="row my-3">

                                <div class="d-flex col-6  ">
                                    <div class="col-6">
                                        <p for="name">Office Phone/Mobile:</p>
                                    </div>
                                    <div class="col-6"><input type="text" v-model="officePhone" class="form-control"></div>
                                </div>
                                <div class="d-flex col-6  ">
                                    <div class="col-6">
                                        <p for="name">Email:</p>
                                    </div>
                                    <div class="col-6"><input type="text" v-model="email" class="form-control" id="email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="d-flex col-6  ">
                                    <div class="col-6">
                                        <p for="name">Address:</p>
                                    </div>
                                    <div class="col-6"><input type="text" v-model="address" class="form-control"></div>
                                </div>
                                <div class="d-flex col-6  ">
                                    <div class="col-6">
                                        <p for="name">Website:</p>
                                    </div>
                                    <div class="col-6"><input type="text" v-model="website" class="form-control" id="email">
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="form-group ">
                            <label for="buyerDescription" class="form-label">Supplier Description</label>
                            <textarea class="form-control" id="buyerDescription" v-model="buyerDescription" rows="3"
                                style="height: 120px; "></textarea>
                        </div>
                        <div class="row">
                            <div class="form-group col-6 my-2">
                                <label class="form-label">Primary Product Group</label>
                                <!-- <div class="form-group">
                                    <label>Multiple (.select2-purple)</label>
                                    <div class="select2-purple">
                                        <select class="select2" multiple="multiple" id="multiple"
                                            data-placeholder="Select a State" data-dropdown-css-class="select2-purple"
                                            style="width: 100%;">
                                            <option>Alabama</option>
                                            <option>Alaska</option>
                                            <option>California</option>
                                            <option>Delaware</option>
                                            <option>Tennessee</option>
                                            <option>Texas</option>
                                            <option>Washington</option>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <multiselect v-model="group" :options="productOptions" :multiple="true" label="group_name" track-by="id">
                                    </multiselect>

                                </div>
                                <!-- <Select2 v-model="myValue" :options="myOptions" :multiple="true"/> -->
                            </div>
                            <div class="form-group col-6 my-2">
                                <label class="form-label">Secondary Product Group</label>

                                <div class="form-group">
                                    <multiselect v-model="Secgroup" :options="productOptions" :multiple="true" label="group_name" track-by="id">
                                    </multiselect>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2 my-2">
                            <button type="submit" class="btn col-1 btn-milung" style="height: 45px; ">Submit</button>
                            <button type="reset" class="btn btn-warning col-1" style="height: 45px; ">Clear</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12 ">

                    <div class="card  ">
                        <div class="card-header pt-3  ">
                            <div class="d-flex justify-content-between align-items-center ">
                                <div class="col-6">
                                    <span class=" mt-2 fw-bold fs-4 " style="color: #14245c;">Order History:</span>
                                </div>
                                <div class="col-4">

                                    <input type="text" class="form-control" placeholder="Search Products..." />
                                </div>
                            </div>
                        </div>

                        <div class="card-body rounded-top">


                            <!-- Table with stripped rows -->
                            <table class="table table-striped  display " id="">
                                <thead style="color: #009de1; " class="">
                                    <tr class="rounded-top-new" style="">
                                        <th>
                                            Order Number
                                        </th>
                                        <th>Order Date</th>
                                        <th>Supplier Name</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                        <th>Article Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>OrderN01</td>
                                        <td>22-07-23 21</td>
                                        <td>John Smith</td>
                                        <td>2500</td>
                                        <td>
                                            1500
                                        </td>
                                        <td>
                                            ArticleNo1
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>OrderN01</td>
                                        <td>22-07-23 21</td>
                                        <td>John Smith</td>
                                        <td>2500</td>
                                        <td>
                                            1500
                                        </td>
                                        <td>
                                            ArticleNo1
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>OrderN01</td>
                                        <td>22-07-23 21</td>
                                        <td>John Smith</td>
                                        <td>2500</td>
                                        <td>
                                            1500
                                        </td>
                                        <td>
                                            ArticleNo1
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import './index';
import Multiselect from 'vue-multiselect'

// import 'select2'; // Import the Select2 library
// import 'select2/dist/css/select2.min.css';
import $ from 'jquery';
window.jQuery = window.$ = $;


export default {

    components: { Multiselect },
    // components: { Select2 },
    data() {
        return {
            productOptions: [],
            // myValue: [],
            name: '',
            email: '',
            address: '',
            website: '',
            contact: '',
            officePhone: '',
            buyerDescription: '',
            group: [],
            Secgroup: [],
            errors: []
        }
    },
    methods: {
        async fetchProductOptions() {
            try {
                const response = await axios.get('/api/product_group_get');
                this.productOptions = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        showToast(type, message) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                icon: type,
                title: message
            });
        },
        async submitForm() {
            this.errors = [];
            if (!this.name) {
                this.errors.push('Supplier name is required.');
            }
            if (!this.email) {
                this.errors.push('Email is required.');
            }
            if (!this.address) {
                this.errors.push('Address is required.');
            }
            if (!this.website) {
                this.errors.push('Website is required.');
            }
            if (!this.buyerDescription) {
                this.errors.push('Supplier description is required.');
            }
            if (!this.group.length) {
                this.errors.push('Product group is required.');
            }
            if (!this.errors.length) {
                const formData = {
                    name: this.name,
                    email: this.email,
                    address: this.address,
                    website: this.website,
                    officePhone: this.officePhone,
                    contact: this.contact,
                    buyerDescription: this.buyerDescription,
                    group: this.group.map(option => option.id),
                    Secgroup: this.Secgroup.map(option => option.id)
                };
                try {
                    console.log(formData);
                    const addbuyer = await axios.post('/api/addsupliers', formData);
                    console.log(addbuyer.data);
                    this.resetForm();

                    if (addbuyer.status === 201) {
                        this.showToast('success', addbuyer.data.message);
                        this.$router.push({ name: 'Datasupplier' });
                    } else {
                        // Handle other status codes or unexpected responses
                        toastr.error('Unexpected response from the server');
                    }

                } catch (error) {
                    console.error(error);
                    if (error.response && error.response.status === 422) {
                        // Validation error, display Toastr messages
                        const validationErrors = error.response.data.errors;

                        Object.values(validationErrors).forEach(errorMessage => {
                            toastr.error(errorMessage[0]);
                        });
                    } else {
                        // Handle other types of errors
                        toastr.error('An error occurred while adding the supplier');
                    }
                }
            } else {
                this.errors.forEach(error => {
                    toastr.error(error);
                });
                toastr.options = {
                    'closeButton': true,
                    'timeOut': '3000'
                }
            }
        },
        resetForm() {
            this.name = '';
            this.email = '';
            this.address = '';
            this.website = '';
            this.buyerDescription = '';
            this.group = [];
        }
    },

    mounted() {
        this.fetchProductOptions();
    },
    beforeDestroy() {
        // Destroy Select2 instance when the component is destroyed to prevent memory leaks
        // $(this.$refs.select).select2('destroy');
    },

}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style>
@import url('./style.css');

.multiselect__tag {
    background-color: #14245c !important;
    color: white;
}

.multiselect__tag-icon::after {
    color: white;

}

.table {
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 20px;

    border-radius: 10px 10px 0 0;
    overflow: hidden;
}
</style>
