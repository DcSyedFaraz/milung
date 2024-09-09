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
                                <span class=" fw-bold fs-4 text-uppercase" style="color: #14245c;">Product
                                    Groups:</span>
                            </span>

                            <div class="col-4 d-flex">
                                <div class="col-12 d-flex">
                                    <div class="col-8">
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1"><i style="color: #41b400;"
                                                    class="bx bx-filter-alt fw-bold fs-4"></i></span>
                                            <input type="text" name="search" class="form-control " v-model="searchQuery"
                                                ref="search" placeholder="Search Product groups..." />
                                        </div>
                                    </div>
                                    <div class="col-4 mx-2">
                                        <router-link :to="{ name: 'product_group_entry' }"
                                            class="btn btn-warning fw-bold text-dark">Add New
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
                    <div class="card-body rounded-top" v-else>


                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-hover  ">
                            <thead style="color: #009de1; " class="cursor-pointer">
                                <tr style="">
                                    <th @click="sortTable('group_name')">
                                        Product Group <i :class="getSortIcon('group_name')" class="ms-1"></i>
                                    </th>
                                    <th @click="sortTable('hs_cn')">HS-CN Code <i :class="getSortIcon('hs_cn')"
                                            class="ms-1"></i></th>
                                    <th @click="sortTable('hs_de')">HS-DE Code <i :class="getSortIcon('hs_de')"
                                            class="ms-1"></i></th>
                                    <th @click="sortTable('profit')">Fixed Profit in % <i :class="getSortIcon('profit')"
                                            class="ms-1"></i></th>
                                    <th @click="sortTable('amount')">Fixed Amount <i :class="getSortIcon('amount')"
                                            class="ms-1"></i></th>
                                    <th @click="sortTable('updated_at')">Last Changed <i
                                            :class="getSortIcon('updated_at')" class="ms-1"></i></th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody v-for="prodgroup in dataToDisplay" :key="prodgroup.id">
                                <tr style="border-bottom-color: snow !important;">
                                    <td>{{ prodgroup.group_name }}</td>
                                    <td>{{ prodgroup.hs_cn }}</td>
                                    <td>{{ prodgroup.hs_de }}</td>
                                    <td>{{ prodgroup.profit }}</td>
                                    <td>{{ prodgroup.amount }}</td>
                                    <td>{{ formattedDateTime(prodgroup) }}</td>


                                    <td>
                                        <!-- <button @click="toggleAccordion(prodgroup)" class="btn btn-light"
                                            :class="{ 'rotate-icon': accordionOpen[prodgroup.id] }">
                                            <i class="bi bi-pencil"></i>
                                        </button> -->
                                        <router-link
                                            :to="{ name: 'product_group_update', params: { id: prodgroup.id } }"
                                            class="text-dark btn btn-light">
                                            <i class="bi bi-pencil"></i>
                                        </router-link>

                                        <a href="#" @click="deleteUser(prodgroup.id)" class="text-danger"><i
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
                <EventLogTable :key="componentKey" :filterValue="'Group'" />
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




export default {
    name: "Transaction",
    props: {
        perPage: {
            type: Number,
            default: 10
        }
    },
    data() {
        return {
            componentKey: 0,
            sortAsc: true,
            sortKey: '',
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
            return this.users.filter(prodgroup => {
                return prodgroup.group_name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    (prodgroup.hs_de.toString().includes(this.searchQuery)) ||
                    (prodgroup.hs_cn.toString().includes(this.searchQuery));

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
        formattedDateTime(prodgroup) {
            if (prodgroup.updated_at) {
                // Parse the datetime string using date-fns
                const parsedDateTime = parseISO(prodgroup.updated_at);
                // Format the parsed date using date-fns
                return format(parsedDateTime, 'dd-MM-yyyy HH:mm');
            } else {
                return '';
            }
        },
        toggleAccordion(prodgroup) {
            this.accordionOpen[prodgroup.id] = !this.accordionOpen[prodgroup.id];
        },
        changePage(page) {
            this.currentPage = page
        },
        async fetchUsers() {
            try {
                const response = await axios.get('/api/product_group_get_all');
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
                text: 'You will not be able to recover this group group!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            });

            if (result.isConfirmed) {
                // User confirmed, proceed with the deletion
                try {
                    await axios.delete(`/api/product_group/${userId}`);

                    // If successful, remove the product from the local data
                    this.users = this.users.filter(product => product.id !== userId);
                    this.componentKey += 1;
                    Swal.fire({
                        icon: 'success',
                        title: 'Group deleted successfully',
                    });
                } catch (error) {
                    console.error('Error deleting group:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error deleting group',
                    });
                }
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
