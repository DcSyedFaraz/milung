<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">

                <div class="card  ">
                    <div class="card-header pt-3 pb-5 text-white rounded-top-new" style="background-color: #14245c">
                        <div class="d-flex justify-content-between align-items-center mx-3">
                            <span class=" mt-2 fw-bold fs-4">USERS LIST</span>
                            <span class="fw-bold "><router-link :to="{ name: 'add-user' }" class="text-white">Add
                                    new</router-link></span>
                        </div>
                    </div>

                    <!-- // Loader -->
                    <div class="card-body rounded-top" v-if="isLoading">

                        <div class="d-flex justify-content-center">
                            <div class="spinner-border text-warning" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <!-- // Loader -->
                    <div class="card-body " v-else>


                        <!-- Table with stripped rows -->
                        <table class="table table-striped mt-5 display" id="">
                            <thead style="color: #14245c;">
                                <tr>
                                    <th>
                                        User Type
                                    </th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>User ID</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody v-for="user in paginatedData" :key="user.id">
                                <tr>
                                    <td class="fw-bold">{{ user.roles[0] }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.userid }}</td>

                                    <td>
                                        <span
                                            :class="{ 'badge': true, 'bg-success-new': user.status === 'active', 'bg-danger': user.status !== 'active' }">
                                            {{ user.status === 'active' ? 'Active' : 'InActive' }}
                                        </span>
                                    </td>

                                    <td>
                                        <button @click="toggleAccordion(user)" class="btn btn-light"
                                            :class="{ 'rotate-icon': accordionOpen[user.id] }">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <!-- <router-link :to="'/edit-user/' + user.id" class="text-dark">
                                            <i class="bi bi-pencil"></i>
                                        </router-link> -->

                                        <a href="#" @click="deleteUser(user.id)" class="text-dark"><i
                                                class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <UserAccordion :user="user" :is-open="accordionOpen[user.id]"
                                    @update:success="handleUpdateSuccess" />
                                <!-- <transition name="fade">
                                    <tr v-show="accordionOpen[user.id]">
                                        <td :colspan="7">
                                            <div>
                                                <div class="">
                                                    <form @submit.prevent="updateUser(user.id, user)">
                                                        <div class="col-12 px-3" style="background-color: #e2f2f9;">
                                                            <div class="row">
                                                                <div class="mb-3 col-4">
                                                                    <label for="registerEmail"
                                                                        class="form-label">Name</label>
                                                                    <input type="text" class="form-control"
                                                                        v-model="updateuser.name">
                                                                </div>
                                                                <div class="mb-3 col-4">
                                                                    <label for="registerEmail"
                                                                        class="form-label">Register
                                                                        Email</label>
                                                                    <input type="email" class="form-control"
                                                                        v-model="updateuser.email">
                                                                </div>

                                                                <div class="mb-3 col-2">
                                                                    <label for="status"
                                                                        class="form-label">Status</label>
                                                                    <select class="form-select"
                                                                        v-model="updateuser.status" required>
                                                                        <option value="active">Active</option>
                                                                        <option value="inactive">Inactive</option>
                                                                    </select>

                                                                </div>
                                                                <div class="mb-3 col-2">
                                                                    <label for="userIdContactPerson"
                                                                        class="form-label">ID:</label>
                                                                    <input type="text" disabled class="form-control"
                                                                        :value="user.userid">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-5">
                                                                    <label for="oneTimePassword" class="form-label">One
                                                                        Time
                                                                        Use
                                                                        Password:</label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                                <div class="mb-3 col-5">
                                                                    <label for="oneTimePassword" class="form-label">User
                                                                        ID
                                                                        Contact Person:</label>
                                                                    <input type="tel" class="form-control">
                                                                </div>
                                                                <div class="mb-3 col-1"
                                                                    style="display: flex !important;">
                                                                    <button type="submit"
                                                                        class="btn btn-milung  align-self-end">Save</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-12 ">
                                                            <div class="row py-5">
                                                                <div class="col-3" v-if="user.roles[0] == 'Admin'">
                                                                    <div
                                                                        class="col-12 d-flex justify-content-between mb-3">
                                                                        <div class="fs-5 fw-bold col-6"
                                                                            style="color: #14245c;">
                                                                            Admin</div>
                                                                        <div class="form-check my-auto col-6">
                                                                            <input class="form-check-input"
                                                                                type="checkbox"
                                                                                v-model="admin.selectAll"
                                                                                @change="adminSelectAllChanged">
                                                                            <label class="form-check-label  "
                                                                                for="productEntry">Select All</label>
                                                                        </div>
                                                                    </div>

                                                                    <div v-for="(adm, index) in admin.checkboxes"
                                                                        :key="index" class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            :checked="user.permissions.includes(adm.id)"
                                                                            @change="handleCheckboxChange(user, adm.id)"
                                                                            :value="adm.id">
                                                                        <label class="form-check-label">{{ adm.label
                                                                            }}</label>
                                                                    </div>


                                                                </div>
                                                                <div class="col-3" v-if="user.roles[0] == 'Admin'">
                                                                    <div
                                                                        class="col-12 d-flex justify-content-between mb-3">
                                                                        <div class="fs-5 fw-bold col-6"
                                                                            style="color: #14245c;">
                                                                            Operations </div>
                                                                        <div class="form-check my-auto col-6">
                                                                            <input class="form-check-input"
                                                                                type="checkbox"
                                                                                v-model="operation.selectAll"
                                                                                @change="operationselect">
                                                                            <label class="form-check-label fs-6 "
                                                                                for="productEntry">Select All</label>
                                                                        </div>
                                                                    </div>
                                                                    <div v-for="(ope, index) in operation.checkboxes"
                                                                        :key="index" class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            :checked="user.permissions.includes(ope.id)"
                                                                            @change="handleCheckboxChange(user, ope.id)"
                                                                            :value="ope.id">

                                                                        <label class="form-check-label">{{ ope.label
                                                                            }}</label>
                                                                    </div>

                                                                </div>
                                                                <div class="col-3" v-if="user.roles[0] == 'Admin'">
                                                                    <div
                                                                        class="col-12 d-flex justify-content-between mb-3">
                                                                        <div class="fs-5 fw-bold col-6"
                                                                            style="color: #14245c;">
                                                                            Finance</div>
                                                                        <div class="form-check my-auto col-6">
                                                                            <input class="form-check-input"
                                                                                type="checkbox"
                                                                                v-model="finance.selectAll"
                                                                                @change="financeselect">
                                                                            <label class="form-check-label  "
                                                                                for="productEntry">Select All</label>
                                                                        </div>
                                                                    </div>
                                                                    <div v-for="(fin, index) in finance.checkboxes"
                                                                        :key="index" class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            :checked="user.permissions.includes(fin.value)"
                                                                            @change="handleCheckboxChange(user, fin.value)"
                                                                            :value="fin.value">

                                                                        <label class="form-check-label">{{ fin.label
                                                                            }}</label>
                                                                    </div>


                                                                </div>
                                                                <div class="col-3" v-if="user.roles[0] == 'Admin'">
                                                                    <div
                                                                        class="col-12 d-flex justify-content-between mb-3">
                                                                        <div class="fs-5 fw-bold col-6"
                                                                            style="color: #14245c;">
                                                                            Statics</div>
                                                                        <div class="form-check my-auto col-6">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" v-model="selectAll"
                                                                                @change="selectAllItems" value="true">
                                                                            <label class="form-check-label  "
                                                                                for="productEntry">Select All</label>
                                                                        </div>
                                                                    </div>

                                                                    <div v-for="(item, index) in items" :key="index"
                                                                        class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            :checked="user.permissions.includes(item.value)"
                                                                            :value="item.value"
                                                                            @change="handleCheckboxChange(user, item.value)">

                                                                        <label class="form-check-label"
                                                                            :for="item.id">{{ item.label }}</label>
                                                                    </div>

                                                                </div>
                                                                <div class="col-12" v-if="user.roles[0] == 'Buyer'">
                                                                    <div class="col-12 d-flex  mb-3">
                                                                        <div class="fs-5 fw-bold col-1"
                                                                            style="color: #14245c;">
                                                                            Buyer</div>
                                                                        <div class="form-check my-auto col-1">
                                                                            <input class="form-check-input"
                                                                                type="checkbox"
                                                                                v-model="buyer.selectAll">
                                                                            <label class="form-check-label  "
                                                                                for="productEntry">Select All</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row px-2">
                                                                        <div v-for="(fin, index) in buyer.checkboxes"
                                                                            :key="index" class="form-check col-3">
                                                                            <input class="form-check-input"
                                                                                type="checkbox"
                                                                                :checked="user.permissions.includes(fin.id)"
                                                                                @change="handleCheckboxChange(user, fin.id)"
                                                                                :value="fin.id">
                                                                            <label class="form-check-label">{{ fin.label
                                                                                }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12" v-if="user.roles[0] == 'Supplier'">
                                                                    <div class="col-12 d-flex  mb-3">
                                                                        <div class="fs-5 fw-bold col-1"
                                                                            style="color: #14245c;">
                                                                            Supplier</div>
                                                                        <div class="form-check my-auto col-6">
                                                                            <input class="form-check-input"
                                                                                type="checkbox"
                                                                                v-model="supplier.selectAll">
                                                                            <label class="form-check-label  "
                                                                                for="productEntry">Select All</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row px-2">
                                                                        <div v-for="(fin, index) in supplier.checkboxes"
                                                                            :key="index" class="form-check col-3">
                                                                            <input class="form-check-input"
                                                                                type="checkbox"
                                                                                :checked="user.permissions.includes(fin.id)"
                                                                                @change="handleCheckboxChange(user, fin.id)"
                                                                                :value="fin.id">
                                                                            <label class="form-check-label">{{ fin.label
                                                                                }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>



                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </transition> -->

                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination d-flex justify-content-center">
                                <li class="page-item me-auto fw-bold" :class="{ disabled: currentPage === 1 }">
                                    <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)"><i
                                            class="bi bi-arrow-left"></i> Previous</a>
                                </li>
                                <li class="page-item" v-for="page in totalPages" :key="page"
                                    :class="{ active: page === currentPage }">
                                    <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
                                </li>
                                <li class="page-item ms-auto fw-bold" :class="{ disabled: currentPage === totalPages }">
                                    <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">Next <i
                                            class="bi bi-arrow-right"></i> </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>

<script>
import './index';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import UserAccordion from './users/UserAccordion.vue'



export default {
    components: { UserAccordion },
    props: {

        perPage: {
            type: Number,
            default: 10
        }
    },
    data() {
        return {
            permissions: [],
            isLoading: true,
            updateuser: {
                id: null,
                name: '',
                email: '',
                status: '',
                userid: '',
                roles: '',
                permissions: [],
            },
            // admin: {
            //     selectAll: false,
            //     checkboxes: [
            //         { id: 'issueNewLoginIdPassword', label: 'Issue New Login ID & Password, Reset Password' },
            //         { id: 'setAccessAuthority', label: 'Right to set Access Authority' },
            //         { id: 'userManagement', label: 'User Management (can edit or delete users)' },
            //     ],
            // },
            // selectAll: false,
            // items: [
            //     { id: 'bestSales', label: 'Best Sales 20 Item No. & Qty', value: 'bestSales' },
            //     { id: 'bestPurchase', label: 'Best Purchase 20 Item No. & Qty', value: 'bestPurchase' },
            //     { id: 'salesRevenue', label: 'Sales Revenue (Qty/Volume/Weight Weekly/Monthly/Yearly)', value: 'salesRevenue' },
            //     { id: 'purchaseRevenue', label: 'Purchase Revenue (Qty/Volume/Weight Weekly/Monthly/Yearly)', value: 'purchaseRevenue' },
            // ],
            staticsitems: [],
            adminitems: [],
            operationitems: [],
            financeitems: [],
            operationsSelectAll: false,
            // operation: {
            //     selectAll: false,
            //     checkboxes: [
            //         { id: 'addNewSupplierEntry', label: 'Add New Supplier Entry' },
            //         { id: 'editSupplierEntry', label: 'Edit Supplier Entry' },
            //         { id: 'setEditSupplierIDCode', label: 'Set/Edit Supplier ID Code' },
            //         { id: 'transactionOverview', label: 'Transaction Overview' },
            //         { id: 'createBuyerPriceInquiry', label: 'Create Buyer Price Inquiry' },
            //         { id: 'editBuyerPriceInquiry', label: 'Edit Buyer Price Inquiry' },
            //         { id: 'createBuyerOrder', label: 'Create New Buyer Order' },
            //         { id: 'uploadPrintview', label: 'Upload Printview' },
            //         { id: 'cargoReadyConfirmation', label: 'Cargo Ready Confirmation' },
            //         { id: 'addProductEntry', label: 'Add Product Entry' },
            //         { id: 'editProductEntry', label: 'Edit Product Entry' },
            //         { id: 'accessImportExportCertificateTestingReport', label: 'Access/Import/Export Certificate & Testing Report' },
            //         { id: 'createProductGroup', label: 'Create Product Group' },
            //         { id: 'accessNotifyImportExportFunctionForMinorEKPrice', label: 'Access/Notify/Import/Export Function for Minor EK Price' },
            //         { id: 'createPriceInquiry', label: 'Create Price Inquiry' },
            //         { id: 'orderGeneralSinglePage', label: 'Order General & Single Page' },
            //         { id: 'createNewOrder', label: 'Create New Order' },
            //         { id: 'editOrderDetails', label: 'Edit Order Details' },
            //         { id: 'voidOrder', label: 'Void Order' },
            //         { id: 'milungOrderPriceEnquiry', label: 'MiLung Order Price Enquiry' },
            //         { id: 'confirmRejectPrintview', label: 'Printview Confirm/Reject Button' },
            //         { id: 'massCargoPhotoApproval', label: 'Mass Cargo Photo Approval' },
            //         { id: 'createSONumber', label: 'Create SO Number' },
            //         { id: 'shipmentOverview', label: 'Shipment Overview' },
            //         { id: 'editShipmentOverview', label: 'Edit Shipment Overview' },
            //         { id: 'exportShippingDocuments', label: 'Export Shipping Documents' },
            //     ],
            // },
            // supplier: {
            //     selectAll: false,
            //     checkboxes: [
            //         { id: 'priceInquiry', label: 'Price Inquiry' },
            //         { id: 'supplierOrderPriceQuote', label: 'Supplier Order Price Quote' },
            //         { id: 'supplierOrderConfirmationNotification', label: 'Supplier Order Confirmation Notification' },
            //         { id: 'supplierOrderGeneralSinglePage', label: 'Supplier Order General & Single Page' },
            //         { id: 'uploadPrintview', label: 'Upload Printview' },
            //         { id: 'cargoReadyConfirmation', label: 'Cargo Ready Confirmation' },
            //         { id: 'uploadMassCargoPhoto', label: 'Upload Mass Cargo Photo' },
            //         { id: 'shipmentOverview', label: 'Shipment Overview' },
            //         { id: 'createReceiptNote', label: 'Create Receipt Note' },
            //         { id: 'inputPackingList', label: 'Input and Generate Packing List (CSV optional)' },
            //         { id: 'supplierAccountsReceivable', label: 'Supplier Accounts Receivable' },
            //     ],
            // },
            // buyer: {
            //     selectAll: false,
            //     checkboxes: [
            //         { id: 'transactionOverview', label: 'Transaction Overview' },
            //         { id: 'createBuyerPriceInquiry', label: 'Create Buyer Price Inquiry' },
            //         { id: 'editBuyerPriceInquiry', label: 'Edit Buyer Price Inquiry' },
            //         { id: 'createBuyerOrder', label: 'Create New Buyer Order' },
            //         { id: 'editBuyerOrder', label: 'Edit Buyer Order' },
            //         { id: 'confirmRejectPrintview', label: 'Confirm/Reject Printview' },
            //         { id: 'buyerShipmentOverview', label: 'Buyer Shipment Overview' },
            //         { id: 'addATCNumber', label: 'Add ATC Number' },
            //         { id: 'exportShippingDocuments', label: 'Export Shipping Documents' },
            //         { id: 'buyerAccountPayable', label: 'Buyer Account Payable' },
            //         { id: 'bestSales', label: 'Best Sales 20 Item No. & Qty' },
            //         { id: 'bestPurchase', label: 'Best Purchase 20 Item No. & Qty' },
            //         { id: 'salesRevenue', label: 'Sales Revenue (Qty/Volume/Weight Weekly/Monthly/Yearly)' },
            //         { id: 'purchaseRevenue', label: 'Purchase Revenue (Qty/Volume/Weight Weekly/Monthly/Yearly)' },
            //         { id: 'accessToUSBChipPrice', label: 'Access to USB Chip Price' },
            //     ],
            // },
            // finance: {
            //     selectAll: false,
            //     checkboxes: [
            //         { id: 'transactionOverview', label: 'Transaction Overview', value: 'transactionOverview' },
            //         { id: 'accountPayable', label: 'Account Payable', value: 'accountPayable' },
            //         { id: 'accountReceivable', label: 'Account Receivable', value: 'accountReceivable' },
            //     ],
            // },
            users: [],
            accordionOpen: {},
            currentPage: 1
        };
    },
    watch: {
        data(newVal) {
            this.users = newVal;
        }
    },
    computed: {
        totalPages() {
            return Math.ceil(this.users.length / this.perPage)
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.perPage
            const end = start + this.perPage
            return this.users.slice(start, end)
        }
    },
    mounted() {

    },
    created() {
        this.fetchUsers().then(() => {
            setTimeout(() => {
                this.isLoading = false;
            }, 1000); // Delay of 1 second
        });
    },
    methods: {
        // handleCheckboxChange(user, value) {
        //     const index = user.permissions.indexOf(value);
        //     if (index === -1) {
        //         // If not found, add to permissions
        //         user.permissions.push(value);
        //         this.updateuser.permissions = user.permissions;
        //     } else {
        //         // If found, remove from permissions
        //         user.permissions.splice(index, 1);
        //         this.updateuser.permissions = user.permissions;
        //     }
        //     // You can also console.log the updated permissions here to verify the changes
        //     console.log('Updated Permissions:', this.updateuser.permissions);
        // },
        isPermissionChecked(value, checkboxModel) {
            return checkboxModel.includes(value);
        },

        // populateUpdateUser(user) {
        //     this.updateuser.id = user.id;
        //     this.updateuser.name = user.name;
        //     this.updateuser.email = user.email;
        //     this.updateuser.status = user.status;
        //     this.updateuser.userid = user.userid;
        //     this.updateuser.roles = user.roles;
        //     this.updateuser.permissions = user.permissions;

        //     // Populate the permissions based on the user's current permissions
        //     user.permissions.forEach(permission => {
        //         if (this.items.some(item => item.value === permission)) {
        //             this.staticsitems.push(permission);
        //         } else if (this.admin.checkboxes.some(item => item.id === permission)) {
        //             this.adminitems.push(permission);
        //         } else if (this.operation.checkboxes.some(item => item.id === permission)) {
        //             this.operationitems.push(permission);
        //         } else if (this.finance.checkboxes.some(item => item.value === permission)) {
        //             this.financeitems.push(permission);
        //         }
        //     });
        // },

        financeselect() {
            if (this.financeSelectAll) {
                this.financeitems = this.financeCheckboxes.map(item => item.value);
            } else {
                this.financeitems = [];
            }
        },

        selectAllItems() {
            if (this.selectAll) {
                this.staticsitems = this.items.map(item => item.value);
            } else {
                this.staticsitems = [];
            }
        },
        toggleAccordion(user) {
            this.accordionOpen[user.id] = !this.accordionOpen[user.id];

        },
        changePage(page) {
            this.currentPage = page
        },
        // async updateUser(id, user) {
        //     const formData = {
        //         staticsitems: this.staticsitems,
        //         adminitems: this.adminitems,
        //         operationitems: this.operationitems,
        //         financeitems: this.financeitems,
        //     };
        //     const allItems = Object.values(formData).flat();

        //     // Send formData to your API
        //     // console.log('Form Data:', formData);
        //     try {
        //         const response = await axios.put(`/api/updateusers/${id}`, {
        //             updateuser: this.updateuser,
        //             formData: allItems,
        //         });

        //         if (response.status === 200) {
        //             toastr.success('User updated successfully');
        //             this.accordionOpen = {};
        //             this.fetchUsers();
        //         }
        //     } catch (error) {
        //         if (error.response.status === 422) {
        //             // Validation error, display Toastr messages
        //             const errors = error.response.data.errors;

        //             errors.forEach(errorMessage => {
        //                 toastr.error(errorMessage);
        //             });
        //         } else {
        //             toastr.error('An error occurred while updating the user');
        //         }
        //     }
        // },
        handleUpdateSuccess() {
            // Close the accordion
            this.accordionOpen = {};
            // Refresh the records
            this.fetchUsers();
        },
        async fetchUsers() {
            try {
                const response = await axios.get('/api/users');
                this.users = response.data;
                this.permissions = this.users.map(user => user.permissions);
                console.log(response.data);

            } catch (error) {
                console.error('Error fetching users:', error);
                toastr.error('Error fetching data');
            }
        },
        async deleteUser(userId) {
            // Display SweetAlert confirmation dialog
            const result = await Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this user!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            });

            if (result.isConfirmed) {
                // User confirmed, proceed with the deletion
                try {
                    await axios.delete(`/api/userDelete/${userId}`);

                    // If successful, remove the user from the local data
                    this.users = this.users.filter(user => user.id !== userId);

                    Swal.fire({
                        icon: 'success',
                        title: 'User deleted successfully',
                    });
                } catch (error) {
                    console.error('Error deleting user:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error deleting user',
                    });
                }
            }
        },

    },
};
</script>

<style scoped>
@import url('./style.css');

.rotate-icon {
    transform: rotate(180deg);
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s !important;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}

.page-link {
    border: none !important;
    color: #14245c;
}

.page-item.active .page-link,
.btn-milung {
    background-color: #14245c !important;
    color: white;
}

thead,
th {
    border-color: #009de1 !important;
}

.rounded-top-new {
    border-top-left-radius: 2.25rem !important;
    border-top-right-radius: 2.25rem !important;
}

.rounded-bottom-new {
    border-bottom-left-radius: 2.25rem !important;
    border-bottom-right-radius: 2.25rem !important;
}
</style>
