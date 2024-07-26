<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">

                                <div class="d-flex col-11 my-4">
                                    <div class="col-3 my-auto">
                                        <p class="fw-bold text-milung text-uppercase my-auto">
                                            so#:
                                        </p>
                                    </div>
                                    <div class="col-7">
                                        <!-- <input type="text" v-model="so.buyerid" class="form-control"> -->
                                        <multiselect v-model="selectedsoId" :options="so" label="so_number"
                                            track-by="id">
                                        </multiselect>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mx-3">
                            <span>
                                <span class="fw-bold fs-4 text-uppercase" style="color: #14245c">Outstanding payment
                                    order list:</span>
                            </span>
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
                    <div class="card-body border-bottom border-3 rounded-top table-responsive" v-else>
                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-hover">
                            <thead style="color: #009de1" class="text-center">
                                <tr style="">
                                    <th class="text-nowrap">Order Number</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">
                                        Supplier SendOut Date
                                    </th>
                                    <th class="text-nowrap">SO#</th>
                                    <th class="text-nowrap">
                                        Shipping Invoice#
                                    </th>
                                    <th class="text-nowrap">Order Value</th>
                                    <th class="text-nowrap">Receipt Note</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr v-for="(item, index) in orders" :key="index" v-if="orders.length > 0">
                                    <td>
                                        {{ item.id }}
                                    </td>
                                    <td>{{ item.status }}</td>
                                    <td>{{ item.sendoutdate }}</td>
                                    <td>
                                        {{ item.shipment_orders?.so_number }}
                                    </td>
                                    <td>{{ item.information?.invoice }}</td>
                                    <td>{{ item.totalvalue }}</td>
                                    <td>
                                        <router-link class="fw-bold" style="color: #009de1 !important" :to="{
                                            name: 'information',
                                            params: {
                                                id: item.so_number,
                                                so_number:
                                                    item.shipment_orders
                                                        ?.so_number,
                                            },
                                        }">
                                            <i class="bi bi-file-earmark-text fw-bold"></i>
                                        </router-link>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td colspan="17">
                                        <p class="text-center">
                                            No orders to display.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body">
                        <div class="row my-3">
                            <div class="col-6 border-end">
                                <p class="text-milung text-center my-auto">
                                    Filter Range Total Value:
                                    <span class="fw-bold">US$xxxx.xx</span>
                                </p>
                            </div>
                            <div class="col-6">
                                <p class="text-milung text-center my-auto">
                                    Total Order Value:
                                    <span class="fw-bold">US${{ totalvalue }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive" v-show="!isLoading">
                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-hover">
                            <thead style="color: #009de1" class="text-center">
                                <tr style="">
                                    <th class="text-nowrap">
                                        Supplier Invoice#
                                    </th>
                                    <th class="text-nowrap">
                                        Supplier Invoice Date
                                    </th>
                                    <th class="text-nowrap">Account Payable</th>
                                    <th class="text-nowrap">Settle Amount</th>
                                    <th class="text-nowrap">Settle Date</th>
                                    <th class="text-nowrap">
                                        Outstanding Amount
                                    </th>
                                    <th class="text-nowrap">Remarks</th>
                                    <th class="text-nowrap">Remittance Slip</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" v-for="(item, index) in invoice" :key="index"
                                v-if="invoice.length > 0">
                                <tr>
                                    <td>
                                        <div class="form-check">

                                            <input class="form-check-input" type="checkbox" :value="item.id"
                                                id="flexCheckDefault" v-model="selectedINFOIds" />

                                            <!-- <input type="hidden" :value="item.shipment_order_id" v-model="shipid"> -->
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ item.invoice }}
                                            </label>
                                        </div>
                                    </td>
                                    <td @click="toggleAccordion(index)">{{ created_at(item.created_at) }}</td>

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
                                        <input type="text" v-model="remarks[item.id]" class="form-control">
                                    </td>
                                    <td>
                                        <a v-if="item.settleamount?.slip" :href="'/storage/' +
                                            item.settleamount?.slip" download
                                            class="btn px-4 mx-2 btn-outline-primary  ">
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
                        <div class="row"  v-if="invoice.length > 0">
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-danger px-5 me-2 fw-bold" @click="reject">
                                    Reject
                                </button>
                                <button class="btn btn-warning px-5 me-2 fw-bold" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Payment
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" ref="myModal" id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="row my-3">
                                                    <div class="col-12">
                                                        <p class="m-0 text-milung text-uppercase fw-bold text-center">
                                                            Please Upload the
                                                            remittance slip here
                                                        </p>
                                                        <hr class="m-0" />
                                                    </div>

                                                    <div class="col-12 mt-5">
                                                        <div class="input-group mb-3">
                                                            <input type="file" class="form-control  "
                                                                id="inputGroupFile02" accept="image/*,.pdf" />
                                                            <label class="input-group-text border-start-0"
                                                                style="background-color: white;"
                                                                for="inputGroupFile02"><span
                                                                    class="badge rounded-pill bg-primary">Browse</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <input type="number" placeholder="Amount" v-model="amount"
                                                                class="form-control" />
                                                            <select class="form-select mx-2" id="inputGroupSelect02"
                                                                v-model="paymentType">
                                                                <option selected hidden>
                                                                    Choose...
                                                                </option>
                                                                <option value="Partial Payment">
                                                                    Partial Payment
                                                                </option>
                                                                <option value="Full Payment">
                                                                    Full Payment
                                                                </option>
                                                            </select>
                                                            <button class="btn btn-warning" type="button"
                                                                @click="sendPaymentData" id="button-addon1"
                                                                data-bs-dismiss="modal">
                                                                Send
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import NProgress from "nprogress";
import "nprogress/nprogress.css";
import { format } from "date-fns";
import { parseISO } from "date-fns";

export default {

    data() {
        return {
            isLoading: true,
            suppliers: [],
            selectedsupplierId: "",
            paymentType: "",
            amount: "",
            so: [],
            remarks: {},
            orders: [],
            invoice: [],
            selectedsoId: "",
            accordionIndex: null,
            selectedINFOIds: [],
        };
    },
    created() {
        this.fetchSOs().then(() => {
            setTimeout(() => {
                this.isLoading = false;
            }, 1000); // Delay of 1 second
        });
    },
    watch: {
        selectedsoId(newVal) {
            if (newVal) {
                console.log('new', newVal);
                this.fetchSO(newVal.id);
            }
        },
    },
    computed: {
        totalvalue() {
            return this.orders.reduce(
                (sum, item) =>
                    parseInt(sum) + (parseFloat(item.totalvalue) || 0),
                0
            );
        },
    },
    methods: {

        toggleAccordion(index) {
            this.accordionIndex = this.accordionIndex === index ? null : index;
        },
        async reject() {
            try {
                console.log(this.selectedINFOIds);
                const formData = new FormData();
                formData.append('infoIds', this.selectedINFOIds.join(','));

                const shipIds = [];
                this.invoice.forEach((item) => {
                    if (this.selectedINFOIds.includes(item.id)) {
                        shipIds.push(item.shipment_order_id);
                    }
                });
                formData.append('shipIds', shipIds);

                const response = await axios.post('/api/buyer/reject', formData);

                if (response.data) {
                    this.selectedINFOIds = [];
                    this.fetchSOs();
                    // handle success
                    toastr.success('Invoice/s rejected successfully');
                } else {
                    // handle error
                    console.log('Error sending payment data:', response);
                }
            } catch (error) {
                // handle error
                if (error.response && error.response.status === 422) {
                    const validationErrors = error.response.data.errors;
                    this.handleValidationErrors(validationErrors);
                } else {
                    console.error(error);
                    toastr.error('Error sending payment data');
                }
            }
        },
        async sendPaymentData() {
            try {
                console.log(this.selectedINFOIds);
                const formData = new FormData();
                const file = document.querySelector('#inputGroupFile02').files[0];
                formData.append('file', file);
                formData.append('infoIds', this.selectedINFOIds.join(','));
                formData.append('amount', this.amount);
                formData.append('paymentType', this.paymentType);

                const shipIds = [];
                this.invoice.forEach((item) => {
                    if (this.selectedINFOIds.includes(item.id)) {
                        shipIds.push(item.shipment_order_id);
                    }
                });
                formData.append('shipIds', shipIds);
                formData.append('remarks', JSON.stringify(this.remarks));




                const response = await axios.post('/api/buyer/payment', formData);

                if (response.data) {
                    this.paymentType = "";
                    this.amount = "";
                    document.querySelector("#inputGroupFile02").value = "";
                    this.selectedINFOIds = [];
                    this.fetchSOs();
                    // handle success
                    toastr.success('Payment data sent successfully');
                } else {
                    // handle error
                    console.log('Error sending payment data:', response);
                }
            } catch (error) {
                // handle error
                if (error.response && error.response.status === 422) {
                    const validationErrors = error.response.data.errors;
                    this.handleValidationErrors(validationErrors);
                } else {
                    console.error(error);
                    toastr.error('Error sending payment data');
                }
            }
        },
        handleValidationErrors(validationErrors) {
            // console.log(validationErrors);
            // Assuming you have a function to display toastr error messages
            for (const key in validationErrors) {
                if (validationErrors.hasOwnProperty(key)) {
                    const messages = validationErrors[key];
                    // Display each validation error message
                    messages.forEach(message => {
                        toastr.error(message);
                    });
                }
            }
        },
        created_at(order) {
            // console.log('hello',order);
            if (order) {

                // Parse the datetime string using date-fns
                const parsedDateTime = parseISO(order);
                // Format the parsed date using date-fns
                return format(parsedDateTime, "dd-MM-yyyy HH:mm");
            } else {
                return "";
            }
        },
        async fetchSOs() {
            NProgress.start();

            try {
                const response = await axios.get(`/api/buyer/so`);
                this.orders = response.data.order;
                // console.log(this.orders);
                this.so = response.data.so;
                this.invoice = response.data.invoice;
                console.log('sp', this.invoice);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error("Error fetching SOs:", error);
                toastr.error("Error fetching data");
            }
        },
        async fetchSO(SOId) {
            NProgress.start();

            try {
                console.log(SOId);
                const response = await axios.get(`/api/buyer/so/${SOId}`);
                this.orders = response.data;
                console.log(this.orders);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error("Error fetching SOs:", error);
                toastr.error("Error fetching data");
            }
        },

    },
};
</script>

<style scoped>
.w-35 {
    width: 35% !important;
}
</style>
