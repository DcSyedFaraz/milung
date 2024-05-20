<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">

                <div class="card  ">
                    <div class="card-header  ">
                        <div class="">

                            <span>
                                <span class=" fw-bold fs-4 text-uppercase" style="color: #14245c;">Supplier Account
                                    Recievable:</span>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mx-3">
                            <div class="d-flex col-5">
                                <div class="col-2 my-auto">
                                    <p for="v-model" class="my-auto fs-7 fw-bold">
                                        SO#:</p>
                                </div>
                                <div class="col-8">
                                    <!-- <input type="text" v-model="info.so_no" class="form-control "> -->
                                    <multiselect v-model="info.so_no" :options="so" field="id" label="so_number"
                                        track-by="id">
                                    </multiselect>
                                </div>
                            </div>

                            <div class="col-4 d-flex">
                                <div class="col-4 my-auto">
                                    <p for="v-model" class="my-auto fs-7 fw-bold">
                                        Reciept Note:</p>
                                </div>
                                <div class="col-8">
                                    <input type="file" ref="note" style="display: none" @change="handleFileUpload" />
                                    <button class="btn btn-primary btn-sm mb-2" @click="triggerUpload('note')">
                                        Upload
                                    </button>
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
                            <thead style="color: #009de1; " class="text-center">
                                <tr style="">
                                    <th>Order#</th>
                                    <th> Status</th>
                                    <th>Supplier SendOut Date</th>
                                    <th>SO #</th>
                                    <th>Invoice #</th>
                                    <th>Order Payable Amount</th>
                                    <th>Reciept Note</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="recieve in orders" :key="recieve.id" v-if="orders.length > 0"
                                    style="border-bottom-color: snow !important;">
                                    <td>{{ recieve.id }}</td>
                                    <td>
                                        <span>{{ recieve.status }}</span>
                                    </td>
                                    <td>{{ recieve.shipment_supplier?.ship_date }}</td>
                                    <td>{{ recieve.shipment_orders?.so_number }}</td>
                                    <td>#***</td>
                                    <td>{{ recieve.buyingprice * recieve.quantity_unit }}</td>
                                    <td><i class="bi bi-file-earmark-text fw-bold"></i></td>

                                </tr>



                                <tr v-else>
                                    <td colspan="17">
                                        <p class="text-center">No recievables to display.</p>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <div class="col-12 row  " v-if="orders.length > 0">
                            <div class="col-6 d-flex">
                                <div class="col-2 my-auto">
                                    <p for="v-model" class="my-auto fs-7 fw-bold">
                                        Incoterm:</p>
                                </div>
                                <div class="col-4">
                                    <input type="text" v-model="Incoterm" class="form-control ">

                                </div>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <div class="col-4 ">

                                    <button class="btn btn-warning me-2 fw-bold ">
                                        Generate Invoice
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive" v-show="!isLoading">
                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-hover">
                            <thead style="color: #009de1" class="text-center">
                                <tr style="">
                                    <th class="text-nowrap">
                                        POS
                                    </th>
                                    <th class="text-nowrap">
                                        Invoice#
                                    </th>
                                    <th class="text-nowrap">
                                        Invoice Date
                                    </th>
                                    <th class="text-nowrap">Invoice Value</th>
                                    <th class="text-nowrap">Settle Amount</th>
                                    <th class="text-nowrap">Settle Date</th>
                                    <th class="text-nowrap">
                                        Outstanding Amount
                                    </th>
                                    <th class="text-nowrap">Remarks</th>
                                    <th class="text-nowrap">MiLung Remittance Slip</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" v-for="(item, index) in orders" :key="index" v-if="orders">
                                <tr>
                                    <td>
                                        {{ index }}
                                    </td>
                                    <td>
                                        {{ item.id }}
                                    </td>
                                    <td @click="toggleAccordion(index)"></td>

                                    <td @click="toggleAccordion(index)">USD {{ item.totalpayable }}</td>

                                    <td @click="toggleAccordion(index)"
                                        :class="{ 'text-muted': item.settleamount?.settle_amount == null, 'fst-italic': item.settleamount?.settle_amount == null }">
                                        {{ item.settleamount?.settle_amount ?? 'null' }}</td>

                                    <td @click="toggleAccordion(index)"
                                        :class="{ 'text-muted': item.settleamount?.settle_date == null, 'fst-italic': item.settleamount?.settle_date == null }">
                                        {{ item.settleamount?.settle_date ?? 'null' }}</td>

                                    <td @click="toggleAccordion(index)"
                                        :class="{ 'text-muted': item.settleamount?.outstanding_amount == null, 'fst-italic': item.settleamount?.outstanding_amount == null, 'text-danger': item.settleamount?.outstanding_amount > 0 }">
                                        {{ item.settleamount?.outstanding_amount ?? item.totalvalue }}</td>

                                    <td>
                                        <input type="text" class="form-control">
                                    </td>
                                    <td>
                                        <a v-if="item.settleamount?.slip" :href="'/storage/' +
                                        item.settleamount?.slip" download class="btn px-4 mx-2 btn-outline-primary  ">
                                            <i class="bi bi-file-earmark-text fw-bold"></i>
                                        </a>
                                        <p v-else class="fst-italic text-muted">
                                            Not provided
                                        </p>
                                    </td>

                                </tr>
                                <tr v-if="accordionIndex === index">
                                    <td colspan="8">
                                        <div class="">

                                            <div class="" v-for="(order, index) in item.orders" :key="index">

                                                <div class="row border">
                                                    <div class="d-flex col-3 my-4">
                                                        <div class="col-6 my-auto">
                                                            <p class="my-auto fs-7 fw-bold">
                                                                Order Number:
                                                            </p>
                                                        </div>
                                                        <div class="col-3">
                                                            {{ order.id }}
                                                        </div>
                                                    </div>
                                                    <div class="d-flex col-3 my-4">
                                                        <div class="col-6 my-auto">
                                                            <p class="my-auto fs-7 fw-bold">
                                                                Order Quantity:
                                                            </p>
                                                        </div>
                                                        <div class="col-3">
                                                            {{ order.quantity_unit }}
                                                        </div>
                                                    </div>
                                                    <div class="d-flex col-3 my-4">
                                                        <div class="col-6 my-auto">
                                                            <p class="my-auto fs-7 fw-bold">
                                                                Order Unit Price:
                                                            </p>
                                                        </div>
                                                        <div class="col-3">
                                                            {{ order.sellingprice }}
                                                        </div>
                                                    </div>
                                                    <div class="d-flex col-3 my-4">
                                                        <div class="col-6 my-auto">
                                                            <p class="my-auto fs-7 fw-bold">
                                                                Order Total Value:
                                                            </p>
                                                        </div>
                                                        <div class="col-3">
                                                            {{ order.totalvalue }}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <td colspan="17">
                                    <p class="text-center">
                                        No data to display.
                                    </p>
                                </td>
                            </tbody>

                        </table>

                    </div>
                    <!-- <div class="row justify-content-around">
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
                    </div> -->
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
            info: {},
            invoice: {},
            orders: {},
            so: [],
            isLoading: true,
            Incoterm: '',
            accordionIndex: null,
        }
    },
    watch: {
        data(newVal) {
            this.inquiry = newVal;
        }
    },
    mounted() {
        this.fetchSO();
    },
    watch: {
        'info.so_no': function (newVal, oldVal) {
            if (newVal !== null) {
                this.fetchrecievables(newVal);
            }
        }
    },
    methods: {
        toggleAccordion(index) {
            this.accordionIndex = this.accordionIndex === index ? null : index;
        },
        async handleFileUpload() {
            // Confirm the upload
            const { isConfirmed } = await Swal.fire({
                title: 'Are you sure you want to upload this file?',
                showCancelButton: true,
                confirmButtonText: 'Yes, upload it!',
            });

            if (!isConfirmed) {
                return;
            }

            // Get the selected file and the SO number
            const file = this.$refs.note.files[0];
            const soNumber = this.info.so_no.id;

            // Send the file and the SO number to the API
            const formData = new FormData();
            formData.append('file', file);
            formData.append('so_number', soNumber);

            try {
                const response = await axios.post('/api/supplier/upload_reciept_note', formData);

                // Fetch the updated recievables
                this.fetchrecievables(this.info.so_no);

                // Show a success message
                Swal.fire({
                    title: 'Success!',
                    text: 'The file has been uploaded successfully.',
                    icon: 'success',
                });
            } catch (error) {
                // Show an error message
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while uploading the file.',
                    icon: 'error',
                });
            }
        },
        triggerUpload(refName) {
            this.$refs[refName].click();
        },
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

        fetchSO() {
            axios.get('/api/supplier/suppliershipments')
                .then(response => {
                    this.so = response.data;
                    console.log(this.so);

                    this.isLoading = false;
                })
                .catch(error => {
                    this.isLoading = false;
                    console.error(error);
                });
        },
        async fetchrecievables(newVal) {
            NProgress.start();
            try {
                const response = await axios.get('/api/supplier/shipment_details/' + newVal.id);
                this.orders = response.data;
                // this.pagination.totalItems = response.data.total;
                console.log('orders ', this.orders);

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
