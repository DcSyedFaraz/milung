<template>
    <div class="container">
        <!-- Header -->
        <div class="row my-4">
            <div class="col text-center">
                <h1>Supplier Company Header</h1>
            </div>
        </div>

        <!-- Invoice Info -->
        <div class="row">
            <div class="col-8"></div>
            <div class="col-4">
                <div class="d-flex justify-content-between">
                    <div>Invoice No:</div>
                    <div class="border-bottom" style="width: 60%;"></div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <div>Date:</div>
                    <div class="border-bottom" style="width: 60%;"></div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <div>Prepared By:</div>
                    <div class="border-bottom" style="width: 60%;"></div>
                </div>
            </div>
        </div>

        <!-- Commercial Invoice -->
        <div class="row my-4">
            <div class="col text-center">
                <h2>Commercial Invoice</h2>
            </div>
        </div>

        <!-- Order Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">SO# Number</th>
                    <th scope="col">Order Number</th>
                    <th scope="col">Description</th>
                    <th scope="col">Quantity PCs or Set</th>
                    <th scope="col">Unit Price US$</th>
                    <th scope="col">Total Amount US$</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(order, index) in orders" :key="index">
                    <td>{{ order.soNumber }}</td>
                    <td>{{ order.orderNumber }}</td>
                    <td>{{ order.description }}</td>
                    <td>{{ order.quantity }}</td>
                    <td>{{ order.unitPrice }}</td>
                    <td>{{ order.totalAmount }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total:</th>
                    <th>{{ totalQuantity }} pcs</th>
                    <th colspan="2" class="text-end">US$ {{ totalAmount.toFixed(2) }}</th>
                </tr>
            </tfoot>
        </table>

        <!-- Bank Details -->
        <div class="row my-4">
            <div class="col">
                <p>INCOTERMS: Ex Work</p>
                <p>Total: Say total US DOLLAR</p>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="2">Bank Details:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Beneficiary Bank</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Beneficiary Bank Address</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>SWIFT Code</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>CHIPS No</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Beneficiary Name</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Beneficiary Account Number</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-6"></div>
        </div>
    </div>
</template>

<script>
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';

export default {
    data() {
        return {
            invoices: {},
            orders: [
                // Example data, replace with your actual data
                { soNumber: "SO123", orderNumber: "OrderNumber1", description: "Paper Box", quantity: 250, unitPrice: 1.5, totalAmount: 375 },
                { soNumber: "SO124", orderNumber: "OrderNumber2", description: "USB Cable", quantity: 100, unitPrice: 2, totalAmount: 200 },
                // Add more orders as needed
            ]
        };
    },
    mounted() {
        this.invoice();
    },
    methods: {
        async invoice() {
            const invoiceID = this.$route.params.id;
            console.log(invoiceID);
            NProgress.start();

            await axios.get('/api/supplier/invoice/' + invoiceID)
                .then(response => {

                    this.invoices = response.data;
                    console.log(this.invoices);

                    NProgress.done();
                })
                .catch(error => {
                    NProgress.done();

                    console.error(error);
                });
        }
    },
    computed: {
        totalQuantity() {
            return this.orders.reduce((total, order) => total + order.quantity, 0);
        },
        totalAmount() {
            return this.orders.reduce((total, order) => total + order.totalAmount, 0);
        }
    }
};
</script>

<style scoped>
h1 {
    font-size: 24px;
    font-weight: bold;
}

h2 {
    font-size: 20px;
    font-weight: bold;
}

.table-bordered {
    border: 1px solid #000;
}

.table-bordered th,
.table-bordered td {
    border: 1px solid #000;
}

.border-bottom {
    border-bottom: 1px solid #000;
}
</style>
