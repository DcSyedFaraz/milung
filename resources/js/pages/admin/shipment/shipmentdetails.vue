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
                        <input type="text" v-model="so.so_number" disabled class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Buyer ID:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" disabled v-model="so.user.buyer_id" class="form-control ">
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

            </div>
            <div class="col-6">
                <div class="d-flex col-12 my-2 mt-4">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Delivery Date:</p>
                    </div>
                    <div class="col-7">
                        <input type="date" v-model="buyer.delivery" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">ATC Number:</p>
                    </div>
                    <div class="col-7">
                        <input type="text" v-model="buyer.atc_no" class="form-control ">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="mt-2">
                        <label class="form-label">Remarks:</label>
                        <!-- <button @click="save">save</button> -->
                        <textarea v-model="buyer.remarks" cols="57" rows="6" class="form-control "></textarea>
                    </div>
                </div>
            </div>
        </div>
        <!-- Buyer shipment End -->
        <!-- Supplier shipment -->
        <div v-for="(supplier, index) in supplier_shipments" :key="index" class="row px-2 pb-5">
            <h3 class="text-milung text-uppercase fw-bold">Supplier- {{ supplieruserid[index]['supplier_id'] }} Shipment
                Information </h3>
            <div class="col-6">
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Shipping Date:</p>
                    </div>
                    <div class="col-8">
                        <input type="date" v-model="supplier.ship_date" class="form-control">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Mode Of Delivery:</p>
                    </div>
                    <div class="col-8">
                        <select class="fw-bold form-select" v-model="supplier.mode_delivery">
                            <option value="Forwarder Pickup">Forwarder Pickup</option>
                            <option value="Delivery">Delivery</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Tracking / Waybill#:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="supplier.waybill" class="form-control">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Courier:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="supplier.courier" class="form-control">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Flight:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="supplier.flight" class="form-control">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Vessel:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="supplier.vessel" class="form-control">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Train:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="supplier.train" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="d-flex col-12 my-2">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto ">Delivery Date:</p>
                    </div>
                    <div class="col-7">
                        <input type="date" v-model="supplier.delivery" class="form-control">
                    </div>
                </div>
                <div class="d-flex col-12 my-2">
                    <div class="mt-2">
                        <label class="form-label">Remarks:</label>
                        <textarea v-model="supplier.remarks" cols="57" rows="6" class="form-control"></textarea>
                    </div>
                    <!-- <button @click="save">save</button> -->
                </div>
            </div>
        </div>
        <div class="d-flex col-12 my-2 justify-content-end pe-5 pb-5">
            <button class="btn btn-lg btn-success px-4" @click="save">Save</button>
        </div>

        <!-- Supplier shipment End -->
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
            supplieruserid: this.soData.supplier_ids,
            buyer: this.soData.shipment ? this.soData.shipment : {},
            supplier_shipments: this.initSupplierShipments()
        }
    },
    methods: {
        initSupplierShipments() {
            const supplierIds = this.soData.supplier_ids || [];
            console.log(supplierIds);
            const defaultSupplierShipment = { ship_date: '', mode_delivery: '', waybill: '', courier: '', flight: '', vessel: '', train: '', delivery: '', remarks: '' };
            return supplierIds.map(supplierId => {
                const preFillData = Array.isArray(this.soData.shipmentsupplier) && this.soData.shipmentsupplier.find(supplier => supplier.user_id === supplierId.id);
                return preFillData ? preFillData : { ...defaultSupplierShipment, user_id: supplierId.id };
            });
        },
        handleValidationErrors(validationErrors) {
            validationErrors.forEach(message => {
                toastr.error(message);
            });
        },
        async save() {
            console.log(this.so);
            console.log(this.buyer);
            console.log(this.supplier);
            const formData = {
                'shipment_order': this.so,
                'buyer': this.buyer,
                'supplier': this.supplier_shipments
            };

            try {
                const response = await axios.post(`/api/shipment/${this.so.id}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                console.log(response.data);
                toastr.success(response.data.message);
                this.$emit('record-updated');
            } catch (error) {
                console.error(error);
                if (error.response && error.response.status === 422) {
                    const validationErrors = error.response.data.errors;
                    this.handleValidationErrors(validationErrors);
                } else {
                    console.error(error);
                    toastr.error('An error occurred while updating the order');
                }
            }
        },
    }
}
</script>

<style scoped>
.con {
    background-color: #dff2fb;
}
</style>
