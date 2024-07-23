<template>
    <div>
        <div class="container mt-5">
            <div class="justify-content-start">
                <div class="col-md-12">
                    <h3 class="fw-bold mb-4" style="color: #14245c;">Supplier Entry</h3>
                    <form @submit.prevent="submitForm">
                        <div>
                            <div class="row">
                                <div class="d-flex col-6 my-auto">
                                    <div class="col-6">
                                        <p for="name">Status:</p>
                                    </div>
                                    <div class="col-6">
                                        <select class="form-select" v-model="supplier.status" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                        <div v-if="validationErrors.status" class="invalid-feedback">
                                            {{ validationErrors.status[0] }}
                                        </div>
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
                                            :class="{ 'is-invalid': !userIdPatternValid || validationErrors.supplier_id, 'is-valid': userIdPatternValid }">
                                        <div v-if="!userIdPatternValid" class="invalid-feedback">
                                            User ID must be alphanumeric and between 1 and 10 characters long.
                                        </div>
                                        <div v-if="validationErrors.supplier_id" class="invalid-feedback">
                                            {{ validationErrors.supplier_id[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex col-6 my-auto">
                                    <div class="col-6">
                                        <p for="name">Supplier Company Header:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.company_header" class="form-control"
                                            :class="{ 'is-invalid': validationErrors.company_header }">
                                        <div v-if="validationErrors.company_header" class="invalid-feedback">
                                            {{ validationErrors.company_header[0] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="name">Company Name:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.name" class="form-control"
                                            :class="{ 'is-invalid': validationErrors.name }">
                                        <div v-if="validationErrors.name" class="invalid-feedback">
                                            {{ validationErrors.name[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="officePhone">Office Phone/Mobile:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="tel" v-model="supplier.officePhone" class="form-control"
                                            :class="{ 'is-invalid': validationErrors.officePhone }">
                                        <div v-if="validationErrors.officePhone" class="invalid-feedback">
                                            {{ validationErrors.officePhone[0] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="address">Address:</p>
                                    </div>
                                    <div class="col-6">
                                        <textarea v-model="supplier.address" class="form-control" cols="30" rows="1"
                                            :class="{ 'is-invalid': validationErrors.address }"></textarea>
                                        <div v-if="validationErrors.address" class="invalid-feedback">
                                            {{ validationErrors.address[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="website">Website:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.website" class="form-control"
                                            :class="{ 'is-invalid': validationErrors.website }">
                                        <div v-if="validationErrors.website" class="invalid-feedback">
                                            {{ validationErrors.website[0] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h3 class="fw-bold" style="color: #14245c;">Bank Details</h3>
                            <div class="row my-1">
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="address">Beneficiary Bank:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.bank" class="form-control"
                                            :class="{ 'is-invalid': validationErrors.bank }">
                                        <div v-if="validationErrors.bank" class="invalid-feedback">
                                            {{ validationErrors.bank[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="website">Beneficiary Bank Address:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.bank_address" class="form-control"
                                            :class="{ 'is-invalid': validationErrors.bank_address }">
                                        <div v-if="validationErrors.bank_address" class="invalid-feedback">
                                            {{ validationErrors.bank_address[0] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="address">SWIFT Code:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.swift_code" class="form-control"
                                            :class="{ 'is-invalid': validationErrors.swift_code }">
                                        <div v-if="validationErrors.swift_code" class="invalid-feedback">
                                            {{ validationErrors.swift_code[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="website">CHIPS No:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.chips_no" class="form-control"
                                            :class="{ 'is-invalid': validationErrors.chips_no }">
                                        <div v-if="validationErrors.chips_no" class="invalid-feedback">
                                            {{ validationErrors.chips_no[0] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="address">Beneficiary Name:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.beneficiary_name" class="form-control"
                                            :class="{ 'is-invalid': validationErrors.beneficiary_name }">
                                        <div v-if="validationErrors.beneficiary_name" class="invalid-feedback">
                                            {{ validationErrors.beneficiary_name[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="website">Beneficiary Account Number:</p>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" v-model="supplier.account_no" class="form-control"
                                            :class="{ 'is-invalid': validationErrors.account_no }">
                                        <div v-if="validationErrors.account_no" class="invalid-feedback">
                                            {{ validationErrors.account_no[0] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="supplierDescription" class="form-label">Supplier Description</label>
                            <textarea class="form-control" id="supplierDescription"
                                v-model="supplier.supplierDescription" rows="3" style="height: 120px;"
                                :class="{ 'is-invalid': validationErrors.supplierDescription }"></textarea>
                            <div v-if="validationErrors.supplierDescription" class="invalid-feedback">
                                {{ validationErrors.supplierDescription[0] }}
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="form-group col-6 my-2">
                                <label class="form-label">Primary Product Group</label>
                                <div class="form-group">
                                    <multiselect v-model="supplier.group" :options="productOptions" :multiple="true"
                                        label="group_name" track-by="id"
                                        :class="{ 'is-invalid': validationErrors.group }"></multiselect>
                                    <div v-if="validationErrors.group" class="invalid-feedback">
                                        {{ validationErrors.group[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-6 my-2">
                                <label class="form-label">Secondary Product Group</label>
                                <div class="form-group">
                                    <multiselect v-model="supplier.Secgroup" :options="productOptions" :multiple="true"
                                        label="group_name" track-by="id"
                                        :class="{ 'is-invalid': validationErrors.Secgroup }"></multiselect>
                                    <div v-if="validationErrors.Secgroup" class="invalid-feedback">
                                        {{ validationErrors.Secgroup[0] }}
                                    </div>
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
                            </div>
                        </div>
                        <div class="card-body rounded-top">
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
                                                class="text-underline">
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
            validationErrors: {},
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
                    console.error(error);
                    this.loader = false;
                    if (error.response && error.response.status === 422) {
                        const validationErrors = error.response.data.errors;
                        this.validationErrors = validationErrors;
                        console.log(validationErrors);
                        Object.values(validationErrors).forEach(errorMessage => {
                            toastr.error(errorMessage[0]);
                        });
                    } else {
                        toastr.error('An error occurred while saving the supplier');
                    }
                }
            } else {
                this.errors.forEach(error => toastr.error(error));
                this.loader = false;
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
