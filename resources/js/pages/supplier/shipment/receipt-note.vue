<template>
    <div class="container" id="print-container">
        <div class="row">
            <div class="col-9">
                <h3 class="text-center py-5 text-milung fw-bold" style="margin-left: 12rem !important;">
                    Receipt Note
                </h3>
            </div>
            <div class="col-3 ">
                <div class="d-flex col-12 mt-4">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto fs-7 fw-bold">
                            Date:
                        </p>
                    </div>
                    <div class="col-8">
                        <input type="date" class="form-control">
                    </div>
                </div>
                <div class="d-flex col-12 mt-1">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto fs-7 fw-bold">
                            Handled by:
                        </p>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-between  p-4" style="background-color: #14245c;">

            <div class="col-4 my-2">
                <div class="d-flex">
                    <div class="col-4 my-auto">
                        <p for="v-model" class="my-auto fs-7 text-white text-end"><i class="bi bi-box text-warning"></i>
                            SO#:</p>
                    </div>
                    <div class="col-8 my-auto">
                        <p class="my-auto ms-2 text-white">{{ soNumbers }}</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="row my-4">
            <div class="col-lg-12 ">

                <div class="card  ">
                    <h5 class="">{{ orders[0].userid }}</h5>

                    <div class="card-body rounded-top table-responsive">

                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-hover mt-0 ">
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
                                <tr>
                                    <td colspan="14" style="height: 73px;"></td>
                                </tr>
                                <tr class="border fw-bold text-blue">
                                    <td colspan="14" style="border-top: 2px solid; border-bottom: 2px solid;">
                                        TOTAL
                                    </td>
                                </tr>
                                <tr class="border fw-bold text-blue">
                                    <td colspan="4"></td>
                                    <td>{{ totalctn }}</td>
                                    <td colspan="2">{{ totalQtys }}</td>
                                    <td colspan="2">{{ totalnw }}</td>
                                    <td colspan="4">{{ totalgw }}</td>
                                    <td>{{ totalVolumes }}</td>
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
            <div class="col-12 ">
                <h5 class="fw-bold px-4">
                    HERE I'M CONFIRMING THIS RECEIPT NOTE INFORMATION <br> ARE CERTIFIED AS STATED
                </h5>
                <img src="../../../../../public/imgs/non-english-content.png" alt="content" height="" />
            </div>
            <div class="col-8 mt-5">
                <div class="row">

                    <div class="col-8">
                        <div class="row">
                            <p class="fw-bold">
                                <span class="px-3">Recieved By:</span> <br>
                                <img src="../../../../../public/imgs/non-english-content.png" alt="content" />
                            </p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex col-12 mt-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7 fw-bold">
                                    Date:
                                </p>
                            </div>
                            <div class="col-8">
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container ">
        <button id="print-button" @click="printContent" class="btn btn-warning fw-bold px-4">Print</button>
    </div>

</template>

<script>
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';

export default {
    emits: ['profileUpdated'],
    data() {

        return {
            orders: {},
            soNumbers: this.$route.params.soNumbers || [],
        }
    },
    computed: {
        totalgw() {
            return this.orders.reduce(
                (total, item) => total + (parseFloat(item.packinglist?.totalgw) || 0),
                0
            );
        },
        totalVolumes() {
            return this.orders.reduce(
                (total, item) =>
                    total + (parseFloat(this.calculateVolume(item)) || 0),
                0
            );
        },
        totalnw() {
            return this.orders.reduce(
                (total, item) => total + (parseFloat(item.packinglist?.totalnw) || 0),
                0
            );
        },
        totalQtys() {
            return this.orders.reduce(
                (sum, item) =>
                    parseInt(sum) +
                    (parseFloat(item.packinglist?.totalqty) || 0),
                0
            );
        },
        totalctn() {
            console.log(this.orders);
            return this.orders.reduce(
                (sum, item) =>
                    parseInt(sum) +
                    (parseFloat(item.packinglist?.qty) || 0),
                0
            );
        },
    },
    methods: {
        printContent() {
            const doc = new jsPDF();

            const printContent = document.getElementById('print-container');

            html2canvas(printContent, { useCORS: true, scale: 1 }).then((canvas) => {
                const imgData = canvas.toDataURL('image/jpeg', 1); // use JPEG for better compression and set quality to 0.5

                const imgWidth = 190; // width of the image in PDF
                const pageWidth = doc.internal.pageSize.getWidth();
                const pageHeight = doc.internal.pageSize.getHeight();
                const imgHeight = (canvas.height * imgWidth) / canvas.width; // maintain aspect ratio

                let position = 10;

                // If the image height exceeds the page height, create a new page and adjust position
                if (imgHeight > pageHeight - 20) {
                    doc.addPage();
                    position = 10;
                }

                doc.addImage(imgData, 'JPEG', 10, position, imgWidth, imgHeight);

                doc.save('Receipt Note.pdf');
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
    },
    created() {
        const serializedData = this.$route.params.data;
        const data = JSON.parse(serializedData);
        this.orders = data;
        console.log(this.orders, this.soNumbers);

    },
}
</script>

<style lang="scss" scoped>
.printing {
    /* Hide unwanted content when printing */
    display: none;
}

@media print {

    /* Show only the print container and its children */
    body * {
        visibility: hidden;
    }

    #print-container,
    #print-container * {
        visibility: visible;
    }
}
</style>
