<template>
    <form @submit.prevent="submitForm">

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-milung fw-bold text-center">MiLung Trade Limited</h1>
                <p class="text-center text-milung fw-bold my-3">
                    Unit 1704-05, 17/F. Hang Seng North Point Building,<br>
                    341 North Point, Hong Kong. <br>
                    Tel: 852 2540 2488
                </p>
            </div>
            <div class="col-12">
                <div class="row mx-6 mt-4">
                    <div class="col mx-1 border rounded-3 rounded bg-milung">

                        <div class="text-center p-3">
                            <p class="fw-bold">Invoice No: <br> 12345678</p>
                        </div>

                    </div>
                    <div class="col mx-1 border rounded-3 rounded bg-blue">

                        <div class="text-center p-3">
                            <p class="fw-bold">Cust Ref. (ATC): <br> 12345678</p>
                        </div>
                    </div>
                    <div class="col mx-1 border rounded-3 rounded bg-warning">

                        <div class="text-center p-3">
                            <p class="fw-bold">Date: <br> 12345678</p>
                        </div>
                    </div>
                    <div class="col mx-1 border rounded-3 rounded bg-orange">

                        <div class="text-center p-3">
                            <p class="fw-bold">Prepred By: <br> 12345678</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-5">

                    <div class="row">

                        <div class="col-6">
                            <div class=" col-11 my-2">
                                <div class="">
                                    <label class="form-label text-milung fw-bold text-uppercase fs-5">invoice#:</label>
                                    <input type="text" v-model="info.invoice" class="form-control ">
                                </div>
                            </div>
                            <div class="d-flex col-11 my-2">
                                <div class="">
                                    <label class="form-label text-milung fw-bold text-uppercase fs-5">Shipper:</label>
                                    <textarea v-model="info.shipper" class="form-control" cols="58" rows="6"></textarea>
                                </div>
                            </div>
                            <div class="d-flex col-11 my-2">
                                <div class="">
                                    <label class="form-label text-milung fw-bold text-uppercase fs-5">consignee:</label>
                                    <textarea v-model="info.consignee" class="form-control" cols="58"
                                        rows="6"></textarea>
                                </div>
                            </div>
                            <div class=" col-11 my-2">
                                <div class="">
                                    <label class="form-label text-milung fw-bold text-uppercase fs-5">notify
                                        party:</label>
                                    <input type="text" v-model="info.party" class="form-control ">
                                </div>
                            </div>

                        </div>
                        <div class="col-6">

                            <div class="d-flex col-11 my-2">
                                <div class="">
                                    <label class="form-label text-milung fw-bold text-uppercase fs-5">carton
                                        mark:</label>
                                    <textarea v-model="info.carton" class="form-control" cols="58" rows="6"></textarea>
                                </div>
                            </div>
                            <div class=" col-11 my-4">
                                <div class="">
                                    <label class="form-label text-milung fw-bold text-uppercase fs-5">port of
                                        loading:</label>
                                    <input type="text" v-model="info.loading" class="form-control ">
                                </div>
                            </div>
                            <div class=" col-11 my-3">
                                <div class="">
                                    <label class="form-label text-milung fw-bold text-uppercase fs-5">final
                                        destination:</label>
                                    <input type="text" v-model="info.destination" class="form-control ">
                                </div>
                            </div>
                            <div class=" col-11 my-2">
                                <div class="">
                                    <label class="form-label text-milung fw-bold text-uppercase fs-5">payment:</label>
                                    <input type="text" v-model="info.payment" class="form-control ">
                                </div>
                            </div>
                            <div class=" col-11 my-4 d-flex justify-content-end">
                                <div class="">

                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="container p-4" style="background-color: #14245c;">
        <div class="row justify-content-between">

            <div class="col-3 my-2">
                <div class="d-flex">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto fs-7 text-white"><i class="bi bi-box text-warning"></i> SO#:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="info.so_no" class="form-control ">
                    </div>
                </div>
            </div>

            <div class="col-3 my-2">
                <div class="d-flex">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto fs-7 text-white"><i class="bi bi-truck text-warning"></i>
                            Courier:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="info.courier" class="form-control ">
                    </div>
                </div>
            </div>

            <div class="col-3 my-2">
                <div class="d-flex">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto fs-7 text-white"><i
                                class="bi bi-journal-check text-warning"></i> Tracking#:</p>
                    </div>
                    <div class="col-8">
                        <input type="text" v-model="info.tracking" class="form-control ">
                    </div>
                </div>
            </div>

            <div class="col-3 my-auto">
                <button class="btn btn-warning px-5" :disabled="submitting"><span
                    v-if="submitting">Submitting...</span>
                <span v-else>Save</span></button>
            </div>

        </div>
    </div>
</form>

    <div class="container my-4">
        <div class="row">
            <div class="col-lg-12 ">

                <div class="card  ">
                    <div class="card-header  ">
                        <div class="">

                        </div>
                        <div class="d-flex justify-content-between align-items-center mx-3">
                            <span>
                                <span class=" fw-bold fs-4 text-uppercase" style="color: #14245c;">III Packing
                                    List:</span>
                            </span>

                            <div class="col-4 d-flex">
                                <div class="col-12 d-flex">
                                    <div class="col-12">
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1"><i style="color: #41b400;"
                                                    class="bx bx-filter-alt fw-bold fs-4"></i></span>
                                            <input type="text" name="search" class="form-control " v-model="searchQuery"
                                                ref="search" placeholder="Write here to filter..." />
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card-body rounded-top table-responsive ">

                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-hover  ">
                            <thead style="color: #009de1; " class="text-center fs-7 ">
                                <tr style="">
                                    <th class="text-nowrap"> Supplier ID </th>
                                    <th class="text-nowrap"> Carton No. </th>
                                    <th class="text-nowrap">Order Number</th>
                                    <th class="text-nowrap">Description</th>
                                    <th class="text-nowrap">QTY</th>
                                    <th class="text-nowrap">Ctn</th>
                                    <th class="text-nowrap">Total Qty</th>
                                    <th class="text-nowrap">N.W. (KGS)</th>
                                    <th class="text-nowrap">Total</th>
                                    <th class="text-nowrap">G.W. (KGS)</th>
                                    <th class="text-nowrap">Total</th>


                                    <th class="text-nowrap text-milung">L(CM)</th>
                                    <th class="text-nowrap"><span>Carton Measurement</span> <br>
                                        <span class="text-milung">W(CM)</span>
                                    </th>
                                    <th class="text-nowrap text-milung">H(CM)</th>
                                    <th class="text-nowrap text-milung">CBM</th>
                                    <th class="text-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in dataToDisplay" :key="index" v-if="dataToDisplay.length > 0"
                                    class="text-center">
                                    <td class="fw-bold">{{ item.supplierid?.userid }} </td>
                                    <td :contenteditable="item.editable" @input="updateData(index, $event, 'carton')">{{
                    item.carton }} </td>
                                    <td>{{ item.id }} </td>
                                    <td>{{ item.orders?.product_group?.group_name }} </td>
                                    <td>{{ item.orders?.quantity_unit }} </td>
                                    <td :contenteditable="item.editable" @input="updateData(index, $event, 'qty')">{{
                    item.qty
                }} </td>
                                    <td>{{ calculateTotal(item.qty, item.orders?.quantity_unit) }}</td>

                                    <td :contenteditable="item.editable" @input="updateData(index, $event, 'nw')">{{
                    item.nw }}
                                    </td>
                                    <td>{{ item.nw * item.qty }} </td>

                                    <td :contenteditable="item.editable" @input="updateData(index, $event, 'gw')">{{
                    item.gw }}
                                    </td>
                                    <td>{{ item.gw * item.qty }} </td>

                                    <td :contenteditable="item.editable" @input="updateData(index, $event, 'lcm')">{{
                    item.lcm
                }} </td>
                                    <td :contenteditable="item.editable" @input="updateData(index, $event, 'wcm')">{{
                    item.wcm
                }} </td>
                                    <td :contenteditable="item.editable" @input="updateData(index, $event, 'hcm')">{{
                    item.hcm
                }} </td>
                                    <td>{{ calculateVolume(item) }}</td>

                                    <td> <template v-if="!item.editable">
                                            <button @click="toggleEditMode(index)"
                                                class="btn btn-light text-success btn-sm"><i
                                                    class="bi bi-pencil"></i></button>
                                        </template>
                                        <template v-else>
                                            <button @click="saveItem(index)" class="btn btn-light text-danger btn-sm"><i
                                                    class="bi bi-save2"></i></button>
                                        </template>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td colspan="17">
                                        <p class="text-center">No data to display.</p>
                                    </td>
                                </tr>

                            </tbody>
                            <table class="table table-striped table-hover  w-25 mt-5">
                                <thead style="color: #009de1; " class="text-center">
                                    <tr style="">
                                        <th class="text-nowrap">H.S Code </th>
                                        <th class="text-nowrap">Description </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in packinglst" class="text-center ">
                                        <td>
                                            {{ item.orders?.product_group?.hs_cn }}
                                        </td>
                                        <td>
                                            {{ item.orders?.product_group?.group_name }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- <hr class="w-10">
                            <hr class="w-10"> -->
                            <tbody class="w-full border-top border-3">
                                <tr class="fw-bold ">
                                    <td class="text-blue" colspan="5" style="color: #009de1; ">Total:</td>
                                    <td class="text-blue" style="color: #009de1; ">{{totalQtys}}</td>
                                    <td class="text-blue" colspan="2" style="color: #009de1; ">{{totalTotalQty}}</td>
                                    <td class="text-blue" colspan="2" style="color: #009de1; ">{{totalnw}}</td>
                                    <td class="text-blue" colspan="4" style="color: #009de1; ">{{totalgw}}</td>
                                    <td class="text-blue" colspan="1" style="color: #009de1; ">{{totalVolumes}}</td>
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
        <div class="row align-items-center"> <!-- Align items vertically -->
            <div class="col-3">
                <div class="d-flex">
                    <div class="col-8 my-auto">
                        <p for="v-model" class="my-auto fs-7">Shipment Extra Cost:</p>
                    </div>
                    <div class="col-4">
                        <input type="number" v-model="info.extra" class="form-control">
                    </div>
                </div>
            </div>

            <div class="col-2">
                <button class="btn btn-warning px-5">Save</button> <!-- Adjust padding for consistency -->
            </div>
            <div class="col-2">
                <router-link :to="{ name: 'cibd' }" class="btn btn-milung px-4 fs-7">
                    <span>Generate CIBD</span>
                </router-link>
                <!-- <button ></button> -->
            </div>

            <div class="col-2">
                <router-link :to="{ name: 'ci' }" class="btn bg-blue px-4 fs-7">
                    <span>Generate CI</span>
                </router-link>
            </div>

            <div class="col-3">
                <button class="btn btn-success px-4" type="button">Export Shipping Docs</button>
            </div>
        </div>
    </div>


</template>

<script>

import NProgress from 'nprogress';
import 'nprogress/nprogress.css';

export default {
    data() {
        return {
            info: {},
            packinglst: [],
            searchQuery: '',
            submitting: false
        }
    },
    computed: {
        totalQtys() {
            return this.packinglst.reduce((sum, item) => parseInt(sum) + (parseFloat(item.qty) || 0), 0);
        },
        totalTotalQty() {
            return this.packinglst.reduce((total, item) => total + (parseFloat(item.totalqty) || 0), 0);
        },
        totalnw() {
            return this.packinglst.reduce((total, item) => total + (parseFloat(item.totalnw) || 0), 0);
        },
        totalgw() {
            return this.packinglst.reduce((total, item) => total + (parseFloat(item.totalgw) || 0), 0);
        },
        totalVolumes() {
            return this.packinglst.reduce((total, item) => total + (parseFloat(this.calculateVolume(item)) || 0), 0);
        },
        dataToDisplay() {
            if (this.searchQuery) {
                return this.filteredpacking_lists;
            } else {
                return this.packinglst;
            }
        },
        filteredpacking_lists() {
            return this.packinglst.filter(packing_list => {
                return packing_list.buyer.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    (packing_list.supplier.toLowerCase().includes(this.searchQuery));

            });
        },
    },

    methods: {
        toggleEditMode(index) {
            this.packinglst[index].editable = true;
        },
        updateData(index, event, names) {

            this.packinglst[index][names] = event.target.textContent;


            if (this.packinglst[index]) {
                const packinglist = this.packinglst[index];
                // console.log(packinglist,this.packinglst[index]);
                // ...
                switch (names) {
                    case 'qty':
                        packinglist.totalqty = this.calculateTotal(packinglist.qty, this.packinglst[index].orders.quantity_unit);
                        break;
                    case 'nw':
                        packinglist.totalnw = packinglist.qty * packinglist.nw;
                        break;
                    case 'gw':
                        packinglist.totalgw = packinglist.qty * packinglist.gw;
                        break;
                    case 'lcm':
                    case 'wcm':
                    case 'hcm':
                        packinglist.totalVolume = this.calculateVolume(this.packinglst[index]);
                        break;
                    default:
                        break;
                }
            }

        },
        saveItem(index) {
            const updatedItem = this.packinglst[index];
            console.log(updatedItem);
            this.packinglst[index].editable = false;
            // Implement your API call to save the updated data
            if (!updatedItem) {
                toastr.error("Please fill in all packing list fields.");
                return
            }
            axios.post('/api/infosave/' + updatedItem.id, updatedItem)
                .then(response => {
                    console.log(response);
                    toastr.success(response.data.message);
                    this.fetchSO();
                })
                .catch(error => {
                    console.error('Error updating data:', error);
                    if (error.response && error.response.status === 422) {
                        const validationErrors = error.response.data.errors;
                        this.handleValidationErrors(validationErrors);
                    } else {
                        // Non-validation error, log the error
                        console.error(error);

                        // Show a toastr error notification
                        toastr.error('An error occurred while adding the user');
                    }
                });
        },
        calculateVolume(item) {
            const packinglist = item;
            if (packinglist) {
                const volume = (packinglist.hcm * packinglist.wcm * packinglist.lcm) / 1000000;
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
                return 'N/A';
            }
        },
        handleValidationErrors(validationErrors) {
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
        submitForm() {
            // Disable submit button to prevent multiple submissions
            this.submitting = true;

            console.log(this.info);
            axios.post('/api/create_doc', this.info)
                .then(response => {
                    // Handle successful packing_list creation
                    console.log(response.data);

                    // Assuming you want to show a success toastr notification
                    toastr.success(response.data.message);
                    // this.$router.push({ name: 'shipment_overview' });
                })
                .catch(error => {
                    // Handle errors
                    if (error.response && error.response.status === 422) {
                        const validationErrors = error.response.data.errors;
                        this.handleValidationErrors(validationErrors);
                    } else {
                        // Non-validation error, log the error
                        console.error(error);

                        // Show a toastr error notification
                        toastr.error('An error occurred while adding the packing_list');
                    }
                })
                .finally(() => {
                    // Re-enable submit button after form submission is complete
                    this.submitting = false;
                });
        },
        async fetchSO() {
            const soId = this.$route.params.id;
            NProgress.start();
            try {
                const response = await axios.get('/api/shipmentget/' + soId);
                this.packinglst = response.data;
                // this.pagination.totalItems = response.data.total;
                console.log(response.data);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error('Error fetching shipment:', error);
                toastr.error('Error fetching data');
            }
        }
    },
    mounted() {
        this.fetchSO();
    },
}
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
