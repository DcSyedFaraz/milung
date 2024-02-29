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
                                    Price Inquiry:</span>
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
                                        <button class="btn btn-warning fw-bold text-dark">Place All
                                        </button>
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
                            <thead style="color: #009de1; " class="text-center fs-7 ">
                                <tr style="">
                                    <th class="text-nowrap"> Order Number </th>
                                    <th class="text-nowrap">AN Ref./ <br> Old Order Number</th>
                                    <th class="text-nowrap">Product Group</th>
                                    <th class="text-nowrap">Product</th>
                                    <th class="text-nowrap">Storage/Capacity</th>
                                    <th class="text-nowrap">Accessories</th>
                                    <th class="text-nowrap text-milung">Method</th>
                                    <th class="text-nowrap"><span>Printing</span> <br>
                                        <span class="text-milung">Pantone</span>
                                    </th>

                                    <th class="text-nowrap text-milung">Label</th>
                                    <th class="text-nowrap"><span>Packaging</span> <br>
                                        <span class="text-milung">Type</span>
                                    </th>
                                    <th class="text-nowrap text-milung">Label</th>
                                    <th class="text-nowrap ">Shipment Date</th>
                                    <th class="text-nowrap ">Supplier ID</th>

                                    <th class="text-nowrap text-milung">Purchase Price</th>
                                    <th class="text-nowrap"><span>Final Quote</span> <br>
                                        <span class="text-milung">Profit</span>
                                    </th>
                                    <th class="text-nowrap text-milung">Selling Price</th>
                                    <th class="text-nowrap text-milung">Remarks</th>
                                </tr>
                            </thead>
                            <tbody v-for="order in dataToDisplay" :key="order.id">
                                <tr class="text-center" style="border-bottom-color: snow !important;">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" :value="order.id"
                                                id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ order.id }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        {{ order.id }}
                                    </td>
                                    <td>{{ order.product_group?.group_name }}</td>
                                    <td><span class="my-2">{{ order.article }}</span> <br>
                                        <img class="w-milung" :src="order.thumbnail_url" alt="Thumbnail">
                                        <br>
                                        <span class="my-2">{{ order.quantity_unit }}</span>
                                    </td>
                                    <td>{{ order.capacity.join(', ') }}</td>
                                    <td>{{ order.accessories }}</td>
                                    <td>{{ order.printingmethod }}</td>
                                    <td>{{ order.logocolor }}</td>
                                    <td>{{ order.packagingprinting.join(', ') }}</td>
                                    <td>{{ order.packaging }}</td>
                                    <td>{{ order.packaging }}</td>
                                    <td>{{ order.sendoutdate }}</td>
                                    <td>{{ order.supplier }}</td>
                                    <td>2.30</td>
                                    <td>+0.25</td>
                                    <td>2.55</td>


                                    <td>

                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                        <nav class="mt-3">
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
            orders: [],
            currentPage: 1,
            searchQuery: ''
        }
    },
    computed: {

        filteredorders() {
            return this.orders.filter(order => {
                return order.buyer.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    (order.supplier.toLowerCase().includes(this.searchQuery));

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
                return this.filteredorders;
            } else {
                return this.paginatedData;
            }
        }
    },
    created() {
        this.fetchorders().then(() => {
            setTimeout(() => {
                this.isLoading = false;
            }, 1000); // Delay of 1 second
        });
    },
    methods: {
        getThumbnailUrl(imagePath) {
            // Modify this method according to your application's logic
            // For example, you might need to append a parameter to the image path to request a thumbnail version
            return `${imagePath}?thumbnail=true`; // Modify this line as per your requirement
        },
        changePage(page) {
            this.currentPage = page
        },
        async fetchorders() {
            NProgress.start();
            try {
                const response = await axios.get('/api/orderAll');
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
}
</script>

<style scoped>
@import url('./../style.css');

/* Set the width of the scrollbar */
::-webkit-scrollbar {
    height: 6px !important;
    /* Adjust as needed */
}

/* Track color */
.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    /* Light grey */
}

/* Handle color */
.table-responsive::-webkit-scrollbar-thumb {
    background: #009de1;
    /* Blue */
    border-radius: 10px;
}

/* Handle on hover */
.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #04a8fa;
    /* Dark grey */
}

.w-milung {
    width: 100px !important;
    border-radius: 6px;
}
</style>
