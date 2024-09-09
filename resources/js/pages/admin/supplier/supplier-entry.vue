<template>
    <div>
        <div class="container mt-5">
            <div class="justify-content-start">
                <div class="col-md-12">
                    <h3 class="fw-bold mb-4" style="color: #14245c;">Supplier Entry</h3>
                    <div class=" d-flex">

                        <FileUpload name="excel[]" mode="basic" accept=".xlsx" :fileLimit="1" :maxFileSize="10485760"
                            :showUploadButton="false" @select="handleExcelSelect($event)" :showCancelButton="false"
                            :auto="true" chooseLabel="Import">

                        </FileUpload>
                        <a href="../../../../assets/excelTemplate/supplier entry.xlsx" download
                            class="mx-2 fw-bold btn btn-info">
                            Download Excel Template
                        </a>
                    </div>

                    <form @submit.prevent="submitForm">
                        <div>
                            <div class="row">
                                <div class="d-flex col-6 my-auto">
                                    <div class="col-6">
                                        <p for="name">Status:</p>
                                    </div>
                                    <div class="col-6">
                                        <Select v-model="supplier.status" :options="statusOptions" optionValue="value"
                                            optionLabel="label" class="w-100" />
                                        <Message class="my-2" v-if="validationErrors.status" severity="error">
                                            {{ validationErrors.status[0] }}</Message>
                                    </div>
                                </div>
                                <div class="d-flex col-6 my-2">
                                    <div class="col-6 my-auto">
                                        <p for="userid">Company Logo(Optional):</p>
                                    </div>
                                    <div class="col-6 my-auto">
                                        <FileUpload name="demo[]" accept="image/*" :fileLimit="1"
                                            :maxFileSize="10485760" :showUploadButton="false"
                                            @select="handleFileSelect($event)" :showCancelButton="false">
                                            <template #empty>
                                                <img :src="`/storage/${supplier.company_logo}`" class="w-25"
                                                    alt="Initial Image" v-if="supplier.company_logo">
                                                <span v-if="supplier.company_logo"><br> Drag and drop files to here to
                                                    upload.</span>
                                                <span v-else>Drag and drop files to here to
                                                    upload.</span>
                                            </template>
                                            <template #default>
                                            </template>
                                        </FileUpload>
                                        <Message class="my-2" v-if="validationErrors.logo" severity="error">{{
                            validationErrors.logo[0]
                        }}
                                        </Message>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="d-flex col-6 my-2">
                                    <div class="col-6 my-auto">
                                        <p for="userid">Supplier ID:</p>
                                    </div>
                                    <div class="col-6 my-auto">
                                        <InputText class="w-100" v-model="supplier.supplier_id" :disabled="isEditMode"
                                            :class="{ 'p-invalid': !userIdPatternValid || validationErrors.supplier_id }" />
                                        <Message class="my-2" v-if="!userIdPatternValid" severity="error">User ID must
                                            be alphanumeric and between 1 and 10 characters long.</Message>
                                        <Message class="my-2" v-if="validationErrors.supplier_id" severity="error">
                                            {{ validationErrors.supplier_id[0]
                                            }}
                                        </Message>
                                    </div>
                                </div>
                                <div class="d-flex col-6 my-auto">
                                    <div class="col-6">
                                        <p for="name">Supplier Company Header:</p>
                                    </div>
                                    <div class="col-6">
                                        <InputText class="w-100" v-model="supplier.company_header"
                                            :class="{ 'p-invalid': validationErrors.company_header }" />
                                        <Message class="my-2" v-if="validationErrors.company_header" severity="error">
                                            {{ validationErrors.company_header[0] }}</Message>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="name">Company Name:</p>
                                    </div>
                                    <div class="col-6">
                                        <InputText class="w-100" v-model="supplier.name"
                                            :class="{ 'p-invalid': validationErrors.name }" />
                                        <Message class="my-2" v-if="validationErrors.name" severity="error">
                                            {{ validationErrors.name[0] }}</Message>
                                    </div>
                                </div>
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="officePhone">Office Phone/Mobile:</p>
                                    </div>
                                    <div class="col-6">
                                        <InputText class="w-100" v-model="supplier.officePhone"
                                            :class="{ 'p-invalid': validationErrors.officePhone }" />
                                        <Message class="my-2" v-if="validationErrors.officePhone" severity="error">

                                            {{ validationErrors.officePhone[0] }} </Message>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="address">Address:</p>
                                    </div>
                                    <div class="col-6">
                                        <Textarea v-model="supplier.address" class="w-100"
                                            :class="{ 'p-invalid': validationErrors.address }" />
                                        <Message class="my-2" v-if="validationErrors.address" severity="error">
                                            {{ validationErrors.address[0] }}
                                        </Message>
                                    </div>
                                </div>
                                <div class="d-flex col-6">
                                    <div class="col-6">
                                        <p for="website">Website:</p>
                                    </div>
                                    <div class="col-6">
                                        <InputText class="w-100" v-model="supplier.website"
                                            :class="{ 'p-invalid': validationErrors.website }" />
                                        <Message class="my-2" v-if="validationErrors.website" severity="error"> {{
                            validationErrors.website[0] }}
                                        </Message>
                                    </div>
                                </div>
                            </div>
                            <h3 class="fw-bold" style="color: #14245c;">Bank Details</h3>
                            <div class="row my-1">
                                <div class="d-flex col-12">
                                    <div class="col-3">
                                        <p for="address">Beneficiary Bank:</p>
                                    </div>
                                    <div class="col-9">
                                        <InputText v-model="supplier.bank" class="w-100 my-2"
                                            :class="{ 'p-invalid': validationErrors.bank }" />
                                        <Message class="my-2" v-if="validationErrors.bank" severity="error">{{
                            validationErrors.bank[0] }}</Message>
                                    </div>
                                </div>
                                <div class="d-flex col-12">
                                    <div class="col-3">
                                        <p for="website">Beneficiary Bank Address:</p>
                                    </div>
                                    <div class="col-9">
                                        <InputText v-model="supplier.bank_address" class="w-100 my-2"
                                            :class="{ 'p-invalid': validationErrors.bank_address }" />
                                        <Message class="my-2" v-if="validationErrors.bank_address" severity="error">{{
                            validationErrors.bank_address[0] }}</Message>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="d-flex col-12">
                                    <div class="col-3">
                                        <p for="address">SWIFT Code:</p>
                                    </div>
                                    <div class="col-9">
                                        <InputText v-model="supplier.swift_code" class="w-100 my-2"
                                            :class="{ 'p-invalid': validationErrors.swift_code }" />
                                        <Message class="my-2" v-if="validationErrors.swift_code" severity="error">{{
                            validationErrors.swift_code[0]
                        }}</Message>
                                    </div>
                                </div>
                                <div class="d-flex col-12">
                                    <div class="col-3">
                                        <p for="website">CHIPS No:</p>
                                    </div>
                                    <div class="col-9">
                                        <InputText v-model="supplier.chips_no" class="w-100 my-2"
                                            :class="{ 'p-invalid': validationErrors.chips_no }" />
                                        <Message class="my-2" v-if="validationErrors.chips_no" severity="error">{{
                            validationErrors.chips_no[0] }}
                                        </Message>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="d-flex col-12">
                                    <div class="col-3">
                                        <p for="address">Beneficiary Name:</p>
                                    </div>
                                    <div class="col-9">
                                        <InputText v-model="supplier.beneficiary_name" class="w-100 my-2"
                                            :class="{ 'p-invalid': validationErrors.beneficiary_name }" />
                                        <Message class="my-2" v-if="validationErrors.beneficiary_name" severity="error">
                                            {{
                            validationErrors.beneficiary_name[0] }}</Message>
                                    </div>
                                </div>
                                <div class="d-flex col-12">
                                    <div class="col-3">
                                        <p for="website">Beneficiary Account Number:</p>
                                    </div>
                                    <div class="col-9">
                                        <InputText v-model="supplier.account_no" class="w-100 my-2"
                                            :class="{ 'p-invalid': validationErrors.account_no }" />
                                        <Message class="my-2" v-if="validationErrors.account_no" severity="error">{{
                            validationErrors.account_no[0]
                        }}</Message>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3" v-if="isEditMode">
                            <h3 class="fw-bold" style="color: #14245c;">Contact Person</h3>
                            <DataTable :value="supplier.person" responsiveLayout="scroll" sortMode="multiple"
                                removableSort>
                                <Column field="userid" header="User ID" sortable>
                                    <template #body="slotProps">
                                        <router-link :to="{ name: 'edituser', params: { id: slotProps.data.id } }">
                                            {{ slotProps.data.userid }}
                                        </router-link>
                                    </template>
                                </Column>
                                <Column field="name" header="Full Name" sortable></Column>
                                <Column field="email" header="Email" sortable></Column>
                                <Column field="status" header="Status" sortable>
                                    <template #body="slotProps">
                                        <span
                                            :class="{ 'badge': true, 'bg-success-new': slotProps.data.status === 'active', 'bg-danger': slotProps.data.status !== 'active' }">
                                            {{ slotProps.data.status === 'active' ? 'Active' : 'InActive' }}
                                        </span>
                                    </template>
                                </Column>
                                <template #empty>
                                    <div class="text-center">

                                        No user available
                                    </div>
                                </template>
                            </DataTable>
                        </div>
                        <div class="form-group">
                            <label for="supplierDescription" class="form-label">Supplier Description</label>
                            <Textarea class="w-100" id="supplierDescription" v-model="supplier.supplierDescription"
                                rows="3" style="height: 120px;"
                                :class="{ 'p-invalid': validationErrors.supplierDescription }" />
                            <Message class="my-2" v-if="validationErrors.supplierDescription" severity="error">{{
                            validationErrors.supplierDescription[0] }}</Message>
                        </div>
                        <div class="row my-3">
                            <div class="form-group col-6 my-2">
                                <label class="form-label">Primary Product Group</label>
                                <div class="form-group">
                                    <MultiSelect display="chip" filter placeholder="Select Group" optionValue="id"
                                        v-model="supplier.group" :options="productOptions" :multiple="true"
                                        optionLabel="group_name" class="w-100" />
                                </div>
                                <Message class="my-2" v-if="validationErrors.group" severity="error">
                                    {{ validationErrors.group[0] }}</Message>
                            </div>
                            <div class="form-group col-6 my-2">
                                <label class="form-label">Secondary Product Group</label>
                                <div class="form-group">
                                    <MultiSelect display="chip" filter placeholder="Select Group" optionValue="id"
                                        v-model="supplier.Secgroup" :options="productOptions" :multiple="true"
                                        optionLabel="group_name" class="w-100" />
                                </div>
                                <Message class="my-2" v-if="validationErrors.Secgroup" severity="error">
                                    {{ validationErrors.Secgroup[0] }}</Message>
                            </div>
                        </div>
                        <div class="d-flex gap-2 my-2">
                            <Button type="submit" severity="success" label="Submit" class="col-1"
                                style="height: 45px;" />
                            <Button type="reset" severity="warn" label="Clear" class="btn btn-warning col-1"
                                style="height: 45px;" @click="resetForm" />
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
                            <DataTable :value="orders" responsiveLayout="scroll" :rows="10" stripedRows
                                sortMode="multiple" removableSort>
                                <Column field="id" header="Order Number" sortable>
                                    <template #body="slotProps">
                                        <router-link :to="{ name: 'order_edit', params: { id: slotProps.data.id } }"
                                            class="text-underline">
                                            {{ slotProps.data.id }}
                                        </router-link>
                                    </template>
                                </Column>
                                <Column field="orderdate" header="Order Date" sortable></Column>
                                <Column field="quantity_unit" header="Quantity" sortable></Column>
                                <Column field="article" header="Article Number" sortable></Column>

                                <template #empty>
                                    <div class="text-center">

                                        No orders available
                                    </div>
                                </template>
                            </DataTable>
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
import { read, utils } from "xlsx";




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
            isEditMode: false,
            file: '',
            statusOptions: [
                { label: 'Active', value: 'active' },
                { label: 'Inactive', value: 'inactive' }
            ]
        }
    },
    methods: {
        handleExcelSelect(event) {
            // Get the selected file
            const file = event.files[0];
            const reader = new FileReader();

            reader.onload = (e) => {
                const data = new Uint8Array(e.target.result);
                const workbook = read(data, { type: 'array' });
                const firstSheet = workbook.Sheets[workbook.SheetNames[0]];

                // Parse the Excel data into a JSON array
                const excelData = utils.sheet_to_json(firstSheet, { header: 1 });

                // Assuming the first row in Excel contains the headers
                const headers = excelData[0];
                const rows = excelData.slice(1); // Data without headers

                // Map the data to your supplier fields based on the headers
                rows.forEach((row) => {
                    headers.forEach((header, index) => {
                        if (header.toLowerCase() === 'name') {
                            this.supplier.name = row[index];
                        } else if (header.toLowerCase() === 'supplier_id') {
                            this.supplier.supplier_id = row[index];
                        } else if (header.toLowerCase() === 'address') {
                            this.supplier.address = row[index];
                        } else if (header.toLowerCase() === 'website') {
                            this.supplier.website = row[index];
                        } else if (header.toLowerCase() === 'officephone') {
                            this.supplier.officePhone = row[index];
                        } else if (header.toLowerCase() === 'description') {
                            this.supplier.supplierDescription = row[index];
                        } else if (header.toLowerCase() === 'bank') {
                            this.supplier.bank = row[index];
                        } else if (header.toLowerCase() === 'bank_address') {
                            this.supplier.bank_address = row[index];
                        } else if (header.toLowerCase() === 'swift_code') {
                            this.supplier.swift_code = row[index];
                        } else if (header.toLowerCase() === 'chips_no') {
                            this.supplier.chips_no = row[index];
                        } else if (header.toLowerCase() === 'beneficiary_name') {
                            this.supplier.beneficiary_name = row[index];
                        } else if (header.toLowerCase() === 'account_no') {
                            this.supplier.account_no = row[index];
                        }
                    });
                });

                console.log(this.supplier); // For debugging, see the mapped data
            };

            reader.readAsArrayBuffer(file);
        },
        handleFileSelect(event) {
            // Get the selected file
            this.file = event.files[0];
            console.log(this.file);

        },
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
            // if (!this.supplier.name) this.errors.push('Supplier name is required.');
            // if (!this.supplier.address) this.errors.push('Address is required.');
            if (!this.supplier.website) this.errors.push('Website is required.');
            if (!this.supplier.supplierDescription) this.errors.push('Supplier description is required.');
            if (!this.supplier.supplier_id) this.errors.push('Supplier ID is required.');
            if (!this.supplier.group.length) this.errors.push('Product group is required.');

            if (!this.errors.length) {
                const formData = new FormData();
                if (this.file) {
                    formData.append('logo', this.file);
                }

                // Append other fields from `this.supplier` to the FormData
                this.supplier.group.forEach((item) => {
                    formData.append('group[]', item);
                });

                // Append each item in the Secgroup array individually
                this.supplier.Secgroup.forEach((item) => {
                    formData.append('Secgroup[]', item);
                });

                // Append any other fields in `this.supplier`
                for (const [key, value] of Object.entries(this.supplier)) {
                    if (key !== 'group' && key !== 'Secgroup') {
                        formData.append(key, value);
                    }
                }

                try {
                    let response;
                    if (this.isEditMode) {
                        const id = this.$route.params.id;
                        response = await axios.post(`/api/suppliers/${id}`, formData);

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
                    group: supplierData.group ? supplierData.group.map(Number) : [], // Convert to array of integers
                    Secgroup: supplierData.sec_group ? supplierData.sec_group.map(Number) : [],
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
                    company_logo: supplierData.company_logo,
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
.table {
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 20px;

    border-radius: 10px 10px 0 0;
    overflow: hidden;
}
</style>
