<template>
    <form>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-milung fw-bold text-center">
                        MiLung Trade Limited
                    </h1>
                    <p class="text-center text-milung fw-bold my-3">
                        Unit 1704-05, 17/F. Hang Seng North Point Building,<br />
                        341 North Point, Hong Kong. <br />
                        Tel: 852 2540 2488
                    </p>
                </div>
                <div class="col-12">
                    <div class="row mx-6 mt-4">
                        <div class="col mx-1 border rounded-3 rounded bg-milung">
                            <div class="text-center p-3">
                                <p class="fw-bold">
                                    Invoice No: <br />
                                    {{ info.invoice ?? "---" }}
                                </p>
                            </div>
                        </div>
                        <div class="col mx-1 border rounded-3 rounded bg-blue">
                            <div class="text-center p-3">
                                <p class="fw-bold">
                                    Cust Ref. (ATC): <br />
                                    {{ atc ?? "---" }}
                                </p>
                            </div>
                        </div>
                        <div class="col mx-1 border rounded-3 rounded bg-warning">
                            <div class="text-center p-3">
                                <p class="fw-bold">
                                    Date: <br />
                                    {{ created_at(info) ?? "---" }}
                                </p>
                            </div>
                        </div>
                        <div class="col mx-1 border rounded-3 rounded bg-orange">
                            <div class="text-center p-3">
                                <p class="fw-bold">
                                    Prepred By: <br />
                                    {{ info.user?.userid ?? "---" }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-5">
                    <div class="row">
                        <div class="col-6">
                            <div class="col-11 my-2">
                                <div class="">
                                    <label class="form-label text-milung fw-bold text-uppercase fs-5">invoice#:</label>
                                    {{ info.invoice }}
                                </div>
                            </div>
                            <div class="d-flex col-11 my-2">
                                <div class="">
                                    <label class="form-label text-milung fw-bold text-uppercase fs-5">Shipper:</label>
                                    <br> {{ info.shipper }}
                                </div>
                            </div>
                            <div class="d-flex col-11 my-2">
                                <div class="">
                                    <label class="form-label text-milung fw-bold text-uppercase fs-5">consignee:</label>
                                    <br> {{ info.consignee }}
                                </div>
                            </div>
                            <div class="col-11 my-2">
                                <div class="">
                                    <label class="form-label text-milung fw-bold text-uppercase fs-5">notify
                                        party:</label>
                                    {{ info.party }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex col-11 my-2">
                                <div class="">
                                    <label class="form-label text-milung fw-bold text-uppercase fs-5">carton
                                        mark:</label>
                                    <br> {{ info.carton }}
                                </div>
                            </div>
                            <div class="col-11 my-4">
                                <div class="">
                                    <label class="form-label text-milung fw-bold text-uppercase fs-5">port of
                                        loading:</label>
                                    {{ info.loading }}
                                </div>
                            </div>
                            <div class="col-11 my-3">
                                <div class="">
                                    <label class="form-label text-milung fw-bold text-uppercase fs-5">final
                                        destination:</label>
                                    {{ info.destination }}
                                </div>
                            </div>
                            <div class="col-11 my-2">
                                <div class="">
                                    <label class="form-label text-milung fw-bold text-uppercase fs-5">payment:</label>
                                    {{ info.payment }}
                                </div>
                            </div>
                            <div class="col-11 my-4 d-flex justify-content-end">
                                <div class=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container p-4" style="background-color: #14245c">
            <div class="row justify-content-between">
                <div class="col-3 my-2">
                    <div class="d-flex">
                        <div class="col-4 my-auto">
                            <p for="v-model" class="my-auto fs-7 text-white">
                                <i class="bi bi-box text-warning"></i> SO#:
                            </p>
                        </div>
                        <div class="col-8 text-white">
                            {{ info.shipment_order }}
                        </div>
                    </div>
                </div>

                <div class="col-3 my-2">
                    <div class="d-flex">
                        <div class="col-4 my-auto">
                            <p for="v-model" class="my-auto fs-7 text-white">
                                <i class="bi bi-truck text-warning"></i>
                                Courier:
                            </p>
                        </div>
                        <div class="col-8 text-white">
                            {{ info.courier }}
                        </div>
                    </div>
                </div>

                <div class="col-3 my-2">
                    <div class="d-flex">
                        <div class="col-4 my-auto">
                            <p for="v-model" class="my-auto fs-7 text-white">
                                <i class="bi bi-journal-check text-warning"></i>
                                Tracking#:
                            </p>
                        </div>
                        <div class="col-8 text-white">
                            {{ info.tracking }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

    <div class="container my-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class=""></div>
                        <div class="d-flex justify-content-between align-items-center mx-3">
                            <span>
                                <span class="fw-bold fs-4 text-uppercase" style="color: #14245c">III Packing
                                    List:</span>
                            </span>

                            <div class="col-4 d-flex">
                                <div class="col-12 d-flex">
                                    <div class="col-12">
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1"><i style="color: #41b400"
                                                    class="bx bx-filter-alt fw-bold fs-4"></i></span>
                                            <input type="text" name="search" class="form-control" v-model="searchQuery"
                                                ref="search" placeholder="Write here to filter..." />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body rounded-top table-responsive">
                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-hover">
                            <thead style="color: #009de1" class="text-center fs-7">
                                <tr style="">
                                    <th class="text-nowrap">Supplier ID</th>
                                    <th class="text-nowrap">Carton No.</th>
                                    <th class="text-nowrap">Order Number</th>
                                    <th class="text-nowrap">Description</th>
                                    <th class="text-nowrap">QTY</th>
                                    <th class="text-nowrap">Ctn</th>
                                    <th class="text-nowrap">Total Qty</th>
                                    <th class="text-nowrap">N.W. (KGS)</th>
                                    <th class="text-nowrap">Total</th>
                                    <th class="text-nowrap">G.W. (KGS)</th>
                                    <th class="text-nowrap">Total</th>

                                    <th class="text-nowrap text-milung">
                                        L(CM)
                                    </th>
                                    <th class="text-nowrap">
                                        <span>Carton Measurement</span> <br />
                                        <span class="text-milung">W(CM)</span>
                                    </th>
                                    <th class="text-nowrap text-milung">
                                        H(CM)
                                    </th>
                                    <th class="text-nowrap text-milung">CBM</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in dataToDisplay" :key="index" v-if="dataToDisplay.length > 0"
                                    class="text-center">
                                    <td class="fw-bold">
                                        {{ item.supplierid?.userid }}
                                    </td>
                                    <td>
                                        {{ item.carton }}
                                    </td>
                                    <td>{{ item.order_id }}</td>
                                    <td>
                                        {{
                                        item.orders?.product_group
                                            ?.group_name
                                    }}
                                    </td>
                                    <td>{{ item.orders?.quantity_unit }}</td>
                                    <td>
                                        {{ item.qty }}
                                    </td>
                                    <td>
                                        {{
                                        calculateTotal(
                                            item.qty,
                                            item.orders?.quantity_unit
                                        )
                                    }}
                                    </td>

                                    <td>
                                        {{ item.nw }}
                                    </td>
                                    <td>{{ item.nw * item.qty }}</td>

                                    <td>
                                        {{ item.gw }}
                                    </td>
                                    <td>{{ item.gw * item.qty }}</td>

                                    <td>
                                        {{ item.lcm }}
                                    </td>
                                    <td>
                                        {{ item.wcm }}
                                    </td>
                                    <td>
                                        {{ item.hcm }}
                                    </td>
                                    <td>{{ calculateVolume(item) }}</td>


                                </tr>
                                <tr v-else>
                                    <td colspan="17">
                                        <p class="text-center">
                                            No data to display.
                                        </p>
                                    </td>
                                </tr>

                                <td colspan="17" class="fs-4">
                                    <span class="text-milung fw-bold">Provisional Customes Clearance
                                        Code:</span><span class="fw-bold">N325</span>
                                </td>
                            </tbody>
                            <span>
                                <table class="table table-striped table-hover mt-5">
                                    <thead style="color: #009de1" class="text-center">
                                        <tr style="">
                                            <th class="text-nowrap">
                                                H.S Code
                                            </th>
                                            <th class="text-nowrap">
                                                Description
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in packinglst" class="text-center">
                                            <td>
                                                {{
                                        item.orders?.product_group
                                            ?.hs_de
                                    }}
                                            </td>
                                            <td>
                                                {{
                                            item.orders?.product_group
                                                ?.group_name
                                        }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </span>
                            <!-- <hr class="w-10">
                            <hr class="w-10"> -->
                            <tbody class="w-full border-top border-3">
                                <tr class="fw-bold">
                                    <td class="text-blue" colspan="5" style="color: #009de1">
                                        Total:
                                    </td>
                                    <td class="text-blue" style="color: #009de1">
                                        {{ totalQtys }}
                                    </td>
                                    <td class="text-blue" colspan="2" style="color: #009de1">
                                        {{ totalTotalQty }}
                                    </td>
                                    <td class="text-blue" colspan="2" style="color: #009de1">
                                        {{ totalnw }}
                                    </td>
                                    <td class="text-blue" colspan="4" style="color: #009de1">
                                        {{ totalgw }}
                                    </td>
                                    <td class="text-blue" colspan="1" style="color: #009de1">
                                        {{ totalVolumes }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- <div class="border-top border-bottom mt-4">
                        45
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row align-items-center">
            <!-- Align items vertically -->
            <div class="col-3">
                <div class="d-flex">
                    <div class="col-8 my-auto">
                        <p for="v-model" class="my-auto fs-7">
                            Shipment Extra Cost:
                        </p>
                    </div>
                    <div class="col-4">
                        {{ info.extra ?? 0 }}
                    </div>
                </div>
            </div>

            <div class="col-2">
                <router-link :to="{
                                        name: 'buyer_cibd',
                                        params: {
                                            id: info.id,
                                            so_number: info.shipment_order,
                                        },
                                    }" class="btn btn-milung px-4 fs-7">
                    <span>Generate CIBD</span>
                </router-link>
                <!-- <button ></button> -->
            </div>

            <div class="col-2">
                <router-link :to="{
                                        name: 'buyer_ci',
                                        params: {
                                            id: info.id,
                                            so_number: info.shipment_order,
        },
    }" class="btn bg-blue px-4 fs-7">
                    <span>Generate CI</span>
                </router-link>
            </div>

        </div>
    </div>
</template>

<script>
import { format } from "date-fns";
import { parseISO } from "date-fns";
import NProgress from "nprogress";
import "nprogress/nprogress.css";

export default {
    data() {
        return {
            info: {
                shipment_order: null,
                shipment_order_id: null,
            },
            packinglst: [],
            searchQuery: "",
            atc: "",
            submitting: false,
        };
    },
    computed: {
        totalQtys() {
            return this.packinglst.reduce(
                (sum, item) => parseInt(sum) + (parseFloat(item.qty) || 0),
                0
            );
        },
        totalTotalQty() {
            return this.packinglst.reduce(
                (total, item) => total + (parseFloat(item.totalqty) || 0),
                0
            );
        },
        totalnw() {
            return this.packinglst.reduce(
                (total, item) => total + (parseFloat(item.totalnw) || 0),
                0
            );
        },
        totalgw() {
            return this.packinglst.reduce(
                (total, item) => total + (parseFloat(item.totalgw) || 0),
                0
            );
        },
        totalVolumes() {
            return this.packinglst.reduce(
                (total, item) =>
                    total + (parseFloat(this.calculateVolume(item)) || 0),
                0
            );
        },
        dataToDisplay() {
            if (this.searchQuery) {
                return this.filteredpacking_lists;
            } else {
                return this.packinglst;
            }
        },
        filteredpacking_lists() {
            return this.packinglst.filter((packing_list) => {
                return (
                    packing_list.buyer
                        .toLowerCase()
                        .includes(this.searchQuery.toLowerCase()) ||
                    packing_list.supplier
                        .toLowerCase()
                        .includes(this.searchQuery)
                );
            });
        },
    },

    methods: {
        created_at(info) {
            if (info.created_at) {
                // Parse the datetime string using date-fns
                const parsedDateTime = parseISO(info.created_at);
                // Format the parsed date using date-fns
                return format(parsedDateTime, "dd-MM-yyyy");
            } else {
                return "---";
            }
        },
        toggleEditMode(index) {
            this.packinglst[index].editable = true;
        },
        calculateVolume(item) {
            const packinglist = item;
            if (packinglist) {
                const volume =
                    (packinglist.hcm * packinglist.wcm * packinglist.lcm) /
                    1000000;
                return volume * packinglist.qty;
            } else {
                return 0; // or any default value if packinglist is not available
            }
        },
        calculateTotal(qty, quantityUnit) {
            const numericQuantity = parseInt(quantityUnit);

            if (!isNaN(numericQuantity)) {
                // Perform the calculation
                return qty * numericQuantity;
            } else {
                return "N/A";
            }
        },
        handleValidationErrors(validationErrors) {
            for (const key in validationErrors) {
                if (validationErrors.hasOwnProperty(key)) {
                    const messages = validationErrors[key];
                    // console.log(messages);
                    toastr.error(messages);
                }
            }
        },
        async fetchSO() {
            const soId = this.$route.params.id;
            NProgress.start();
            try {
                const response = await axios.get("/api/buyer/shipments/" + soId + "/edit");
                this.packinglst = response.data.packing;
                this.atc = response.data.data?.atc_no;
                // this.pagination.totalItems = response.data.total;
                console.log(response.data);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error("Error fetching shipment:", error);
                toastr.error("Error fetching data");
            }
        },
        async fetchInfo() {
            const soId = this.$route.params.id;
            console.log(soId);

            NProgress.start();
            try {
                const response = await axios.get("/api/buyer/shipments/" + soId);
                this.info = response.data;
                this.info.shipment_order = this.$route.params.so_number;
                this.info.shipment_order_id = soId;
                // this.pagination.totalItems = response.data.total;
                console.log(response.data);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error("Error fetching shipment:", error);
                toastr.error("Error fetching data");
            }
        },
    },
    mounted() {
        this.fetchSO();
        this.fetchInfo();
    },
};
</script>

<style scoped>
.mx-6 {
    margin-right: 11rem !important;
    margin-left: 11rem !important;
}

.bg-blue {
    background-color: #009de1 !important;
    border-color: #009de1 !important;
    color: white;
}

.bg-milung {
    background-color: #14245c !important;
    border-color: #14245c !important;
    color: white;
}

.bg-orange {
    background-color: #f67b00 !important;
    border-color: #f67b00 !important;
    color: white;
}
</style>
