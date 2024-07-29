<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">

                <div class="card  ">
                    <div class="card-header  ">
                        <div class="">

                            <span>
                                <span class=" fw-bold fs-4 text-uppercase" style="color: #14245c;">Supplier Account
                                    Receivable:</span>
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
                                        Receipt Note:</p>
                                </div>
                                <div class="col-8" v-if="note == null">
                                    <input type="file" ref="note" style="display: none" @change="handleFileUpload" />
                                    <button class="btn btn-primary btn-sm mb-2" @click="triggerUpload('note')">
                                        Upload
                                    </button>
                                </div>
                                <div class="col-8" v-else>
                                    <a v-if="note.receipt_note" :href="'/storage/' +
                                        note.receipt_note" download class="btn px-4 mx-2 btn-outline-primary  ">
                                        <i class="bi bi-file-earmark-text fw-bold"></i>
                                    </a>
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
                                    <th>Receipt Note</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="recieve in orders" :key="recieve.id" v-if="orders.length > 0"
                                    style="border-bottom-color: snow !important;">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" :value="recieve.id"
                                                v-model="selectedOrderIds"
                                                :disabled="recieve.invoice_number.length > 0">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ recieve.id }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <span>{{ recieve.status }}</span>
                                    </td>
                                    <td>{{ recieve.shipment_supplier?.ship_date }}</td>
                                    <td>{{ recieve.shipment_orders?.so_number }}</td>
                                    <td>
                                        <span v-if="recieve.invoice_number.length > 0"
                                            v-for="(item, index) in recieve.invoice_number" :key="index">{{
                                        item.invoice_number }}</span>
                                        <span v-else class="text-muted fst-italic">
                                            No invoices found
                                        </span>
                                    </td>
                                    <td :class="{ 'text-danger': calculatedValue(recieve) > 0 }">
                                        {{ calculatedValue(recieve) }}
                                    </td>
                                    <td>
                                        <a v-if="note != null" :href="'/storage/' +
                                        note.receipt_note" download class="btn px-4 mx-2 btn-outline-primary  ">
                                            <i class="bi bi-file-earmark-text fw-bold"></i>
                                        </a>
                                        <p v-else class="fst-italic text-muted">
                                            Not provided
                                        </p>
                                    </td>

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
                                    <input type="text" v-model="incoterm" class="form-control ">
                                </div>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <div class="col-4 ">

                                    <button class="btn btn-warning me-2 fw-bold " @click="generate_invoice">
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
                            <tbody class="text-center" v-for="(item, index) in invoice" :key="index"
                                v-if="invoice.length > 0">
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" :value="item.id"
                                                v-model="selectedInvoiceIds">
                                            <label class="form-check-label">

                                                {{ index + 1 }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <router-link :to="{ name: 'supplier_invoice', params: { id: item.id } }"> {{
                                        item.invoice_number }}</router-link>

                                    </td>
                                    <td @click="toggleAccordion(index)" class="text-nowrap">{{ date(item) }}</td>

                                    <td @click="toggleAccordion(index)" class="text-nowrap">USD {{ item.total_value }}
                                    </td>

                                    <td @click="toggleAccordion(index)"
                                        :class="{ 'text-muted': item.settle_amount == null, 'fst-italic': item.settle_amount == null }">
                                        {{ item.settle_amount ?? 'null' }}</td>

                                    <td @click="toggleAccordion(index)"
                                        :class="{ 'text-muted': item.settle_date == null, 'fst-italic': item.settle_date == null }">
                                        {{ item.settle_date ?? 'null' }}</td>

                                    <td @click="toggleAccordion(index)"
                                        :class="{ 'text-muted': item.outstanding_amount == null, 'fst-italic': item.outstanding_amount == null, 'text-danger': item.outstanding_amount > 0 }">
                                        {{ item.outstanding_amount ?? item.totalvalue }}</td>

                                    <td>
                                        <p v-if="item.remarks">{{ item.remarks }}</p>
                                        <p v-else class="text-muted fst-italic"> No remarks</p>
                                    </td>
                                    <td>
                                        <a v-if="item.slip" :href="'/storage/' +
                                        item.slip" download class="btn px-4 mx-2 btn-outline-primary  ">
                                            <i class="bi bi-file-earmark-text fw-bold"></i>
                                        </a>
                                        <p v-else class="fst-italic text-muted">
                                            Not provided
                                        </p>
                                    </td>

                                </tr>
                                <tr v-if="accordionIndex === index">
                                    <td colspan="9">
                                        <div class="">

                                            <div class="" v-for="(order, index) in item.orders_invoice" :key="index">

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
                                                            {{ order.buyingprice }}
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
                                <tr>

                                    <td colspan="17">
                                        <p class="text-center">
                                            No invoice to display.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                    <div class="col-12 d-flex justify-content-end" v-if="invoice.length > 0">
                        <div class="col-2">

                            <button class="btn btn-warning mt-2 fw-bold " @click="payment">
                                Payment Reminder
                            </button>
                        </div>

                    </div>
                    <!-- <div class="row justify-content-around">
                        <div class="col-6 border">
                            <h5 class="text-uppercase text-milung fw-bold">
                                General Outstanding Account Receivable:
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
            selectedOrderIds: [],
            selectedInvoiceIds: [],
            info: {},
            invoice: {},
            orders: {},
            so: [],
            note: [],
            isLoading: true,
            incoterm: '',
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
        calculatedValue(recieve) {
            return recieve.invoice_number[0]?.outstanding_amount ?? (recieve.quantity_unit * recieve.buyingprice);
        },
        async payment() {

            if (this.selectedInvoiceIds.length === 0) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select at least one invoice to send reminder.',
                    icon: 'error',
                });
                return;
            }
            // Confirm the upload
            const { isConfirmed } = await Swal.fire({
                title: 'Are you sure you want to send payment reminder?',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
            });

            if (!isConfirmed) {
                return;
            }

            const formData = {
                invoice_ids: this.selectedInvoiceIds,

            };

            Swal.fire({
                title: 'Please wait...',
                allowOutsideClick: false,
                showConfirmButton: false,
            });
            Swal.showLoading();

            try {
                const response = await axios.post('/api/supplier/invoice/reminder', formData);

                Swal.hideLoading();
                // Show a success message
                Swal.fire({
                    title: 'Success!',
                    text: 'Reminder sent successfully.',
                    icon: 'success',
                });

                this.selectedInvoiceIds = [];

            } catch (error) {
                Swal.hideLoading();
                // Show an error message
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while sending reminder.',
                    icon: 'error',
                });
            }

        },
        async generate_invoice() {

            // Check if any selected order is already invoiced
            for (let orderId of this.selectedOrderIds) {
                const order = this.orders.find(order => order.id === orderId);
                if (order.invoice_number.length > 0) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'One or more selected orders are already invoiced.',
                        icon: 'error',
                    });
                    return;
                }
            }

            if (this.selectedOrderIds.length === 0 || this.incoterm == "") {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select at least one order and write incoterm to generate an invoice.',
                    icon: 'error',
                });
                return;
            }

            // Confirm the upload
            const { isConfirmed } = await Swal.fire({
                title: 'Are you sure you want to create invoice?',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
            });

            if (!isConfirmed) {
                return;
            }

            const formData = {
                order_ids: this.selectedOrderIds,
                incoterm: this.incoterm,

            };

            Swal.fire({
                title: 'Please wait...',
                allowOutsideClick: false,
                showConfirmButton: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const response = await axios.post('/api/supplier/invoice', formData);

                this.selectedOrderIds = [];
                this.intoterm = '';

                Swal.hideLoading();
                // Show a success message
                Swal.fire({
                    title: 'Success!',
                    text: 'Invoice created successfully.',
                    icon: 'success',
                });

                this.fetchSO();
            } catch (error) {
                Swal.hideLoading();
                // Show an error message
                if (error.response && error.response.status === 422) {

                    const validationErrors = error.response.data.errors;
                    console.log('error', error);
                    this.handleValidationErrors(validationErrors);

                } else if (error.response && error.response.status === 400) {

                    toastr.error(error.response.data.error);

                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while creating the invoice.',
                        icon: 'error',
                    });
                }
            }
        },
        toggleAccordion(index) {
            this.accordionIndex = this.accordionIndex === index ? null : index;
        },
        async handleFileUpload() {
            if (!this.info.so_no || this.info.so_no.id === undefined) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select shipment order number to upload receipt note.',
                    icon: 'error',
                });
                return;
            }

            console.log(this.info.so_no, ' hi');

            // Confirm the upload
            const { isConfirmed } = await Swal.fire({
                title: 'Are you sure you want to upload this file?',
                showCancelButton: true,
                confirmButtonText: 'Yes, upload it!',
            });

            if (!isConfirmed) {
                return;
            }

            // Ensure file input exists and file is selected
            if (!this.$refs.note || !this.$refs.note.files[0]) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select a file to upload.',
                    icon: 'error',
                });
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

                // Fetch the updated receivables
                this.fetchrecievables(this.info.so_no);

                // Show a success message
                Swal.fire({
                    title: 'Success!',
                    text: 'The file has been uploaded successfully.',
                    icon: 'success',
                });
            } catch (error) {
                // Show an error message
                console.log('error', error);
                if (error.response && error.response.status === 422) {
                    const validationErrors = error.response.data.errors;
                    this.handleValidationErrors(validationErrors);
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while uploading the file.',
                        icon: 'error',
                    });
                }
            }
        },
        triggerUpload(refName) {
            this.$refs[refName].click();
        },
        date(recieve) {
            if (recieve.created_at) {
                // Parse the datetime string using date-fns
                const parsedDateTime = parseISO(recieve.created_at);
                // Format the parsed date using date-fns
                return format(parsedDateTime, 'dd-MM-yyyy HH:mm');
            } else {
                return '';
            }
        },

        fetchSO() {
            axios.get('/api/supplier/suppliershipments')
                .then(response => {
                    this.so = response.data.ship;
                    this.invoice = response.data.invoice;
                    console.log(this.so, this.invoice);
                    this.isLoading = false;
                })
                .catch(error => {
                    this.isLoading = false;
                    console.error(error);
                });
        },
        handleValidationErrors(validationErrors) {
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    const messages = validationErrors[key];
                    messages.forEach(message => {
                        toastr.error(message);
                    });
                }
            }
        },
        async fetchrecievables(newVal) {
            NProgress.start();
            try {
                const response = await axios.get('/api/supplier/shipment_details/' + newVal.id);
                this.orders = response.data.orders;
                this.note = response.data.note;
                // this.pagination.totalItems = response.data.total;
                console.log('orders ', response.data);

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
