<template>
    <div class="container p-4" style="background-color: #14245c;">
        <div class="row justify-content-between">

            <div class="col-4 my-2">
                <div class="d-flex">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto fs-7 text-white"><i class="bi bi-box text-warning"></i> SO#:</p>
                    </div>
                    <div class="col-8">
                        <p class=""></p>
                    </div>
                </div>
            </div>
            <!-- <div class="d-flex col-2 my-2 ">
                <button class="btn btn-warning mx-2 px-5" name="action" value="save">Save </button>
            </div> -->

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
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="(item, index) in orders" :key="index" class="text-center">
                                    <!-- Editable cells -->

                                    <td>{{
                                    item.packinglist?.carton }} </td>
                                    <td>{{ item.id }} </td>
                                    <td>{{ item.product_group?.group_name }} </td>
                                    <td>{{ item.quantity_unit }} </td>
                                    <td>{{
                                    item.packinglist?.qty
                                }} </td>
                                    <td>{{
                                        item.packinglist?.totalqty
                                    }} </td>

                                    <td>{{
                                        item.packinglist?.nw }}
                                    </td>
                                    <td>{{ item.packinglist?.nw * item.packinglist?.qty }} </td>

                                    <td>{{
                                    item.packinglist?.gw }}
                                    </td>
                                    <td>{{ item.packinglist?.gw * item.packinglist?.qty }} </td>

                                    <td>{{
                                    item.packinglist?.lcm
                                }} </td>
                                    <td>{{
                                        item.packinglist?.wcm
                                    }} </td>
                                    <td>{{
                                        item.packinglist?.hcm
                                    }} </td>
                                    <td>{{ calculateVolume(item) }}</td>

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
export default {

    data() {

        return { orders: {} }
    },
    methods: {
        calculateVolume(item) {
            const packinglist = item.packinglist;
            if (packinglist) {
                const volume = (packinglist.hcm * packinglist.wcm * packinglist.lcm) / 1000000;
                return volume * packinglist.qty;
            } else {
                return 0; // or any default value if packinglist is not available
            }
        },
    },
    mounted() {
        const serializedData = this.$route.params.data;
        const data = JSON.parse(serializedData);
        this.orders = data;
        console.log(this.orders);

    },
}
</script>

<style lang="scss" scoped></style>
