<template>
    <div class="container p-4" style="background-color: #14245c;">
        <div class="row justify-content-between">

            <div class="col-4 my-2">
                <div class="d-flex">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto fs-7 text-white"><i class="bi bi-box text-warning"></i> SO#:</p>
                    </div>
                    <div class="col-8">
                        <!-- <input type="text" v-model="info.so_no" class="form-control "> -->
                        <multiselect v-model="info.so_no" :options="so" field="id" label="so_number" track-by="id">
                        </multiselect>
                    </div>
                </div>
            </div>
            <div class="d-flex col-2 my-2 ">
                <button class="btn btn-warning mx-2 px-5" name="action" value="save">Save </button>
            </div>

        </div>
    </div>
    <div class="container my-4">
        <div class="row">
            <div class="col-lg-12 ">

                <div class="card  ">


                    <div class="card-body rounded-top table-responsive">

                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-hover  ">
                            <thead style="color: #009de1; " class="text-center fs-7 ">
                                <tr style="">

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

                                <tr v-for="(item, index) in orders" :key="index" class="text-center">
                                    <!-- Editable cells -->

                                    <td :contenteditable="item.editable" @input="updateData(index, $event, 'carton')">{{
                            item.packinglist?.carton }} </td>
                                    <td>{{ item.id }} </td>
                                    <td>{{ item.product_group?.group_name }} </td>
                                    <td>{{ item.quantity_unit }} </td>
                                    <td :contenteditable="item.editable" @input="updateData(index, $event, 'qty')">{{
                            item.packinglist?.qty
                        }} </td>
                                    <td>{{ calculateTotal(item.packinglist?.qty, item.quantity_unit) }}</td>

                                    <td :contenteditable="item.editable" @input="updateData(index, $event, 'nw')">{{
                            item.packinglist?.nw }}
                                    </td>
                                    <td>{{ item.packinglist?.nw * item.packinglist?.qty }} </td>

                                    <td :contenteditable="item.editable" @input="updateData(index, $event, 'gw')">{{
                            item.packinglist?.gw }}
                                    </td>
                                    <td>{{ item.packinglist?.gw * item.packinglist?.qty }} </td>

                                    <td :contenteditable="item.editable" @input="updateData(index, $event, 'lcm')">{{
                            item.packinglist?.lcm
                        }} </td>
                                    <td :contenteditable="item.editable" @input="updateData(index, $event, 'wcm')">{{
                            item.packinglist?.wcm
                        }} </td>
                                    <td :contenteditable="item.editable" @input="updateData(index, $event, 'hcm')">{{
                                        item.packinglist?.hcm
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
                                <!-- Show a message if there are no items -->
                                <tr v-if="orders.length === 0">
                                    <td colspan="17" class="text-center">No data to display.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

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
            so: [],
            orders: [],
            submitting: false
        }
    },
    methods: {
        toggleEditMode(index) {
            this.orders[index].editable = true;
        },
        updateData(index, event, names) {
            // Update the corresponding data in the component
            this.orders[index].packinglist = this.orders[index].packinglist || {};
            console.log(names);
            this.orders[index].packinglist[names] = event.target.textContent;

            if (this.orders[index].packinglist) {
                const { packinglist } = this.orders[index];
                switch (names) {
                    case 'qty':
                        packinglist.totalqty = this.calculateTotal(packinglist.qty, this.orders[index].quantity_unit);
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
                        packinglist.totalVolume = this.calculateVolume(this.orders[index]);
                        break;
                    default:
                        break;
                }
            }

        },
        saveItem(index) {
            const updatedItem = this.orders[index];
            console.log(updatedItem);
            this.orders[index].editable = false;
            // Implement your API call to save the updated data
            if(!updatedItem.packinglist){
                toastr.error("Please fill in all packing list fields.");
                return
            }
            axios.post('/api/suppliershipments/' + updatedItem.id, updatedItem)
                .then(response => {
                    console.log(response);
                    toastr.success(response.data.message);
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
            const packinglist = item.packinglist;
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
        fetchSO() {
            axios.get('/api/suppliershipments')
                .then(response => {
                    this.so = response.data;
                    console.log(this.so);

                })
                .catch(error => {
                    console.error(error);
                });
        },
        handleValidationErrors(validationErrors) {
            // Assuming you have a function to display toastr error messages
            for (const key in validationErrors) {
                if (validationErrors.hasOwnProperty(key)) {
                    const messages = validationErrors[key];
                    // console.log(messages);
                    // Display each validation error message
                    toastr.error(messages);
                    // messages.forEach(message => {
                    // });
                }
            }
        },
    },
    watch: {
        'info.so_no': function (newVal, oldVal) {
            if (newVal !== null) {
                axios.get('/api/suppliershipments/' + newVal.id)
                    .then(response => {
                        console.log(response.data);
                        this.orders = response.data;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }
    },
    mounted() {
        this.fetchSO();
    },
}
</script>

<style scoped></style>
