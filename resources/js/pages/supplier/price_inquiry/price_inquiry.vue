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
                                        <!-- <router-link :to="{ name: 'supplier_price_inquiry_entry' }"
                                            class="btn btn-warning fw-bold text-dark">Add New
                                        </router-link> -->
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
                            <tbody v-for="user in dataToDisplay" :key="user.id" v-if="dataToDisplay.length > 0">
                                <tr style="border-bottom-color: snow !important;">
                                    <td>{{ user.inquiry_number }}</td>
                                    <td>
                                        <span :class="statusBadge(user)">{{ user.status }}</span>
                                    </td>
                                    <td>{{ updated_at(user) }}</td>
                                    <td>{{ created_at(user) }}</td>
                                    <td>{{ user.requirements }}</td>


                                    <td>
                                        <!-- <button @click="toggleAccordion(user)" class="btn btn-light"
                                            :class="{ 'rotate-icon': accordionOpen[user.id] }">
                                            <i class="bi bi-pencil"></i>
                                        </button> -->
                                        <router-link :to="{ name: 'supplier_price_inquiry_entry', params: { id: user.id}  }" class="text-dark btn btn-light">
                                            <i class="bi bi-pencil"></i>
                                        </router-link>

                                        <a href="#" @click="deleteUser(user.id)" class="text-dark"><i
                                                class="bi bi-trash"></i>
                                        </a>
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
            inquiry: [],
            accordionOpen: {},
            currentPage: 1,
            searchQuery: ''
        };
    },
    watch: {
        data(newVal) {
            this.inquiry = newVal;
        }
    },
    computed: {

        filteredinquiry() {
            return this.inquiry.filter(user => {
                return user.inquiry_number.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    (user.requirements.toLowerCase().includes(this.searchQuery));

            });
        },
        totalPages() {
            return Math.ceil(this.inquiry.length / this.perPage)
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.perPage
            const end = start + this.perPage
            return this.inquiry.slice(start, end)
        },
        dataToDisplay() {
            if (this.searchQuery) {
                return this.filteredinquiry;
            } else {
                return this.paginatedData;
            }
        }
    },
    mounted() {

    },
    created() {
        this.fetchinquiry().then(() => {
            setTimeout(() => {
                this.isLoading = false;
            }, 1000); // Delay of 1 second
        });
    },
    methods: {
        handleRecordUpdated() {
            this.accordionOpen = {};
            // Refresh the data in the parent component
            this.fetchinquiry();
        },
        statusBadge(user) {
            switch (user.status) {
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
                    await axios.delete(`/api/PriceDelete/${userId}`);

                    // If successful, remove the user from the local data
                    this.inquiry = this.inquiry.filter(user => user.id !== userId);

                    Swal.fire({
                        icon: 'success',
                        title: 'Inquiry deleted successfully',
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
        async fetchinquiry() {
            NProgress.start();
            try {
                const response = await axios.get('/api/supplier/price_inquiry_get');
                this.inquiry = response.data;
                // this.pagination.totalItems = response.data.total;
                console.log(response.data);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error('Error fetching inquiry:', error);
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
