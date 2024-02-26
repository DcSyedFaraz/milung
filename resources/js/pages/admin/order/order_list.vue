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

                            <div class="col-4 d-flex">
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
                                            class="btn btn-warning fw-bold text-dark">Create New
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
                                <tr style="">
                                    <th class="text-nowrap">Buyer ID</th>
                                    <th class="text-nowrap"> Order Number </th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Date Modified</th>
                                    <th class="text-nowrap">Date Created</th>
                                    <th class="text-nowrap">Latest SendOut Date</th>
                                    <th class="text-nowrap">Supplier ID</th>
                                    <th class="text-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody v-for="user in dataToDisplay" :key="user.id">
                                <tr class="text-center" style="border-bottom-color: snow !important;">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ user.buyer }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        {{ user.id }}
                                    </td>
                                    <td>
                                        <span :class="statusBadge(user)">{{ user.status }}</span>
                                    </td>
                                    <td>{{ updated_at(user) }}</td>
                                    <td>{{ created_at(user) }}</td>
                                    <td>{{ user.sendoutdate }}</td>
                                    <td>{{ user.supplier }}</td>


                                    <td>
                                        <!-- <button @click="toggleAccordion(user)" class="btn btn-light"
                                            :class="{ 'rotate-icon': accordionOpen[user.id] }">
                                            <i class="bi bi-pencil"></i>
                                        </button> -->
                                        <router-link :to="{ name: 'order_edit', params: { id: user.id } }" class="text-success mx-2">
                                            <i class="bi bi-pencil"></i>
                                        </router-link>

                                        <a href="#" @click="deleteUser(user.id)" class="text-danger"><i
                                                class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <transition name="fade">
                                    <tr v-show="accordionOpen[user.id]">
                                        <td :colspan="7">
                                            <!-- <PriceInquiry mode="edit" :user="user" @record-updated="handleRecordUpdated" /> -->
                                        </td>
                                    </tr>
                                </transition>

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
import './../index';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import { format } from 'date-fns';
import { parseISO } from 'date-fns';
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';


export default {
    components: {
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
            isLoading: true,
            bank_name: '',
            file: null,
            users: [],
            accordionOpen: {},
            currentPage: 1,
            searchQuery: ''
        };
    },
    watch: {
        data(newVal) {
            this.users = newVal;
        }
    },
    computed: {

        filteredUsers() {
            return this.users.filter(user => {
                return user.buyer.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    (user.supplier.toLowerCase().includes(this.searchQuery));

            });
        },
        totalPages() {
            return Math.ceil(this.users.length / this.perPage)
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.perPage
            const end = start + this.perPage
            return this.users.slice(start, end)
        },
        dataToDisplay() {
            if (this.searchQuery) {
                return this.filteredUsers;
            } else {
                return this.paginatedData;
            }
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
        handleRecordUpdated() {
            this.accordionOpen = {};
            // Refresh the data in the parent component
            this.fetchUsers();
        },
        statusBadge(user) {
            switch (user.status) {
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
                case 'Delivered':
                    return 'badge bg-secondary';
                default:
                    return 'badge bg-secondary';
            }
        },
        updated_at(user) {
            if (user.updated_at) {
                // Parse the datetime string using date-fns
                const parsedDateTime = parseISO(user.updated_at);
                // Format the parsed date using date-fns
                return format(parsedDateTime, 'dd-MM-yyyy HH:mm');
            } else {
                return '';
            }
        },
        created_at(user) {
            if (user.created_at) {
                // Parse the datetime string using date-fns
                const parsedDateTime = parseISO(user.created_at);
                // Format the parsed date using date-fns
                return format(parsedDateTime, 'dd-MM-yyyy HH:mm');
            } else {
                return '';
            }
        },
        toggleAccordion(user) {
            this.accordionOpen[user.id] = !this.accordionOpen[user.id];
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

                    // If successful, remove the user from the local data
                    this.users = this.users.filter(user => user.id !== userId);

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
                this.users = response.data;
                // this.pagination.totalItems = response.data.total;
                console.log(response.data);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error('Error fetching users:', error);
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
</style>
