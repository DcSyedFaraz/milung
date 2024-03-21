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
                                        <p
                                            class="fw-bold text-milung text-uppercase my-auto"
                                        >
                                            Supplier ID:
                                        </p>
                                    </div>
                                    <div class="col-7">
                                        <!-- <input type="text" v-model="so.buyerid" class="form-control"> -->
                                        <multiselect
                                            v-model="selectedsupplierId"
                                            :options="suppliers"
                                            field="id"
                                            label="userid"
                                            track-by="id"
                                        >
                                        </multiselect>
                                    </div>
                                </div>
                                <div class="d-flex col-11 my-2">
                                    <div class="col-3 my-auto">
                                        <p
                                            class="fw-bold text-milung text-uppercase my-auto"
                                        >
                                            so#:
                                        </p>
                                    </div>
                                    <div class="col-7">
                                        <!-- <input type="text" v-model="so.buyerid" class="form-control"> -->
                                        <multiselect
                                            v-model="selectedsoId"
                                            :options="so"
                                            field="id"
                                            label="userid"
                                            track-by="id"
                                        >
                                        </multiselect>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">by</div>
                        </div>
                        <div
                            class="d-flex justify-content-between align-items-center mx-3"
                        >
                            <span>
                                <span
                                    class="fw-bold fs-4 text-uppercase"
                                    style="color: #14245c"
                                    >Outstanding payment order list:</span
                                >
                            </span>

                            <!-- <div class="col-4 d-flex">
                                <div class="col-12 d-flex justify-content-end">
                                    <div class="col-4 mx-2 align-items-end">
                                        <router-link
                                            :to="{ name: 'create_so' }"
                                            class="btn btn-warning fw-bold text-dark"
                                            >Create SO#
                                        </router-link>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <!-- // Loader -->
                    <div class="card-body rounded-top" v-if="isLoading">
                        <div class="d-flex justify-content-center">
                            <div
                                class="spinner-border text-warning"
                                role="status"
                            >
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <!-- // Loader -->
                    <div class="card-body rounded-top table-responsive" v-else>
                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-hover">
                            <thead style="color: #009de1" class="text-center">
                                <tr style="">
                                    <th class="text-nowrap">SO#</th>
                                    <th class="text-nowrap">Shipment Date</th>
                                    <th class="text-nowrap">Shipping Method</th>
                                    <th class="text-nowrap">
                                        Tracking / Waybillt#
                                    </th>
                                    <th class="text-nowrap">Delivery Date</th>
                                    <th class="text-nowrap">
                                        Shipping Documents
                                    </th>
                                    <th class="text-nowrap">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td colspan="17">
                                        <p class="text-center">
                                            No orders to display.
                                        </p>
                                    </td>
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
import Multiselect from "vue-multiselect";

export default {
    components: {
        Multiselect,
    },
    data() {
        return {
            isLoading: true,
            suppliers: [],
            selectedsupplierId: "",
            so: [],
            selectedsoId: "",
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
    methods: {
        async fetchSOs(supplierId) {
            NProgress.start();
            try {
                const response = await axios.get(`/api/so/${supplierId}`);
                this.so = response.data;
                console.log(this.so);

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

<style scoped></style>
