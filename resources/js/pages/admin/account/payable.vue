<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <div class="d-flex col-11 ">
                                    <div class="col-3 my-auto">
                                        <p class="fw-bold text-milung text-uppercase my-auto">
                                            Supplier ID:
                                        </p>
                                    </div>
                                    <div class="col-7">
                                        <!-- <input type="text" v-model="so.buyerid" class="form-control"> -->
                                        <multiselect v-model="selectedsupplierId" :options="suppliers" field="id"
                                            label="supplier_id" track-by="id">
                                        </multiselect>
                                    </div>
                                </div>
                                <div class="d-flex col-11 ">
                                    <div class="col-3 my-auto">
                                        <p class="fw-bold text-milung text-uppercase my-auto">
                                            so#:
                                        </p>
                                    </div>
                                    <div class="col-7">
                                        <!-- <input type="text" v-model="so.buyerid" class="form-control"> -->
                                        <multiselect label="so_number" track-by="id" v-model="selectedsoId"
                                            :options="so">
                                        </multiselect>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex col-11  justify-content-end">
                                    <div class="col-4 my-auto">
                                        <p class="text-milung my-auto">
                                            Receipt/Delivery Note:
                                        </p>
                                    </div>
                                    <div class="col-5">
                                        <a v-if="note != null && note.receipt_note != null" :href="'/storage/' +
                                            note.receipt_note" download class="btn px-4 mx-2 btn-outline-primary  ">
                                            <i class="bi bi-file-earmark-text fw-bold"></i>
                                        </a>
                                        <p v-else class="fst-italic text-muted my-auto">
                                            Not provided
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex col-11 justify-content-end">
                                    <div class="col-4 my-auto">
                                        <!-- <p class="fw-bold my-auto">
                                            ML User Only:
                                        </p> -->
                                    </div>
                                    <div class="col-5">
                                        <button class="btn btn-warning px-5 fw-bold">
                                            Approved
                                        </button>
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
                    <div class="card-body  rounded-top table-responsive" v-else>
                        <!-- Table with stripped rows -->
                        <DataTable v-model:filters="filters" :value="orders" paginator showGridlines :rows="10"
                            dataKey="id" filterDisplay="menu" :loading="isLoading"
                            :globalFilterFields="['id', 'status', 'sendoutdate', 'shipment_orders.so_number', 'invoice_number[0].invoice_number', 'totalvalue']">
                            <template #header>
                                <div class="flex justify-content-between">
                                    <Button type="button" icon="pi pi-filter-slash" label="Clear" outlined
                                        @click="clearFilter()" />
                                    <IconField iconPosition="left">
                                        <InputIcon>
                                            <i class="pi pi-search" />
                                        </InputIcon>
                                        <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                                    </IconField>
                                </div>
                            </template>
                            <template #empty class="text-center"> <span class="text-center">No orders found.</span>
                            </template>
                            <template #loading> Loading orders data. Please wait. </template>
                            <Column field="id" header="Order Number" style="min-width: 10rem">
                                <template #body="{ data }">
                                    <div class="form-check">
                                        <!-- <input class="form-check-input" type="checkbox" :value="data.id"
                                            id="flexCheckDefault" v-model="selectedOrderIds" />
                                        <label class="form-check-label" for="flexCheckDefault"></label> -->
                                        {{ data.id }}
                                    </div>
                                </template>
                            </Column>
                            <Column field="status" header="Status" style="min-width: 10rem">
                                <template #body="{ data }">
                                    {{ data.status }}
                                </template>
                                <template #filter="{ filterModel }">
                                    <InputText v-model="filterModel.value" type="text" class="p-column-filter"
                                        placeholder="Search by status" />
                                </template>
                            </Column>
                            <Column field="sendoutdate" header="Supplier SendOut Date" style="min-width: 12rem">
                                <template #body="{ data }">
                                    {{ data.sendoutdate }}
                                </template>
                            </Column>
                            <Column field="shipment_orders.so_number" header="SO#" style="min-width: 10rem">
                                <template #body="{ data }">
                                    {{ data.shipment_orders?.so_number }}
                                </template>
                            </Column>
                            <Column field="invoice_number[0].invoice_number" header="Shipping Invoice#"
                                style="min-width: 12rem">
                                <template #body="{ data }">

                                    <span v-if="data.invoice_number[0]?.invoice_number != null">
                                        {{ data.invoice_number[0]?.invoice_number }}
                                    </span>
                                    <span v-else class="fst-italic text-muted">
                                        Not created
                                    </span>
                                </template>
                            </Column>
                            <Column field="totalvalue" header="Order Value" style="min-width: 10rem">
                                <template #body="{ data }">
                                    <span :class="{ 'text-danger': calculatedValue(data) > 0 }">
                                        {{ calculatedValue(data) }}
                                    </span>
                                </template>
                            </Column>
                            <Column field="note.receipt_note" header="Receipt Note" style="min-width: 10rem">
                                <template #body="{ data }">
                                    <!-- {{note.receipt_note}} -->
                                    <a v-if="note != null && note.receipt_note != null" :href="'/storage/' + note?.receipt_note" download
                                        class="btn px-4 mx-2 btn-outline-primary">
                                        <i class="bi bi-file-earmark-text fw-bold"></i>
                                    </a>
                                    <p v-else class="fst-italic text-muted">Not provided</p>
                                </template>
                            </Column>
                        </DataTable>
                        <!-- <table class="table table-striped table-hover">
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
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" :value="item.id"
                                                id="flexCheckDefault" v-model="selectedOrderIds" />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{ item.id }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{ item.status }}</td>
                                    <td>{{ item.sendoutdate }}</td>
                                    <td>
                                        {{ item.shipment_orders?.so_number }}
                                    </td>
                                    <td>{{ item.information?.invoice }}</td>
                                    <td>{{ item.totalvalue }}</td>
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
                                        <p class="text-center">
                                            No orders to display.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table> -->
                    </div>
                    <div class="card-body">
                        <div class="row my-3">
                            <div class="col-6 border-end">
                                <p class="text-milung text-center my-auto">
                                    Filter Range Total Value:
                                    <span class="fw-bold">US$ {{ totalOrderValue }}</span>
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
                                                v-model="selectedInvoiceIds" :disabled="item.outstanding_amount == 0">
                                            <label class="form-check-label">

                                                <router-link class=""
                                                    :to="{ name: 'invoice_admin', params: { id: item.id } }"> {{
                                            item.invoice_number }}</router-link>
                                            </label>
                                        </div>
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
                                        <textarea class="form-control" v-model="remarks[item.id]" cols="9"
                                            rows="2"></textarea>
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
                                                        <div class="col-3 my-auto">
                                                            {{ order.id }}
                                                        </div>
                                                    </div>
                                                    <div class="d-flex col-3 my-4">
                                                        <div class="col-6 my-auto">
                                                            <p class="my-auto fs-7 fw-bold">
                                                                Order Quantity:
                                                            </p>
                                                        </div>
                                                        <div class="col-3 my-auto">
                                                            {{ order.quantity_unit }}
                                                        </div>
                                                    </div>
                                                    <div class="d-flex col-3 my-4">
                                                        <div class="col-6 my-auto">
                                                            <p class="my-auto fs-7 fw-bold">
                                                                Order Unit Price:
                                                            </p>
                                                        </div>
                                                        <div class="col-3 my-auto">
                                                            {{ order.buyingprice }}
                                                        </div>
                                                    </div>
                                                    <div class="d-flex col-3 my-4">
                                                        <div class="col-6 my-auto">
                                                            <p class="my-auto fs-7 fw-bold">
                                                                Order Total Value:
                                                            </p>
                                                        </div>
                                                        <div class="col-3 my-auto">
                                                            {{ order.quantity_unit * order.buyingprice }}
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
                    <div class="row" v-if="invoice.length > 0">
                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-danger px-5 me-2 fw-bold">
                                Reject
                            </button>
                            <button class="btn btn-warning px-5 me-2 fw-bold" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                Payment
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
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
                                                        <input type="file" class="form-control  " id="inputGroupFile02"
                                                            accept="image/*,.pdf" />
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
                                                        <select class="form-select mx-2" v-model="paymentType">
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
                                                        <button class="btn btn-warning" @click="sendPaymentData"
                                                            data-bs-dismiss="modal" type="button" id="button-addon1">
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
                    <!-- <div class="card-body w-35" v-show="!isLoading">
                        <span class="fw-bold fs-6 text-uppercase" style="color: #14245c">General Outstanding account
                            Payable:</span>

                        <table class="table table-striped table-hover">
                            <thead style="color: #009de1" class="text-center">
                                <tr style="">
                                    <th class="text-nowrap">Supplier ID</th>
                                    <th class="text-nowrap">
                                        Outstanding Amount
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="(item, index) in invoice" :key="index" v-if="invoice.length > 0"></tr>
                                <tr v-else>
                                    <td colspan="17">
                                        <p class="text-center">
                                            No data to display.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #009de1" class="text-start fw-bold">
                                        Total:
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import { format } from 'date-fns';
import { parseISO } from 'date-fns';
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';
import { FilterMatchMode, FilterOperator } from 'primevue/api';

export default {

    data() {
        return {
            remarks: {},
            paymentType: "",
            amount: "",
            selectedInvoiceIds: [],
            isLoading: true,
            suppliers: [],
            selectedsupplierId: "",
            so: [],
            orders: [],
            note: {
                receipt_note: null,
            },
            invoice: [],
            selectedsoId: "",
            selectedOrderIds: [],
            filters: {},
            accordionIndex: null,
        };
    },

    mounted() {
        this.initFilters();
    },
    created() {
        this.fetchSupplier().then(() => {
            setTimeout(() => {
                this.isLoading = false;
            }, 1000); // Delay of 1 second
        });
    },
    watch: {
        selectedsupplierId(newVal) {
            if (newVal) {
                this.fetchSOs(newVal.id);
            } else {
                this.so = [];
            }
        },
        selectedsoId(newVal) {
            if (newVal) {
                this.fetchOrders(this.selectedsupplierId, newVal);
            }
        }
        ,
    },
    computed: {
        totalOrderValue() {
            return this.filteredOrders.reduce((sum, item) =>
                parseInt(sum) + (parseFloat(item.invoice_number[0]?.outstanding_amount) || 0),
                0
            );
        },
        filteredOrders() {
            return this.orders.filter(order => {
                // Add your filtering logic here based on the filters
                // For example:
                if (this.filters.global && this.filters.global.value) {
                    return order.id.toString().includes(this.filters.global.value) ||
                        order.status.toString().includes(this.filters.global.value) ||
                        order.sendoutdate.toString().includes(this.filters.global.value) ||
                        (order.shipment_orders?.so_number || '').toString().includes(this.filters.global.value) ||
                        (order.invoice_number[0]?.invoice_number || '').toString().includes(this.filters.global.value) ||
                        (order.invoice_number[0]?.outstanding_amount || '').toString().includes(this.filters.global.value);
                }
                return true;
            });
        },
        totalvalue() {
            return this.orders.reduce(
                (sum, item) =>
                    parseInt(sum) + (parseFloat(item.invoice_number[0]?.outstanding_amount) || 0),
                0
            );
        },
    },
    methods: {
        calculatedValue(recieve) {
            return recieve.invoice_number[0]?.outstanding_amount ?? (recieve.quantity_unit * recieve.buyingprice);
        },
        async sendPaymentData() {
            try {
                console.log(this.selectedInvoiceIds);
                const formData = new FormData();
                const file = document.querySelector('#inputGroupFile02').files[0];
                formData.append('file', file);
                formData.append('invIds', this.selectedInvoiceIds.join(','));
                formData.append('amount', this.amount);
                formData.append('paymentType', this.paymentType);
                formData.append('remarks', JSON.stringify(this.remarks));

                const response = await axios.post('/api/payment', formData);

                if (response.data) {
                    this.paymentType = "";
                    this.amount = "";
                    document.querySelector("#inputGroupFile02").value = "";
                    this.selectedInvoiceIds = [];
                    // handle success
                    this.fetchOrders(this.selectedsupplierId, this.selectedsoId);
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
        toggleAccordion(index) {
            this.accordionIndex = this.accordionIndex === index ? null : index;
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
        onFilter(event) {
            // this.filteredOrders = event.filteredValue;
            console.log(event);
        },
        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                id: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                status: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                sendoutdate: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                'shipment_orders.so_number': { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                'invoice_number[0].invoice_number': { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                totalvalue: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
                'note.receipt_note': { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
            };
        },
        clearFilter() {
            this.initFilters();
        },
        async fetchOrders(supplierId, soId) {
            NProgress.start();
            try {
                console.log(supplierId.id, soId.id);
                const response = await axios.get(`/api/orders/${supplierId.id}/${soId.id}`);
                console.log(response.data);
                this.orders = response.data.orders;
                this.note = response.data.note;
                this.invoice = response.data.invoice;

                this.invoice.forEach((item) => {
                    if (item.remarks) {
                        this.remarks[item.id] = item.remarks;
                    }
                });

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error("Error fetching orders:", error);
                toastr.error("Error fetching data");
            }
        },
        async fetchSOs(supplierId) {
            NProgress.start();

            try {
                const response = await axios.get(`/api/so/${supplierId}`);
                this.orders = response.data.order;
                this.so = [];
                this.so = response.data.so;

                // this.so = this.so.flat();
                console.log(this.orders, this.so, response.data);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error("Error fetching SOs:", error);
                toastr.error("Error fetching data");
            }
        },

        async fetchSupplier() {
            NProgress.start();
            try {
                const response = await axios.get("/api/supplierOrder");
                this.suppliers = response.data;
                // this.pagination.totalItems = response.data.total;
                console.log(this.suppliers);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error("Error fetching shipment:", error);
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

.p-datatable .p-datatable-tbody>tr {
    text-align: center !important;

}
</style>
