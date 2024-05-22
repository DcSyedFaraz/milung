<template>
    <div>
        <div class="container mt-5">
            <div class="justify-content-start">
                <div class="col-md-12">
                    <h3 class="fw-bold mb-4" style="color: #14245c;">Supplier Entry</h3>
                    <form @submit.prevent="submitForm">
                        <div>
                            <div class="row">
                                <div class="d-flex col-6 my-2">
                                    <div class="col-6">
                                        <p for="userid">User ID:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.userid" class="form-control"
                                            :class="{ 'is-invalid': !userIdPatternValid, 'is-valid': userIdPatternValid }">
                                        <div v-if="!userIdPatternValid" class="invalid-feedback">
                                            User ID must be alphanumeric and between 1 and 10 characters long.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="name">Supplier Name:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.name" class="form-control">
                                    </div>
                                </div>
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="contact">Contact person:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.contact" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="officePhone">Office Phone/Mobile:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.officePhone" class="form-control">
                                    </div>
                                </div>
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="email">Email:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.email" class="form-control" id="email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="address">Address:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.address" class="form-control">
                                    </div>
                                </div>
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="website">Website:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.website" class="form-control" id="website">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="buyerDescription" class="form-label">Supplier Description</label>
                            <textarea class="form-control" id="buyerDescription" v-model="supplier.buyerDescription"
                                rows="3" style="height: 120px;"></textarea>
                        </div>
                        <div class="row">
                            <div class="form-group col-6 my-2">
                                <label class="form-label">Primary Product Group</label>
                                <div class="form-group">
                                    <multiselect v-model="supplier.group" :options="productOptions" :multiple="true"
                                        label="group_name" track-by="id"></multiselect>
                                </div>
                            </div>
                            <div class="form-group col-6 my-2">
                                <label class="form-label">Secondary Product Group</label>
                                <div class="form-group">
                                    <multiselect v-model="supplier.Secgroup" :options="productOptions" :multiple="true"
                                        label="group_name" track-by="id"></multiselect>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2 my-2">
                            <button type="submit" class="btn col-1 btn-milung" style="height: 45px;">Submit</button>
                            <button type="reset" class="btn btn-warning col-1" style="height: 45px;"
                                @click="resetForm">Clear</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="col-6">
                                    <span class="mt-2 fw-bold fs-4" style="color: #14245c;">Order History:</span>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" placeholder="Search Products..." />
                                </div>
                            </div>
                        </div>
                        <div class="card-body rounded-top">
                            <!-- Table with stripped rows -->
                            <table class="table table-striped display">
                                <thead style="color: #009de1;">
                                    <tr class="rounded-top-new">
                                        <th>Order Number</th>
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
                                        <td>1500</td>
                                        <td>ArticleNo1</td>
                                    </tr>
                                    <tr>
                                        <td>OrderN01</td>
                                        <td>22-07-23 21</td>
                                        <td>John Smith</td>
                                        <td>2500</td>
                                        <td>1500</td>
                                        <td>ArticleNo1</td>
                                    </tr>
                                    <tr>
                                        <td>OrderN01</td>
                                        <td>22-07-23 21</td>
                                        <td>John Smith</td>
                                        <td>2500</td>
                                        <td>1500</td>
                                        <td>ArticleNo1</td>
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

export default {
    data() {
        return {
            productOptions: [],
            supplier: {
                name: '',
                userid: '',
                email: '',
                address: '',
                website: '',
                contact: '',
                officePhone: '',
                buyerDescription: '',
                group: [],
                Secgroup: []
            },
            errors: [],
            isEditMode: false
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
            if (!this.supplier.name) this.errors.push('Supplier name is required.');
            if (!this.supplier.email) this.errors.push('Email is required.');
            if (!this.supplier.address) this.errors.push('Address is required.');
            if (!this.supplier.website) this.errors.push('Website is required.');
            if (!this.supplier.buyerDescription) this.errors.push('Supplier description is required.');
            if (!this.supplier.userid) this.errors.push('User ID is required.');
            if (!this.supplier.group.length) this.errors.push('Product group is required.');

            if (!this.errors.length) {
                const formData = {
                    ...this.supplier,
                    group: this.supplier.group.map(option => option.id),
                    Secgroup: this.supplier.Secgroup.map(option => option.id)
                };

                try {
                    let response;
                    if (this.isEditMode) {
                        response = await axios.put(`/api/suppliers/${this.supplier.userid}`, formData);
                    } else {
                        response = await axios.post('/api/addsuppliers', formData);
                    }

                    this.resetForm();

                    if (response.status === 201 || response.status === 200) {
                        this.showToast('success', response.data.message);
                        this.$router.push({ name: 'Datasupplier' });
                    } else {
                        toastr.error('Unexpected response from the server');
                    }
                } catch (error) {
                    console.error(error);
                    if (error.response && error.response.status === 422) {
                        const validationErrors = error.response.data.errors;
                        Object.values(validationErrors).forEach(errorMessage => {
                            toastr.error(errorMessage[0]);
                        });
                    } else {
                        toastr.error('An error occurred while saving the supplier');
                    }
                }
            } else {
                this.errors.forEach(error => toastr.error(error));
                toastr.options = {
                    'closeButton': true,
                    'timeOut': '3000'
                };
            }
        },
        resetForm() {
            this.supplier = {
                name: '',
                userid: '',
                email: '',
                address: '',
                website: '',
                contact: '',
                officePhone: '',
                buyerDescription: '',
                group: [],
                Secgroup: []
            };
            this.isEditMode = false;
        },
        async loadSupplier(userid) {
            try {
                const response = await axios.get(`/api/suppliers/${userid}`);
                console.log(response.data);
                this.supplier = {
                    ...response.data,
                    group: response.data.supplier_profile?.group.map(groupItem => {
                        // Find the option with the same id as groupItem.id
                        const option = this.productOptions.find(option => option.id === groupItem);
                        // console.log(option, this.productOptions, groupItem);
                        return {
                            id: option.id,
                            group_name: option.group_name
                        };
                    }),
                    Secgroup: response.data.supplier_profile?.sec_group.map(groupItem => {
                        // Find the option with the same id as groupItem.id
                        const option = this.productOptions.find(option => option.id === groupItem);
                        // console.log(option, this.productOptions, groupItem);
                        return {
                            id: option.id,
                            group_name: option.group_name
                        };
                    })
                };
                this.isEditMode = true;
            } catch (error) {
                console.error(error);
            }
        }
    },
    mounted() {
        this.fetchProductOptions();

        if (this.$route.params.id) {
            this.loadSupplier(this.$route.params.id);
        }
    },
    computed: {
        userIdPatternValid() {
            const pattern = /^[a-zA-Z0-9]{1,10}$/;
            return pattern.test(this.supplier.userid);
        }
    }
}
</script>
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
