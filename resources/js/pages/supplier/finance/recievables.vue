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
                                        POS
                                    </th>
                                    <th>Order/Inv #</th>
                                    <th>Payment Recievables</th>
                                    <th>Shipping Date</th>
                                    <th>Shipping Method</th>
                                    <th>ETA Date</th>
                                    <th>Payment Settled</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody v-for="recieve in dataToDisplay" :key="recieve.id" v-if="dataToDisplay.length > 0">
                                <tr style="border-bottom-color: snow !important;">
                                    <td>{{ recieve.inquiry_number }}</td>
                                    <td>
                                        <span>{{ recieve.status }}</span>
                                    </td>
                                    <td>{{ eta(recieve) }}</td>
                                    <td>{{ recieve.requirements }}</td>


                                    <td>
                                        <!-- <button @click="toggleAccordion(recieve)" class="btn btn-light"
                                            :class="{ 'rotate-icon': accordionOpen[recieve.id] }">
                                            <i class="bi bi-pencil"></i>
                                        </button> -->
                                        <router-link
                                            :to="{ name: 'supplier_price_inquiry_entry', params: { id: recieve.id } }"
                                            class="text-dark btn btn-light">
                                            <i class="bi bi-pencil"></i>
                                        </router-link>

                                    </td>
                                </tr>



                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="17">
                                        <p class="text-center">No recievables to display.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-warning me-2 fw-bold" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                Payment Reminder
                            </button>
                        </div>
                    </div>
                    <div class="row justify-content-around">
                        <div class="col-6 border">
                            <h5 class="text-uppercase text-milung fw-bold">
                                General Outstanding Account Recievable:
                            </h5>
                            <table class="table table-striped table-hover  ">
                                <thead class="text-blue">
                                    <th>BuyerID</th>
                                    <th>Outstanding Amount</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="17">
                                            <p class="text-center">No data to display.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-blue fw-bold">TOTAL:
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-5 border">
                            <h5 class="text-uppercase text-milung fw-bold">
                                Annual Sales Ravenue:
                            </h5>
                            <table class="table table-striped table-hover  ">
                                <thead class="text-blue">
                                    <th>BuyerID</th>
                                    <th>Total Sales</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="17">
                                            <p class="text-center">No data to display.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-blue fw-bold">TOTAL:
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
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
    data() {


        return {
            isLoading: true,
            searchQuery: '',
        }
    },
    watch: {
        data(newVal) {
            this.inquiry = newVal;
        }
    },
    computed: {

        filteredrecieve() {
            return this.inquiry.filter(recieve => {
                return recieve.inquiry_number.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    (recieve.requirements.toLowerCase().includes(this.searchQuery));

            });
        },
        dataToDisplay() {
            if (this.searchQuery) {
                return this.filteredrecieve;
            } else {
                return this.fetchrecievables;
            }
        }
    },
    created() {
        this.fetchrecievables().then(() => {
            setTimeout(() => {
                this.isLoading = false;
            }, 1000); // Delay of 1 second
        });
    },
    methods: {
        eta(recieve) {
            if (recieve.updated_at) {
                // Parse the datetime string using date-fns
                const parsedDateTime = parseISO(recieve.updated_at);
                // Format the parsed date using date-fns
                return format(parsedDateTime, 'dd-MM-yyyy HH:mm');
            } else {
                return '';
            }
        },
        async fetchrecievables() {
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
}
</script>

<style lang="scss" scoped></style>
