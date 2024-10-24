<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">

                <div class="card  ">
                    <div class="card-header  ">
                        <div class="">

                        </div>
                        <div class="d-flex justify-content-between align-items-center mx-3">
                            <span>
                                <span class=" fw-bold fs-4 text-uppercase" style="color: #14245c;">Order
                                    List:</span>
                            </span>

                            <div class="col-5 d-flex">
                                <div class="col-12 d-flex">
                                    <div class="col-8">
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1"><i style="color: #41b400;"
                                                    class="bx bx-filter-alt fw-bold fs-4"></i></span>
                                            <input type="text" name="search" class="form-control " v-model="searchQuery"
                                                ref="search" placeholder="Write here to filter..." />
                                        </div>
                                    </div>
                                    <div class="col-4 mx-2">
                                        <router-link :to="{ name: 'order_entry' }"
                                            v-if="can('orderGeneralSinglePage | createNewOrder')"
                                            class="btn btn-warning fw-bold text-dark">Create New Order
                                        </router-link>
                                    </div>

                                </div>

                            </div>
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
                    <div class="card-body rounded-top table-responsive" v-else>


                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-hover  ">
                            <thead style="color: #009de1; " class="text-center">
                                <tr class="cursor-pointer">
                                    <th class="text-nowrap" @click="sortTable('buyerid.userid')">Buyer ID <i
                                            :class="getSortIcon('buyerid.userid')" class="ms-1"></i></th>
                                    <th class="text-nowrap" @click="sortTable('id')"> Order Number <i
                                            :class="getSortIcon('id')" class="ms-1"></i></th>
                                    <th class="text-nowrap" @click="sortTable('status')">Status <i
                                            :class="getSortIcon('status')" class="ms-1"></i></th>
                                    <th class="text-nowrap" @click="sortTable('updated_at')">Date Modified <i
                                            :class="getSortIcon('updated_at')" class="ms-1"></i></th>
                                    <th class="text-nowrap" @click="sortTable('created_at')">Date Created <i
                                            :class="getSortIcon('created_at')" class="ms-1"></i></th>
                                    <th class="text-nowrap" @click="sortTable('sendoutdate')">Latest Send Out Date <i
                                            :class="getSortIcon('sendoutdate')" class="ms-1"></i></th>
                                    <th class="text-nowrap" @click="sortTable('supplierid.userid')">Supplier ID <i
                                            :class="getSortIcon('supplierid.userid')" class="ms-1"></i></th>
                                    <th class="text-nowrap">Actions </th>
                                </tr>
                            </thead>
                            <tbody v-for="order in dataToDisplay" :key="order.id" v-if="dataToDisplay.length > 0">
                                <tr class="text-center cursor-pointer" style="border-bottom-color: snow !important;"
                                :class="{ 'highlight': order.notice && order.notice.includes('Fix Date') }"
                                >
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                v-show="order.status == 'New Order'" :value="order.id"
                                                id="flexCheckDefault" v-model="selectedUserIds">
                                            <label class="form-check-label" for="flexCheckDefault"
                                                @click="toggleAccordion(order)">
                                                {{ order.buyerid?.buyer_id }}
                                            </label>
                                        </div>
                                    </td>
                                    <td @click="toggleAccordion(order)">
                                        {{ order.id }}
                                    </td>
                                    <td @click="toggleAccordion(order)">
                                        <span :class="statusBadge(order)">{{ order.status }}</span>
                                    </td>
                                    <td @click="toggleAccordion(order)">{{ updated_at(order) }}</td>
                                    <td @click="toggleAccordion(order)">{{ created_at(order) }}</td>
                                    <td @click="toggleAccordion(order)">{{ order.sendoutdate }}</td>
                                    <td @click="toggleAccordion(order)">{{ order.supplierid?.supplier_id }}</td>


                                    <td>
                                        <!-- <button @click="toggleAccordion(order)" class="btn btn-light"
                                            :class="{ 'rotate-icon': accordionOpen[order.id] }">
                                            <i class="bi bi-pencil"></i>
                                        </button> -->
                                        <router-link :to="{ name: 'order_edit', params: { id: order.id } }"
                                            v-if="can('editOrderDetails | voidOrder')" class="text-success mx-2 btn">
                                            <i class="bi bi-pencil"></i>
                                        </router-link>

                                        <a href="#" @click="deleteUser(order.id)" class="text-danger"><i
                                                class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <transition name="fade">
                                    <tr v-show="accordionOpen[order.id]">
                                        <td :colspan="9">
                                            <Ordershow :orders="order" />
                                        </td>
                                    </tr>
                                </transition>

                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="17">
                                        <p class="text-center">No orders to display.</p>
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
                        <div class="my-2">
                            <button type="button" :disabled="!selectedUserIds.length"
                                :data-bs-toggle="selectedUserIds.length ? 'modal' : ''" data-bs-target="#supplierModal"
                                @click="openSupplierModal" class="btn btn-warning">
                                Pricing
                            </button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Select Supplier</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-check" v-for="(supplier, index) in supplier_profiles"
                                            :key="index">
                                            <input class="form-check-input" type="checkbox" :value="supplier.id"
                                                v-model="supplier.checked">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ supplier.name }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                                        <button type="button" @click="saveChanges" class="btn btn-primary"
                                            data-bs-dismiss="modal">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <EventLogTable :key="componentKey" :filterValue="'Order'" />
            </div>
        </div>
    </section>
    <div v-if="loader" class="loader-overlay">
        <div class="loader"></div>
    </div>
</template>

<script>
import './../index';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import { format } from 'date-fns';
import { parseISO } from 'date-fns';
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';
import Ordershow from './ordershow.vue';


export default {
    emits: ['profileUpdated'],
    components: {
        Ordershow
    },
    name: "order list",
    props: {
        perPage: {
            type: Number,
            default: 10
        }
    },
    data() {
        return {
            loader: false,
            sortKey: '',
            sortAsc: true,
            selectedUserIds: [],
            groupId: null,
            supplier_profiles: [],
            isLoading: true,
            bank_name: '',
            file: null,
            orders: [],
            accordionOpen: {},
            currentPage: 1,
            componentKey: 0,
            searchQuery: ''
        };
    },
    watch: {
        data(newVal) {
            this.orders = newVal;
        }
    },
    computed: {

        filteredUsers() {
            return this.orders.filter(order => {
                return (
                    (order.buyerid && order.buyerid.buyer_id.toString().toLowerCase().includes(this.searchQuery.toLowerCase())) ||
                    (order.supplierid && order.supplierid.supplier_id.toString().toLowerCase().includes(this.searchQuery.toLowerCase())) ||
                    (order.status.toString().toLowerCase().includes(this.searchQuery.toLowerCase()))
                );
            });
        },
        totalPages() {
            return Math.ceil(this.orders.length / this.perPage)
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.perPage
            const end = start + this.perPage
            return this.orders.slice(start, end)
        },
        dataToDisplay() {
            if (this.searchQuery) {
                return this.filteredUsers;
            } else {
                return this.paginatedData;
            }
        }
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
            this.orders.sort((a, b) => {
                let aValue = this.getNestedValue(a, key);
                let bValue = this.getNestedValue(b, key);

                if (aValue === null || aValue === undefined) aValue = '';
                if (bValue === null || bValue === undefined) bValue = '';

                let result = 0;
                if (aValue < bValue) {
                    result = -1;
                } else if (aValue > bValue) {
                    result = 1;
                }
                return this.sortAsc ? result : -result;
            });
        },

        getNestedValue(obj, key) {
            const keys = key.split('.');
            let value = obj;
            for (let i = 0; i < keys.length; i++) {
                if (value) {
                    value = value[keys[i]];
                } else {
                    return null;
                }
            }
            return value;
        },

        getSortIcon(key) {
            if (this.sortKey === key) {
                return this.sortAsc ? 'fas fa-sort-up' : 'fas fa-sort-down';
            }
            return 'fas fa-sort';
        },
        async saveChanges() {
            this.loader = true;
            NProgress.start();
            try {
                const selectedSupplierIds = this.supplier_profiles
                    .filter(supplier => supplier.checked)
                    .map(supplier => supplier.id);

                const data = {
                    selectedOrderIds: this.selectedUserIds,
                    selectedSupplierIds: selectedSupplierIds
                };
                console.log(data);
                const response = await axios.post('/api/saveSelectedOrders', data);
                console.log(response);
                this.selectedUserIds = [];
                this.loader = false;
                if (response.status == 200) {
                    NProgress.done();
                    this.componentKey += 1;
                    this.fetchUsers();
                    toastr.success(response.data.message);
                } else {
                    NProgress.done();
                }
            } catch (error) {
                this.loader = false;
                NProgress.done();
                toastr.error('Please Select Valid Supplier.');
                // Handle error if needed
                console.error('Error saving data:', error);
            }
        },
        openSupplierModal() {
            if (!this.selectedUserIds.length) {
                Swal.fire({
                    icon: 'error',
                    title: 'No orders selected',
                    text: 'Please select at least one order to proceed with pricing.'
                });
                return;
            };
            // Find the first checked order
            const checkedUser = this.orders.find(order => this.selectedUserIds.includes(order.id));
            console.log(checkedUser);
            // Check if a order is found and has a group ID
            if (checkedUser && checkedUser.group) {
                // Set the group ID
                this.groupId = checkedUser.group;
                console.log(this.groupId);
                // Send selected order IDs and group ID to the server
                this.fetchSupplierProfiles(this.groupId);
            } else {
                // Handle case where no checked order with group ID is found
                console.error('No checked order with group ID found.');
            }
        },

        fetchSupplierProfiles(groupId) {
            NProgress.start();
            console.log(groupId);
            axios.get(`/api/supplier_profiles/${groupId}`) // Replace '/api/supplier_profiles/' with your API endpoint
                .then(response => {
                    this.supplier_profiles = response.data;
                    console.log(response);
                    NProgress.done();
                })
                .catch(error => {
                    console.error(error);
                    NProgress.done();
                });
        },
        handleRecordUpdated() {
            this.accordionOpen = {};
            // Refresh the data in the parent component
            this.fetchUsers();
        },
        statusBadge(order) {
            switch (order.status) {
                case 'New Order':
                    return 'badge bg-primary';
                case 'Printview Confirmation':
                    return 'badge bg-cyan';
                case 'Printview Reject':
                    return 'badge bg-danger';
                case 'Order Confirm':
                    return 'badge bg-success';
                case 'Cargo Ready':
                    return 'badge bg-warning';
                case 'Shipment Approval':
                    return 'badge bg-info';
                case 'Export/Import':
                    return 'badge bg-dark';
                case 'Price':
                    return 'badge bg-dark';
                case 'Delivered':
                    return 'badge bg-secondary';
                default:
                    return 'badge bg-secondary';
            }
        },
        updated_at(order) {
            if (order.updated_at) {
                // Parse the datetime string using date-fns
                const parsedDateTime = parseISO(order.updated_at);
                // Format the parsed date using date-fns
                return format(parsedDateTime, 'dd-MM-yyyy HH:mm');
            } else {
                return '';
            }
        },
        created_at(order) {
            if (order.created_at) {
                // Parse the datetime string using date-fns
                const parsedDateTime = parseISO(order.created_at);
                // Format the parsed date using date-fns
                return format(parsedDateTime, 'dd-MM-yyyy HH:mm');
            } else {
                return '';
            }
        },
        toggleAccordion(order) {
            this.accordionOpen[order.id] = !this.accordionOpen[order.id];
        },
        changePage(page) {
            this.currentPage = page
        },
        async deleteUser(userId) {
            // Display SweetAlert confirmation dialog
            const result = await Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this inquiry!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            });

            if (result.isConfirmed) {
                // User confirmed, proceed with the deletion
                try {
                    await axios.delete(`/api/orderDelete/${userId}`);

                    // If successful, remove the order from the local data
                    this.orders = this.orders.filter(order => order.id !== userId);
                    this.componentKey += 1;
                    Swal.fire({
                        icon: 'success',
                        title: 'Order deleted successfully',
                    });
                } catch (error) {
                    console.error('Error deleting order:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error deleting order',
                    });
                }
            }
        },
        async fetchUsers() {
            NProgress.start();
            try {
                const response = await axios.get('/api/orderentry');
                this.orders = response.data;
                // this.pagination.totalItems = response.data.total;
                console.log(response.data);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error('Error fetching orders:', error);
                toastr.error('Error fetching data');
            }
        },

    },
};
</script>

<style scoped>
@import url('./../style.css');

.rotate-icon {
    transform: rotate(180deg);
}

.bg-cyan {
    background-color: #12d4b3 !important;
}

.bg-pink {
    background-color: #b40096 !important;
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

td {
    border: none !important;
}

.rounded-top-new {
    border-top-left-radius: 2.25rem !important;
    border-top-right-radius: 2.25rem !important;
}

.rounded-bottom-new {
    border-bottom-left-radius: 2.25rem !important;
    border-bottom-right-radius: 2.25rem !important;
}

.loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    /* Semi-transparent black overlay */
    display: flex;
    justify-content: center;
    align-items: center;
    backdrop-filter: blur(5px);
    /* Add blur effect */
    z-index: 9999;
    /* Ensure it's above other elements */
}

.loader {
    border: 4px solid #f3f3f3;
    /* Light gray border */
    border-top: 4px solid #3498db;
    /* Blue border for spinning effect */
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 2s linear infinite;
    /* Spin animation */
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
