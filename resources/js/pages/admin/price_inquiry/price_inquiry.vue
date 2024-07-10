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
                                <span class=" fw-bold fs-4 text-uppercase" style="color: #14245c;">Price Inquiry General
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
                                        <router-link :to="{ name: 'price_inquiry_entry' }"
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
                        <table class="table table-striped   ">
                            <thead style="color: #009de1; " class="">
                                <tr class="cursor-pointer">
                                    <th @click="sortTable('inquiry_number')">
                                        Inquiry Number
                                        <i :class="getSortIcon('inquiry_number')" class="ms-1"></i>
                                    </th>
                                    <th @click="sortTable('status')">Status <i :class="getSortIcon('status')"
                                            class="ms-1"></i></th>
                                    <th @click="sortTable('updated_at')">Date Modified <i
                                            :class="getSortIcon('updated_at')" class="ms-1"></i></th>
                                    <th @click="sortTable('created_at')">Date Created <i
                                            :class="getSortIcon('created_at')" class="ms-1"></i></th>
                                    <th @click="sortTable('requirements')">Special Requirements <i
                                            :class="getSortIcon('requirements')" class="ms-1"></i></th>
                                    <th>Actions </th>
                                </tr>
                            </thead>
                            <tbody v-for="(inquiry, index) in dataToDisplay" :key="inquiry.id"
                                v-if="dataToDisplay.length > 0">
                                <tr :class="{ 'highlight': inquiry.urgent == 'true' }"
                                    style="border-bottom-color: snow !important;">
                                    <td @click="toggleAccordion(inquiry, index)" class="cursor-pointer">{{
                                                inquiry.inquiry_number }}</td>
                                    <td @click="toggleAccordion(inquiry, index)" class="cursor-pointer">
                                        <span :class="statusBadge(inquiry)">{{ inquiry.status }}</span>
                                    </td>
                                    <td @click="toggleAccordion(inquiry, index)" class="cursor-pointer">{{
                                                updated_at(inquiry) }}</td>
                                    <td @click="toggleAccordion(inquiry, index)" class="cursor-pointer">{{
                                                created_at(inquiry) }}</td>
                                    <td @click="toggleAccordion(inquiry, index)" class="cursor-pointer">{{
                                                inquiry.requirements }}</td>


                                    <td>
                                        <!-- <button @click="toggleAccordion(inquiry)" class="btn btn-light"
                                            :class="{ 'rotate-icon': accordionOpen[inquiry.id] }">
                                            <i class="bi bi-pencil"></i>
                                        </button> -->
                                        <router-link :to="{
                                                name: 'price_inquiry_edit',
                                                params: { id: inquiry.id },
                                            }" class="text-dark btn btn-light">
                                            <i class="bi bi-pencil"></i>
                                        </router-link>

                                        <a href="#" @click="deleteUser(inquiry.id)" class="text-dark"><i
                                                class="bi bi-trash ms-1 text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr v-if="accordionIndex === index">
                                    <td colspan="9">
                                        <PriceInquiryAccordian :inquiry="inquiry" :cargo_place="inquiry.cargo_place"
                                            :supplierData="inquiry.supplierData" />
                                    </td>
                                </tr>


                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="17">
                                        <p class="text-center">No inquiries to display.</p>
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
                <EventLogTable :key="componentKey" :filterValue="'Inquiry'" />
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
import PriceInquiryAccordian from './price_inquiry_accordian.vue';


export default {
    components: {
        PriceInquiryAccordian
    },
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
            sortKey: '',
            sortAsc: true,
            accordionIndex: null,
            isLoading: true,
            bank_name: '',
            file: null,
            price_inq: [],
            accordionOpen: {},
            currentPage: 1,
            searchQuery: ''
        };
    },
    watch: {
        data(newVal) {
            this.price_inq = newVal;
        }
    },
    computed: {

        filteredUsers() {
            return this.price_inq.filter(inquiry => {
                return inquiry.inquiry_number.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    (inquiry.requirements.toLowerCase().includes(this.searchQuery));

            });
        },
        totalPages() {
            return Math.ceil(this.price_inq.length / this.perPage)
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.perPage
            const end = start + this.perPage
            return this.price_inq.slice(start, end)
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
            this.price_inq.sort((a, b) => {
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
        handleRecordUpdated() {
            this.accordionOpen = {};
            // Refresh the data in the parent component
            this.fetchUsers();
        },
        statusBadge(inquiry) {
            switch (inquiry.status) {
                case 'ML Checking':
                    return 'badge bg-primary';
                case 'Supplier Checking':
                    return 'badge bg-cyan';
                case 'Buyer Follow Up':
                    return 'badge bg-success';
                case 'Supplier Follow Up':
                    return 'badge bg-pink';
                case 'Supplier Replied':
                    return 'badge bg-info';
                default:
                    return 'badge bg-secondary';
            }
        },
        updated_at(inquiry) {
            if (inquiry.updated_at) {
                // Parse the datetime string using date-fns
                const parsedDateTime = parseISO(inquiry.updated_at);
                // Format the parsed date using date-fns
                return format(parsedDateTime, 'dd-MM-yyyy HH:mm');
            } else {
                return '';
            }
        },
        created_at(inquiry) {
            if (inquiry.created_at) {
                // Parse the datetime string using date-fns
                const parsedDateTime = parseISO(inquiry.created_at);
                // Format the parsed date using date-fns
                return format(parsedDateTime, 'dd-MM-yyyy HH:mm');
            } else {
                return '';
            }
        },
        toggleAccordion(inquiry, index) {
            if (this.accordionIndex === index) {
                this.accordionIndex = null;
            } else {
                this.accordionIndex = index;
            }
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
                    await axios.delete(`/api/PriceDelete/${userId}`);

                    // If successful, remove the inquiry from the local data
                    this.price_inq = this.price_inq.filter(inquiry => inquiry.id !== userId);
                    this.componentKey += 1;
                    Swal.fire({
                        icon: 'success',
                        title: 'Inquiry deleted successfully',
                    });
                } catch (error) {
                    console.error('Error deleting inquiry:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error deleting inquiry',
                    });
                }
            }
        },
        async fetchUsers() {
            NProgress.start();
            try {
                const response = await axios.get('/api/price_inquiry_get');
                this.price_inq = response.data;
                // this.pagination.totalItems = response.data.total;
                console.log(response.data);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error('Error fetching price_inq:', error);
                toastr.error('Error fetching data');
            }
        },

    },
};
</script>

<style scoped>
@import url('./../style.css');

.highlight {
    background-color: #ffff99;
}

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
