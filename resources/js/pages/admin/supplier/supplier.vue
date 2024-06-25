<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">

                <div class="card  ">
                    <div class="card-header pt-3  ">
                        <div class="d-flex justify-content-between align-items-center mx-3">
                            <span><span class=" mt-2 fw-bold fs-4 " style="color: #14245c;">Supplier List</span>
                                <!-- <br> <span class="">Overview on all Suppliers</span> -->
                            </span>
                            <!-- <span class="fw-bold "><router-link :to="{ name: 'add-user' }" class="text-white">Add
                                    new</router-link></span> -->
                            <router-link v-if="can('editSupplierEntry | setEditSupplierIDCode')"
                                :to="{ name: 'supplerEntry' }" class="btn btn-warning fw-bold text-dark">Add New
                                Supplier</router-link>
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
                    <div class="card-body rounded-top" v-else>


                        <!-- Table with stripped rows -->
                        <table class="table table-striped  display " id="">
                            <thead style="color: white; background-color: #14245c" class="">
                                <tr class="rounded-top-new cursor-pointer" style="">
                                    <th @click="sortTable('userid')">
                                        Supplier ID
                                        <i :class="getSortIcon('userid')" class="ms-1"></i>
                                    </th>
                                    <th @click="sortTable('name')">Comapny Name
                                        <i :class="getSortIcon('name')" class="ms-1"></i>
                                    </th>
                                    <th @click="sortTable('supplier_profile.address')">
                                        Location
                                        <i :class="getSortIcon('supplier_profile.address')" class="ms-1"></i>
                                    </th>
                                    <th @click="sortTable('supplier_profile.group_names')">
                                        Product Group
                                        <i :class="getSortIcon('supplier_profile.group_names')" class="ms-1"></i>
                                    </th>
                                    <th @click="sortTable('status')">Status
                                        <i :class="getSortIcon('status')" class="ms-1"></i>
                                    </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in paginatedData" :key="user.id" v-if="paginatedData.length > 0">
                                    <td>{{ user.userid }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.supplier_profile?.address }}</td>
                                    <td>{{ user.supplier_profile?.group_names.join(', ') }}</td>


                                    <td>
                                        <span
                                            :class="{ 'badge': true, 'bg-success-new': user.status === 'active', 'bg-danger': user.status !== 'active' }">
                                            {{ user.status === 'active' ? 'Active' : 'InActive' }}
                                        </span>
                                    </td>

                                    <td>
                                        <!-- <button v-if="can('editSupplierEntry')" @click="toggleAccordion(user)" class="btn btn-light"
                                            :class="{ 'rotate-icon': accordionOpen[user.id] }">
                                            <i class="bi bi-pencil"></i>
                                        </button> -->
                                        <router-link v-if="can('editSupplierEntry')"
                                            :to="{ name: 'editsupplier', params: { id: user.id } }"
                                            class="text-dark btn btn-light">
                                            <i class="bi bi-pencil"></i>
                                        </router-link>

                                        <a href="#" @click="deleteUser(user.id)" class="text-dark"><i
                                                class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <!-- <transition v-if="can('editSupplierEntry | setEditSupplierIDCode')" name="fade">
                                    <tr v-show="accordionOpen[user.id]">
                                        <td :colspan="7">
                                            <div>
                                                <div class="">
                                                    <form @submit.prevent="updateUser(user.id)">
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
                                                                        :value="user.id">
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
                                                                <div class="col-3">
                                                                    <div
                                                                        class="col-12 d-flex justify-content-between mb-3">
                                                                        <div class="fs-5 fw-bold col-6"
                                                                            style="color: #14245c;">
                                                                            Admin</div>
                                                                        <div class="form-check my-auto col-6">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" v-model="adminSelectAll"
                                                                                @change="adminSelectAllChanged">
                                                                            <label class="form-check-label  "
                                                                                for="productEntry">Select All</label>
                                                                        </div>
                                                                    </div>

                                                                    <div v-for="(item, index) in adminCheckboxes"
                                                                        :key="index" class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            v-model="adminitems" :value="item.value">
                                                                        <label class="form-check-label">{{ item.label
                                                                            }}</label>
                                                                    </div>


                                                                </div>
                                                                <div class="col-3">
                                                                    <div
                                                                        class="col-12 d-flex justify-content-between mb-3">
                                                                        <div class="fs-5 fw-bold col-6"
                                                                            style="color: #14245c;">
                                                                            Operations </div>
                                                                        <div class="form-check my-auto col-6">
                                                                            <input class="form-check-input"
                                                                                type="checkbox"
                                                                                v-model="operationsSelectAll"
                                                                                @change="operationselect">
                                                                            <label class="form-check-label fs-6 "
                                                                                for="productEntry">Select All</label>
                                                                        </div>
                                                                    </div>
                                                                    <div v-for="(item, index) in operationsCheckboxes"
                                                                        :key="index" class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            v-model="operationitems"
                                                                            :value="item.value">
                                                                        <label class="form-check-label">{{ item.label
                                                                            }}</label>
                                                                    </div>

                                                                </div>
                                                                <div class="col-3">
                                                                    <div
                                                                        class="col-12 d-flex justify-content-between mb-3">
                                                                        <div class="fs-5 fw-bold col-6"
                                                                            style="color: #14245c;">
                                                                            Finance</div>
                                                                        <div class="form-check my-auto col-6">
                                                                            <input class="form-check-input"
                                                                                type="checkbox"
                                                                                v-model="financeSelectAll"
                                                                                @change="financeselect">
                                                                            <label class="form-check-label  "
                                                                                for="productEntry">Select All</label>
                                                                        </div>
                                                                    </div>
                                                                    <div v-for="(item, index) in financeCheckboxes"
                                                                        :key="index" class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            v-model="financeitems" :value="item.value">
                                                                        <label class="form-check-label">{{ item.label
                                                                            }}</label>
                                                                    </div>


                                                                </div>
                                                                <div class="col-3">
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
                                                                            :value="item.value" v-model="staticsitems">
                                                                        <label class="form-check-label"
                                                                            :for="item.id">{{
                                item.label }}</label>
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
                                <tr v-else>
                                    <td colspan="17">
                                        <p class="text-center">No user to display.</p>
                                    </td>
                                </tr>
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
                <EventLogTable :key="componentKey" :filterValue="'Supplier'" />
            </div>
        </div>
    </section>
</template>

<script>
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';




export default {
    props: {

        perPage: {
            type: Number,
            default: 10
        }
    },
    data() {
        return {
            componentKey: 0,
            sortKey: '',
            sortAsc: true,
            isLoading: true,
            updateuser: {
                // id: this.$route.params.id,
                name: '',
                email: '',
                status: '',
                buyer_id: '',
                roles: '',
            },
            adminSelectAll: false,
            adminCheckboxes: [
                { id: 'idPassword', label: 'Issue New Login ID & Password to Vim Internal Staff', value: 'idPassword' },
                { id: 'Authority', label: 'Right to set Access Authority', value: 'Authority' },
            ],
            selectAll: false,
            items: [
                { id: 'bestSales', label: 'Best Sales 20 Item No. & Qty', value: 'bestSales' },
                { id: 'bestPurchase', label: 'Best Purchase 20 Item No. & Qty', value: 'bestPurchase' },
                { id: 'salesRevenue', label: 'Sales Revenue (Qty/Volume/Weight Weekly/Monthly/Yearly)', value: 'salesRevenue' },
                { id: 'purchaseRevenue', label: 'Purchase Revenue (Qty/Volume/Weight Weekly/Monthly/Yearly)', value: 'purchaseRevenue' },
            ],
            staticsitems: [],
            adminitems: [],
            operationitems: [],
            financeitems: [],
            operationsSelectAll: false,
            operationsCheckboxes: [
                { id: 'productEntry', label: 'Product Entry', value: 'productEntry', checked: false },
                { id: 'createNewAN', label: 'Create New AN', value: 'createNewAN', checked: false },
                { id: 'createNewOrder', label: 'Create New Order', value: 'createNewOrder', checked: false },
                { id: 'productGroup', label: 'Product Group', value: 'productGroup', checked: false },
                { id: 'confirmOrRejectPrintview', label: 'Confirm or Reject Printview', value: 'confirmOrRejectPrintview', checked: false },
                { id: 'orderGeneralSinglePage', label: 'Order General & Single Page', value: 'orderGeneralSinglePage', checked: false },
                { id: 'atcNumberInput', label: 'ATC Number Input', value: 'atcNumberInput', checked: false },
                { id: 'exportShippingDocuments', label: 'Export Shipping Documents', value: 'exportShippingDocuments', checked: false },
                { id: 'voidOrder', label: 'Void Order', value: 'voidOrder', checked: false },
            ],
            financeSelectAll: false,
            financeCheckboxes: [
                { id: 'accountPayable', label: 'Account Payable', value: 'accountPayable', checked: false },
                { id: 'accountReceivable', label: 'Account Receivable', value: 'accountReceivable', checked: false },
            ],
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
        sortTable(key) {
            if (this.sortKey === key) {
                this.sortAsc = !this.sortAsc;
            } else {
                this.sortKey = key;
                this.sortAsc = true;
            }
            this.users.sort((a, b) => {
                const getValue = (obj, path) => path.split('.').reduce((acc, part) => acc && acc[part], obj);
                const aValue = getValue(a, key);
                const bValue = getValue(b, key);

                let result = 0;
                if (aValue < bValue) {
                    result = -1;
                } else if (aValue > bValue) {
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
        adminSelectAllChanged() {
            if (this.adminSelectAll) {
                this.adminitems = this.adminCheckboxes.map(item => item.value);
            } else {
                this.adminitems = [];
            }
        },
        financeselect() {
            if (this.financeSelectAll) {
                this.financeitems = this.financeCheckboxes.map(item => item.value);
            } else {
                this.financeitems = [];
            }
        },
        operationselect() {
            if (this.operationsSelectAll) {
                this.operationitems = this.operationsCheckboxes.map(item => item.value);
            } else {
                this.operationitems = [];
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
        async updateUser(id) {
            const formData = {
                staticsitems: this.staticsitems,
                adminitems: this.adminitems,
                operationitems: this.operationitems,
                financeitems: this.financeitems,
            };

            // Send formData to your API
            // console.log('Form Data:', formData);
            try {
                const response = await axios.put(`/api/updateusers/${id}`, [this.updateuser, formData]);

                if (response.status === 200) {
                    toastr.success('User updated successfully');
                    this.$router.push({ name: 'user' });
                }
            } catch (error) {
                if (error.response.status === 422) {
                    toastr.error('Please fix the validation errors and try again');
                } else {
                    toastr.error('An error occurred while updating the user');
                }
            }
        },
        async fetchUsers() {
            try {
                const response = await axios.get('/api/supplier');
                this.users = response.data;
                // this.pagination.totalItems = response.data.total;
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
                    this.componentKey += 1;
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
.rotate-icon {
    transform: rotate(180deg);
}

.table {
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 20px;

    border-radius: 10px 10px 0 0;
    overflow: hidden;
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



.rounded-top-new {
    border-top-left-radius: 2.25rem !important;
    border-top-right-radius: 2.25rem !important;
}

.rounded-bottom-new {
    border-bottom-left-radius: 2.25rem !important;
    border-bottom-right-radius: 2.25rem !important;
}
</style>
