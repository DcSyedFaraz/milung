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
                                        <button class="btn btn-warning fw-bold text-dark" @click="placeAll">Place All
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
                        <table class="table">
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

                                    <th class="text-nowrap"><span>Final Quote</span> <br>
                                        <span class="text-milung">Selling Price</span>
                                    </th>
                                    <th class="text-nowrap text-milung">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="dataToDisplay.length > 0" class="text-center"
                                    style="border-bottom-color: snow !important;" v-for="order in dataToDisplay"
                                    :key="order.id">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" :value="order.id"
                                                v-model="order.checked"
                                                :disabled="order.order_suppliers_only?.purchase > 0">
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
                                        <img class="w-milung" :src="order.thumbnail_url" alt="Thumbnail"
                                            v-if="order.thumbnail_url">
                                        <br>
                                        <span class="my-2">{{ order.quantity_unit }}</span>
                                    </td>
                                    <td>{{ order.capacity?.join(', ') }}</td>
                                    <td>{{ order.accessories }}</td>
                                    <td>{{ order.printingmethod }}</td>
                                    <td>{{ order.logocolor }}</td>
                                    <td>{{ order.packagingprinting.join(', ') ?? 'N/A' }}</td>
                                    <td>{{ order.packaging }}</td>
                                    <td>{{ order.packaging }}</td>
                                    <td>{{ order.sendoutdate }}</td>
                                    <td> {{ order.userid }}</td>
                                    <td class="text-nowrap d-flex justify-content-around align-items-center"
                                        style="width: 155px;">
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">US $</span>
                                            <input type="number" class="form-control" v-model="order.selling_price"
                                                :disabled="order.order_suppliers_only?.purchase > 0">
                                        </div>
                                    </td>
                                    <td>
                                        <textarea name="remarks" cols="30" rows="4" class="form-control"
                                            style="width: 230px !important; " v-model="order.remarks"
                                            :disabled="order.order_suppliers_only?.purchase > 0"></textarea>
                                    </td>

                                </tr>
                                <tr v-else>
                                    <td colspan="17">
                                        <p class="text-center">No orders to display.</p>
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

export default {
    emits: ['profileUpdated'],
    props: {
        perPage: {
            type: Number,
            default: 10
        }
    },
    data() {

        return {
            loader: false,
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
                this.orders.forEach(order => {
                    order.selling_price = order.order_suppliers_only?.purchase || 0;
                    order.remarks = order.order_suppliers_only?.remarks || null;
                });
            }, 1000); // Delay of 1 second
        });
    },
    methods: {
        async placeAll() {
            this.loader = true;
            // Get the IDs of selected orders
            const data = [];

            this.dataToDisplay.forEach(order => {
                if (order.checked && order.selling_price) {
                    console.log('hi');
                    const orderData = {
                        orderId: order.id,
                        selling_price: order.selling_price, // USD value
                        remarks: order.remarks
                    };
                    data.push(orderData);
                }
            });

            console.log('Data:', data);
            // Send the data to the API
            try {
                if (Object.keys(data).length === 0) {
                    // The data object is empty
                    toastr.error('Data is empty. Please select orders before placing.');
                    this.loader = false;
                    return
                }

                const response = await axios.post('/api/supplier/placeAll', data);

                // Handle the API response as needed
                console.log(response.data);
                this.loader = false;
                // Show a success message
                if (response.data.success == true) {
                    Swal.fire({
                        icon: 'success',
                        title: response.data.message,
                    });
                    this.fetchorders().then(() => {
                        setTimeout(() => {
                            this.isLoading = false;
                        }, 1000); // Delay of 1 second
                    });
                } else {

                    Swal.fire({
                        icon: 'error',
                        title: response.data.message,
                    });
                }
            } catch (error) {
                this.loader = false;
                console.error('Error placing orders:', error);
                // Show an error message
                if (error.response && error.response.status === 422) {
                    const validationErrors = error.response.data.errors;
                    this.handleValidationErrors(validationErrors);
                } else {
                    console.error(error);
                    toastr.error('An error occurred while updating the order');
                }
            }
        },
        handleValidationErrors(validationErrors) {
            validationErrors.forEach(message => {
                toastr.error(message);
            });
        },
        changePage(page) {
            this.currentPage = page
        },
        async fetchorders() {
            NProgress.start();
            try {
                const response = await axios.get('/api/supplier/SupplierOrder');
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
