<template>
    <div>
        <div class="container mt-5">
            <div class="justify-content-start">
                <div class="col-md-12">
                    <h3 class="fw-bold mb-4" style="color: #14245c;">Supplier Entry</h3>
                    <form @submit.prevent="submitForm">
                        <div>
                            <div class="row">

                                <!-- <div class="d-flex col-6  my-2" v-if="!isEditMode">
                                    <div class="col-6">
                                        <p for="name">OTP:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.otp" class="form-control" minlength="8"
                                            maxlength="10"
                                            :class="{ 'is-invalid': !OTPPatternValid, 'is-valid': OTPPatternValid }">
                                        <div v-if="!OTPPatternValid" class="invalid-feedback">
                                            OTP must be alphanumeric and between 8 and 10 characters long.
                                        </div>
                                    </div>
                                </div> -->
                                <div class="d-flex col-6  my-auto">
                                    <div class="col-6">
                                        <p for="name">Status:</p>
                                    </div>
                                    <div class="col-6">
                                        <select class="form-select" v-model="supplier.status" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="d-flex col-6 my-2">
                                    <div class="col-6 my-auto">
                                        <p for="userid">Supplier ID:</p>
                                    </div>
                                    <div class="col-6 my-auto">
                                        <input type="text" v-model="supplier.supplier_id" class="form-control"
                                            :disabled="isEditMode"
                                            :class="{ 'is-invalid': !userIdPatternValid, 'is-valid': userIdPatternValid }">
                                        <div v-if="!userIdPatternValid" class="invalid-feedback">
                                            User ID must be alphanumeric and between 1 and 10 characters long.
                                        </div>
                                    </div>

                                </div>
                                <div class="d-flex col-6 my-auto">
                                    <div class="col-6">
                                        <p for="name">Supplier Company Header:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.company_header" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="name">Company Name:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.name" class="form-control">
                                    </div>
                                </div>
                                <!-- <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="contact">Contact person:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.contact" class="form-control">
                                    </div>
                                </div> -->
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="officePhone">Office Phone/Mobile:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="tel" v-model="supplier.officePhone" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row my-3">
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="officePhone">Office Phone/Mobile:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="tel" v-model="supplier.officePhone" class="form-control">
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
                            </div> -->
                            <div class="row my-3">
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="address">Address:</p>
                                    </div>
                                    <div class="col-6">
                                        <textarea v-model="supplier.address" class="form-control" cols="30"
                                            rows="1"></textarea>
                                        <!-- <input type="text" v-model="supplier.address" class="form-control"> -->
                                    </div>
                                </div>
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="website">Website:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.website" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3" v-if="isEditMode">
                                <h3 class="fw-bold" style="color: #14245c;">Contact Person</h3>
                                <table class="table table-striped mt-5 display" id="">
                                    <thead style="color: #14245c;">
                                        <tr class="cursor-pointer">
                                            <th @click="sortTable('userid')">
                                                User ID
                                                <i :class="getSortIcon('userid')" class="ms-1"></i>
                                            </th>
                                            <th @click="sortTable('name')">
                                                Full Name
                                                <i :class="getSortIcon('name')" class="ms-1"></i>
                                            </th>
                                            <th @click="sortTable('email')">
                                                Email
                                                <i :class="getSortIcon('email')" class="ms-1"></i>
                                            </th>
                                            <th @click="sortTable('status')">
                                                Status
                                                <i :class="getSortIcon('status')" class="ms-1"></i>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="user in supplier.person" :key="user.id"
                                            v-if="supplier.person.length > 0">
                                            <td>
                                                <router-link :to="{
                        name: 'edituser',
                        params: { id: user.id },
                    }">
                                                    {{ user.userid }}
                                                </router-link>
                                            </td>
                                            <td>{{ user.name }}</td>
                                            <td>{{ user.email }}</td>

                                            <td>
                                                <span
                                                    :class="{ 'badge': true, 'bg-success-new': user.status === 'active', 'bg-danger': user.status !== 'active' }">
                                                    {{ user.status === 'active' ? 'Active' : 'InActive' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr v-else>
                                            <td class="text-center" colspan="4">
                                                No user available
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <h3 class="fw-bold" style="color: #14245c;">Bank Details</h3>
                            <div class="row my-1">
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="address">Beneficiary Bank:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.bank" class="form-control">
                                    </div>
                                </div>
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="website">Beneficiary Bank Address:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.bank_address" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="address">SWIFT Code:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.swift_code" class="form-control">
                                    </div>
                                </div>
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="website">CHIPS No:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.chips_no" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="address">Beneficiary Name:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.beneficiary_name" class="form-control">
                                    </div>
                                </div>
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="website">Beneficiary Account Number:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.account_no" class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="supplierDescription" class="form-label">Supplier Description</label>
                            <textarea class="form-control" id="supplierDescription"
                                v-model="supplier.supplierDescription" rows="3" style="height: 120px;"></textarea>
                        </div>
                        <div class="row my-3">
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
                <div class="col-lg-12" v-if="isEditMode">
                    <div class="card">
                        <div class="card-header pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="col-6">
                                    <span class="mt-2 fw-bold fs-4" style="color: #14245c;">Order History:</span>
                                </div>
                                <div class="col-4">
                                    <!-- <input type="text" class="form-control" placeholder="Search Products..." /> -->
                                </div>
                            </div>
                        </div>
                        <div class="card-body rounded-top">
                            <!-- Table with stripped rows -->
                            <table class="table table-striped display text-center">
                                <thead style="color: #009de1;">
                                    <tr class="rounded-top-new">
                                        <th>Order Number</th>
                                        <th>Order Date</th>
                                        <th>Quantity</th>
                                        <th>Article Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(order, index) in orders" :key="index" v-if="orders.length > 0">
                                        <td>
                                            <router-link :to="{ name: 'order_edit', params: { id: order.id } }"
                                                class="text- underline">
                                                {{ order.id }}
                                            </router-link>
                                        </td>
                                        <td>{{ order.orderdate }}</td>
                                        <td>{{ order.quantity_unit }}</td>
                                        <td>{{ order.article }}</td>
                                    </tr>
                                    <tr v-else>
                                        <td colspan="8" class="text-center">
                                            No orders available
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <EventLogTable :filterValue="'Supplier'" />
    </div>
    <div v-if="loader" class="loader-overlay">
        <div class="loader"></div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

export default {
    emits: ['profileUpdated'],
    data() {
        return {
            loader: false,
            productOptions: [],
            sortKey: '',
            sortAsc: true,
            supplier: {
                name: '',
                userid: '',
                email: '',
                address: '',
                website: '',
                contact: '',
                officePhone: '',
                supplierDescription: '',
                group: [],
                Secgroup: []
            },
            errors: [],
            orders: {},
            isEditMode: false
        }
    },
    methods: {
        sortTable(key) {
            if (this.sortKey === key) {
                this.sortAsc = !this.sortAsc;
            } else {
                this.sortKey = key;
                this.sortAsc = true;
            }
            this.supplier.person.sort((a, b) => {
                let result = 0;
                if (a[key] < b[key]) {
                    result = -1;
                } else if (a[key] > b[key]) {
                    result = 1;
                }
                return this.sortAsc ? result : -result;
            });
        },
        getSortIcon(key) {
            if (this.sortKey === key) {
                return this.sortAsc ? 'fas fa-sort-up' : 'fas fa-sort-down';
            }
            return 'fas fa-sort';
        },

        async fetchProductOptions() {
            this.loader = true;
            try {
                const response = await axios.get('/api/product_group_get');
                this.productOptions = response.data;
                console.log(this.productOptions);
                if (this.$route.params.id) {
                    this.loadSupplier(this.$route.params.id);
                }
                this.loader = false;
            } catch (error) {
                this.loader = false;
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
            this.loader = true;
            this.errors = [];
            if (!this.supplier.name) this.errors.push('Supplier name is required.');
            if (!this.supplier.address) this.errors.push('Address is required.');
            if (!this.supplier.website) this.errors.push('Website is required.');
            if (!this.supplier.supplierDescription) this.errors.push('Supplier description is required.');
            if (!this.supplier.supplier_id) this.errors.push('Supplier ID is required.');
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
                        const id = this.$route.params.id;
                        response = await axios.put(`/api/suppliers/${id}`, formData);
                    } else {
                        response = await axios.post('/api/addsuppliers', formData);
                    }

                    this.resetForm();

                    this.loader = false;
                    if (response.status === 201 || response.status === 200) {
                        this.showToast('success', response.data.message);
                        this.$router.push({ name: 'Datasupplier' });
                    } else {
                        toastr.error('Unexpected response from the server');
                    }
                } catch (error) {
                    this.loader = false;
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
                supplierDescription: '',
                group: [],
                Secgroup: []
            };
            this.isEditMode = false;
        },
        async loadSupplier(userid) {
            this.loader = true;
            try {
                const response = await axios.get(`/api/suppliers/${userid}`);
                
                console.log(response.data);
                this.orders = response.data.orders;
                const supplierData = response.data.user;

                this.supplier = {
                    name: supplierData.name,
                    supplier_id: supplierData.supplier_id,
                    // email: supplierData.email,
                    address: supplierData.address,
                    website: supplierData.website,
                    officePhone: supplierData.office_phone,
                    supplierDescription: supplierData.supplier_description,
                    group: supplierData.group.map(groupItem => {
                        const option = this.productOptions.find(option => option.id === groupItem);
                        return {
                            id: option.id,
                            group_name: option.group_name
                        };
                    }),
                    Secgroup: supplierData.sec_group.map(groupItem => {
                        const option = this.productOptions.find(option => option.id === groupItem);
                        return {
                            id: option.id,
                            group_name: option.group_name
                        };
                    }),
                    account_no: supplierData.account_no,
                    bank: supplierData.bank,
                    bank_address: supplierData.bank_address,
                    beneficiary_name: supplierData.beneficiary_name,
                    status: supplierData.status,
                    chips_no: supplierData.chips_no,
                    swift_code: supplierData.swift_code,
                    contact_person: supplierData.contact_person,
                    company_header: supplierData.company_header,
                    contact: supplierData.contact,
                    person: supplierData.person,
                };

                this.isEditMode = true;
                this.loader = false;
            } catch (error) {
                this.loader = false;
                console.error(error);
            }
        }
    },
    mounted() {
        this.fetchProductOptions();
        this.supplier.status = 'active';

    },
    computed: {
        userIdPatternValid() {
            const pattern = /^[a-zA-Z0-9]{1,20}$/;
            return pattern.test(this.supplier.supplier_id);
        },
        OTPPatternValid() {
            const pattern = /^[a-zA-Z0-9]{8,10}$/;
            return pattern.test(this.supplier.otp);
        },
    }
}
</script>
<style>
.multiselect__tag {
    background-color: #14245c !important;
    color: white;
}

.multiselect__tag-icon::after {
    color: white !important;

}

.table {
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 20px;

    border-radius: 10px 10px 0 0;
    overflow: hidden;
}
</style>
