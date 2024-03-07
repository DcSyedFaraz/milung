<template>
    <div class="con">
        <div class="row px-2 pb-5">
            <div class="col-6">
                <!-- {{ so }} -->
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">SO#:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="so.so_number" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Buyer ID:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" disabled v-model="so.user?.userid" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Shipping Method:</p>
                    </div>
                    <div class="col-8">
                        <select class="fw-bold form-select" v-model="so.method">
                            <option value="Air">Air</option>
                            <option value="Sea">Sea</option>
                            <option value="Train">Train</option>
                            <option value="Courier">Courier</option>
                        </select>

                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Departure Port:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="so.port" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Destination Port:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="so.destination" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Incoterm:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="so.incoterm" class="form-control ">
                    </div>
                </div>

            </div>
            <div class="col-6">
                <div class="d-flex col-12 my-2">
                    <div class="mt-2">
                        <label class="form-label">Remarks:</label>
                        <textarea v-model="so.remarks" cols="55" rows="6" class="form-control "></textarea>
                    </div>
                </div>
            </div>
        </div>
        <!-- Buyer shipment -->
        <div class="row px-2 pb-5">
            <div class="col-6">
                <h3 class="text-milung text-uppercase fw-bold">Buyer Shipment Information</h3>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Shippind Date:</p>
                    </div>
                    <div class="col-8">
                        <input type="date" v-model="so.ship_date" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Shipping Agent:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="so.ship_agent" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Tracking / Waybillt#:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="so.waybill" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Courier:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="so.courier" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Flight:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="so.flight" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Vessel:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="so.vessel" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Train:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="so.train" class="form-control ">
                    </div>
                </div>

            </div>
            <div class="col-6">
                <div class="d-flex col-12 my-2 mt-4">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Delivery Date:</p>
                    </div>
                    <div class="col-7">
                        <input type="date" v-model="so.delivery" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">ATC Number:</p>
                    </div>
                    <div class="col-7">
                        <input type="date" v-model="so.atc_no" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="mt-2">
                        <label class="form-label">Remarks:</label>
                        <!-- <button @click="save">save</button> -->
                        <textarea v-model="so.buyerremarks" cols="57" rows="6" class="form-control "></textarea>
                    </div>
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
            required: true
        }
    },
    data() {
        return {
            so: this.soData,
        }
    },
    methods:{
        async save() {
            console.log(this.so);

            // try {
            //     const response = await axios.post('/api/statement', formData, {
            //         headers: {
            //             'Content-Type': 'multipart/form-data'
            //         }
            //     });
            //     console.log(response.data);
            // } catch (error) {
            //     console.error(error);
            // }
        },
    }
}
</script>

<style scoped>
.con {
    background-color: #dff2fb;
}
</style>
