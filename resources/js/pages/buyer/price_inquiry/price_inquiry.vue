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
                                        <router-link :to="{ name: 'buyer_price_inquiry_entry' }"
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
                            <thead style="color: #009de1; " class="">
                                <tr style="">
                                    <th>
                                        Inquiry Number
                                    </th>
                                    <th>Status</th>
                                    <th>Date Modified</th>
                                    <th>Date Created</th>
                                    <th>Special Requirements</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody v-for="inquiry in dataToDisplay" :key="inquiry.id" v-if="dataToDisplay.length > 0">
                                <tr style="border-bottom-color: snow !important;">
                                    <td>{{ inquiry.inquiry_number }}</td>
                                    <td>
                                        <span :class="statusBadge(inquiry)">{{ inquiry.status }}</span>
                                    </td>
                                    <td>{{ updated_at(inquiry) }}</td>
                                    <td>{{ created_at(inquiry) }}</td>
                                    <td>{{ inquiry.requirements }}</td>


                                    <td>
                                        <!-- <button @click="toggleAccordion(inquiry)" class="btn btn-light"
                                            :class="{ 'rotate-icon': accordionOpen[inquiry.id] }">
                                            <i class="bi bi-pencil"></i>
                                        </button> -->
                                        <router-link :to="{ name: 'buyer_price_inquiry_edit', params: { id: inquiry.id}  }" class="text-success fw-bold btn mx-2">
                                            <i class="bi bi-pencil"></i>
                                        </router-link>

                                        <a href="#" @click="deleteinquiry(inquiry.id)" class="text-danger btn"><i
                                                class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
<!--
                                <transition name="fade">
                                    <tr v-show="accordionOpen[inquiry.id]">
                                        <td :colspan="7">
                                            <PriceInquiry mode="edit" :inquiry="inquiry"
                                                @record-updated="handleRecordUpdated" />
                                        </td>
                                    </tr>
                                </transition> -->

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
import PriceInquiry from './price_inquiry_entry.vue';
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';


export default {
    components: {
        PriceInquiry
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
            isLoading: true,
            bank_name: '',
            file: null,
            inquirys: [],
            accordionOpen: {},
            currentPage: 1,
            searchQuery: ''
        };
    },
    watch: {
        data(newVal) {
            this.inquirys = newVal;
        }
    },
    computed: {

        filteredinquirys() {
            return this.inquirys.filter(inquiry => {
                return inquiry.inquiry_number.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    (inquiry.requirements.toLowerCase().includes(this.searchQuery));

            });
        },
        totalPages() {
            return Math.ceil(this.inquirys.length / this.perPage)
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.perPage
            const end = start + this.perPage
            return this.inquirys.slice(start, end)
        },
        dataToDisplay() {
            if (this.searchQuery) {
                return this.filteredinquirys;
            } else {
                return this.paginatedData;
            }
        }
    },
    mounted() {

    },
    created() {
        this.fetchinquirys().then(() => {
            setTimeout(() => {
                this.isLoading = false;
            }, 1000); // Delay of 1 second
        });
    },
    methods: {
        handleRecordUpdated() {
            this.accordionOpen = {};
            // Refresh the data in the parent component
            this.fetchinquirys();
        },
        statusBadge(inquiry) {
            switch (inquiry.status) {
                case 'ML Checking':
                    return 'badge bg-primary';
                case 'ML Replied':
                    return 'badge bg-cyan';
                case 'ML Follow Up':
                    return 'badge bg-success';
                case 'Customer Follow Up':
                    return 'badge bg-pink';
                case 'Customer Quoted':
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
        toggleAccordion(inquiry) {
            this.accordionOpen[inquiry.id] = !this.accordionOpen[inquiry.id];
        },
        changePage(page) {
            this.currentPage = page
        },
        async deleteinquiry(inquiryId) {
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
                // inquiry confirmed, proceed with the deletion
                try {
                    await axios.delete(`/api/buyer/price_inquiry/${inquiryId}`);

                    // If successful, remove the inquiry from the local data
                    this.inquirys = this.inquirys.filter(inquiry => inquiry.id !== inquiryId);

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
        async fetchinquirys() {
            NProgress.start();
            try {
                const response = await axios.get('/api/buyer/price_inquiry');
                this.inquirys = response.data;
                // this.pagination.totalItems = response.data.total;
                console.log(response.data);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error('Error fetching inquirys:', error);
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
