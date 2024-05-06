<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <div class="d-flex col-11 my-2">
                                    <div class="col-3 my-auto">
                                        <p class="fw-bold text-milung text-uppercase my-auto">
                                            Supplier ID:
                                        </p>
                                    </div>
                                    <div class="col-7">
                                        <!-- <input type="text" v-model="so.buyerid" class="form-control"> -->
                                        <multiselect v-model="selectedsupplierId" :options="suppliers" field="id"
                                            label="userid" track-by="id">
                                        </multiselect>
                                    </div>
                                </div>
                                <div class="d-flex col-11 my-2">
                                    <div class="col-3 my-auto">
                                        <p class="fw-bold text-milung text-uppercase my-auto">
                                            so#:
                                        </p>
                                    </div>
                                    <div class="col-7">
                                        <!-- <input type="text" v-model="so.buyerid" class="form-control"> -->
                                        <multiselect v-model="selectedsoId" :options="so">
                                        </multiselect>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex col-11 my-2 justify-content-end">
                                    <div class="col-4 my-auto">
                                        <p class="text-milung my-auto">
                                            Reciept/Delivery Note:
                                        </p>
                                    </div>
                                    <div class="col-5">
                                        <input type="text" v-model="so.buyerid" class="form-control" />
                                    </div>
                                </div>
                                <div class="d-flex col-11 my-2 justify-content-end">
                                    <div class="col-4 my-auto">
                                        <p class="fw-bold my-auto">
                                            ML User Only:
                                        </p>
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
                                    <th class="text-nowrap">Reciept Note</th>
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
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
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
                                                        <input type="number" placeholder="Amount"
                                                            class="form-control" />
                                                        <select class="form-select mx-2" id="inputGroupSelect02">
                                                            <option selected hidden>
                                                                Choose...
                                                            </option>
                                                            <option value="Partial Payment">
                                                                Partial Payment
                                                            </option>
                                                            <option value="Fill Payment">
                                                                Fill Payment
                                                            </option>
                                                        </select>
                                                        <button class="btn btn-warning" type="button"
                                                            id="button-addon1">
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
                                    <th class="text-nowrap">ML Invoice#</th>
                                    <th class="text-nowrap">Account Payable</th>
                                    <th class="text-nowrap">Settle Amount</th>
                                    <th class="text-nowrap">Settle Date</th>
                                    <th class="text-nowrap">
                                        Outstanding Amount
                                    </th>
                                    <th class="text-nowrap">Remarks</th>
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
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body w-35" v-show="!isLoading">
                        <span class="fw-bold fs-6 text-uppercase" style="color: #14245c">General Outstanding account
                            Payable:</span>

                        <!-- Table with stripped rows -->
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import NProgress from "nprogress";
import "nprogress/nprogress.css";

export default {

    data() {
        return {
            isLoading: true,
            suppliers: [],
            selectedsupplierId: "",
            so: [],
            orders: [],
            invoice: [],
            selectedsoId: "",
            selectedOrderIds: [],
        };
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
        async fetchSOs(supplierId) {
            NProgress.start();

            try {
                const response = await axios.get(`/api/so/${supplierId}`);
                this.orders = response.data;

                this.so = response.data.map(
                    (order) => order.shipment_orders.so_number
                );

                this.so = this.so.flat();
                console.log(this.orders, this.so);

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
                const response = await axios.get("/api/supplier/supplierOrder");
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
</style>
