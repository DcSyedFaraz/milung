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
        <!-- Buyer shipment -->
        <div class="row px-2 pb-5">
            <h3 class="text-milung text-uppercase fw-bold">Buyer Shipment Information</h3>
            <div class="col-6">
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Shipping Date:</p>
                    </div>
                    <div class="col-8">
                        <input type="date" v-model="buyer.ship_date" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Shipping Agent:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="buyer.ship_agent" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Tracking / Waybillt#:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="buyer.waybill" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Courier:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="buyer.courier" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Flight:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="buyer.flight" class="form-control ">
                    </div>
                </div>


            </div>
            <div class="col-6">
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Vessel:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="buyer.vessel" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Train:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="buyer.train" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2 ">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Delivery Date:</p>
                    </div>
                    <div class="col-8">
                        <input type="date" v-model="buyer.delivery" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">ATC Number:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="buyer.atc_no" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2 justify-content-end mt-5">

                    <button class="btn btn-success px-4" @click="save">Save</button>
                </div>

            </div>
        </div>
        <!-- Buyer shipment End -->
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
            buyer: this.soData.user
                ? this.soData.user
                : {},
        };
    },
    methods: {
        async save() {
            console.log(this.so);
            console.log(this.buyer);
            // const formData = {
            //     shipment_order: this.so,
            //     buyer: this.buyer,
            // };

            try {
                const response = await axios.post(
                    `/api/buyer/shipments/${this.so.id}`,
                    this.buyer,
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
