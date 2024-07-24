<template>
    <div class="con">
        <div class="row px-2 pb-5">
            <div class="col-6">
                <!-- {{ so }} -->
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto">SO#:</p>
                    </div>
                    <div class="col-8">
                        <span class="text-milung fw-bold">

                            {{ so.so_number }}
                        </span>
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto">Shipping Method:</p>
                    </div>
                    <div class="col-8">
                        <span class="text-milung fw-bold">

                            {{ so.method }}
                        </span>
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto">Departure Port:</p>
                    </div>
                    <div class="col-8">
                        <span class="text-milung fw-bold">

                            {{ so.port }}
                        </span>
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto">Destination Port:</p>
                    </div>
                    <div class="col-8">
                        <span class="text-milung fw-bold">

                            {{ so.destination }}
                        </span>
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto">Incoterm:</p>
                    </div>
                    <div class="col-8">
                        <span class="text-milung fw-bold">

                            {{ so.incoterm }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="d-flex col-12 my-2">
                    <div class="mt-2">
                        <label class="form-label">Remarks:</label>
                        <span class="text-milung fw-bold">

                            {{ so.remarks }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Buyer shipment End -->
        <!-- Supplier shipment -->
        <div class="row px-2 pb-5">
            <h3 class="text-milung fw-bold text-uppercase fw-bold">
                Supplier Shipment Information
            </h3>
            <div class="col-6">
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto">Shipping Date:</p>
                    </div>
                    <div class="col-8">
                        <input
                            type="date"
                            v-model="supplier.ship_date"
                            class="form-control"
                        />
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto">Mode Of Delivery:</p>
                    </div>
                    <div class="col-8">
                        <select
                            class="fw-bold form-select"
                            v-model="supplier.mode_delivery"
                        >
                            <option value="Forwarder Pickup">
                                Forwarder Pickup
                            </option>
                            <option value="Delivery">Delivery</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto">
                            Tracking / Waybillt#:
                        </p>
                    </div>
                    <div class="col-8">
                        <input
                            type="text"
                            v-model="supplier.waybill"
                            class="form-control"
                        />
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto">Courier:</p>
                    </div>
                    <div class="col-8">
                        <input
                            type="text"
                            v-model="supplier.courier"
                            class="form-control"
                        />
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto">Flight:</p>
                    </div>
                    <div class="col-8">
                        <input
                            type="text"
                            v-model="supplier.flight"
                            class="form-control"
                        />
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto">Vessel:</p>
                    </div>
                    <div class="col-8">
                        <input
                            type="text"
                            v-model="supplier.vessel"
                            class="form-control"
                        />
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto">Train:</p>
                    </div>
                    <div class="col-8">
                        <input
                            type="text"
                            v-model="supplier.train"
                            class="form-control"
                        />
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto">Delivery Date:</p>
                    </div>
                    <div class="col-8">
                        <input
                            type="date"
                            v-model="supplier.delivery"
                            class="form-control"
                        />
                    </div>
                </div>
                <div class="d-flex col-12 my-2 justify-content-end mt-5">
                    <button class="btn btn-success px-4" @click="save">
                        Save
                    </button>
                </div>
            </div>
        </div>
        <!-- Supplier shipment End -->
    </div>
</template>

<script>
export default {
    props: {
        soData: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            so: this.soData,
            supplier: this.soData.shipmentsupplier
                ? this.soData.shipmentsupplier[0]
                : {},
        };
    },
    methods: {
        async save() {
            console.log(this.so);
            console.log(this.supplier);
            // const formData = {
            //     shipment_order: this.so,
            //     supplier: this.supplier,
            // };

            try {
                const response = await axios.post(
                    `/api/supplier/shipment/${this.so.id}`,
                    this.supplier,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );
                console.log(response.data);
                toastr.success(response.data.message);
                this.$emit("record-updated");
            } catch (error) {
                console.error(error);
                toastr.error(error.response.data.error);
            }
        },
    },
};
</script>

<style scoped>
.con {
    background-color: #dff2fb;
}
</style>
