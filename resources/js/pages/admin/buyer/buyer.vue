<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">

                <div class="card  ">
                    <div class="card-header pt-3  ">
                        <div class="d-flex justify-content-between align-items-center mx-3">
                            <span><span class=" mt-2 fw-bold fs-4 " style="color: #14245c;">Buyer List</span>
                                <!-- <br> <span class="">Overview on all Buyers</span> -->
                            </span>
                            <!-- <span class="fw-bold "><router-link :to="{ name: 'add-user' }" class="text-white">Add
                                    new</router-link></span> -->
                            <router-link :to="{ name: 'buyerEntry' }" v-if="can('addNewBuyerEntry')"
                                class="btn btn-warning fw-bold text-dark">Add New
                                Buyer</router-link>
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
                                        Buyer ID
                                        <i :class="getSortIcon('userid')" class="ms-1"></i>
                                    </th>
                                    <th @click="sortTable('name')">Company Name
                                        <i :class="getSortIcon('name')" class="ms-1"></i>
                                    </th>
                                    <th @click="sortTable('buyer_profile.address')">
                                        Location
                                        <i :class="getSortIcon('buyer_profile.address')" class="ms-1"></i>
                                    </th>
                                    <th @click="sortTable('status')">Status
                                        <i :class="getSortIcon('status')" class="ms-1"></i>
                                    </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in paginatedData" :key="user.id">
                                    <td>{{ user.buyer_id }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.address }}</td>

                                    <td>
                                        <span
                                            :class="{ 'badge': true, 'bg-success-new': user.status === 'active', 'bg-danger': user.status !== 'active' }">
                                            {{ user.status === 'active' ? 'Active' : 'InActive' }}
                                        </span>
                                    </td>

                                    <td>
                                        <!-- <button @click="toggleAccordion(user)" class="btn btn-light" v-if="can('editBuyerEntry')"
                                            :class="{ 'rotate-icon': accordionOpen[user.id] }">
                                            <i class="bi bi-pencil"></i>
                                        </button> -->
                                        <router-link v-if="can('editBuyerEntry')"
                                            :to="{ name: 'editbuyer', params: { id: user.id } }"
                                            class="text-dark btn btn-light">
                                            <i class="bi bi-pencil"></i>
                                        </router-link>

                                        <a href="#" @click="deleteUser(user.id)" class="text-dark"><i
                                                class="bi bi-trash"></i>
                                        </a>
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
                <EventLogTable :key="componentKey" :filterValue="'Buyer'" />
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
                const response = await axios.get('/api/buyer');
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
