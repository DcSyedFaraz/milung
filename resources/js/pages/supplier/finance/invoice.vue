<template>
    <div class="container">
        <!-- Header -->
        <div class="row my-4">
            <div class="col text-center">
                <h1 class="text-capitalize">{{ user.company_header ?? 'not provided' }}</h1>
            </div>
        </div>

        <!-- Invoice Info -->
        <div class="row">
            <div class="col-8"></div>
            <div class="col-4">
                <div class="d-flex justify-content-between">
                    <div>Invoice No:</div>
                    <div class="border-bottom" style="width: 60%;">{{ invoices.invoice_number }}</div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <div>Date:</div>
                    <div class="border-bottom" style="width: 60%;">{{ date(invoices) }}</div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <div>Prepared By:</div>
                    <div class="border-bottom" style="width: 60%;">{{ invoices.user?.userid }}</div>
                </div>
            </div>
        </div>

        <!-- Commercial Invoice -->
        <div class="row my-4">
            <div class="col text-center">
                <h1 class="text-uppercase fw-bold text-decoration-underline"> Commercial Invoice </h1>
            </div>
        </div>

        <!-- Order Table -->
        <table class="table table-bordered">
            <thead class="">
                <tr>
                    <th scope="col">SO# Number</th>
                    <th scope="col">Order Number</th>
                    <th scope="col">Description</th>
                    <th scope="col">Quantity PCs or Set</th>
                    <th scope="col">Unit Price US$</th>
                    <th scope="col">Total Amount US$</th>
                </tr>
            </thead>
            <tbody class="">
                <tr v-for="(order, index) in invoices.orders" :key="index">
                    <td>{{ order.shipment_orders?.so_number }}</td>
                    <td>{{ order.id }}</td>
                    <td>{{ order.product_group?.group_name }}</td>
                    <td>{{ order.quantity_unit }} pcs</td>
                    <td>{{ order.buyingprice }}</td>
                    <td class="text-end">{{ order.quantity_unit * order.buyingprice }}</td>
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
                <p>INCOTERMS: {{ invoices.incoterm }}</p>
                <p>Total: <span class="text-uppercase">
                        {{ totalValueInWords }} Dollars
                    </span> </p>
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
                            <td> {{ user.bank ?? 'not provided'}} </td>
                        </tr>
                        <tr>
                            <td>Beneficiary Bank Address</td>
                            <td> {{ user.bank_address ?? 'not provided'}} </td>
                        </tr>
                        <tr>
                            <td>SWIFT Code</td>
                            <td> {{ user.swift_code ?? 'not provided'}} </td>
                        </tr>
                        <tr>
                            <td>CHIPS No</td>
                            <td> {{ user.chips_no ?? 'not provided'}} </td>
                        </tr>
                        <tr>
                            <td>Beneficiary Name</td>
                            <td> {{ user.beneficiary_name ?? 'not provided'}} </td>
                        </tr>
                        <tr>
                            <td>Beneficiary Account Number</td>
                            <td> {{ user.account_no ?? 'not provided'}} </td>
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
import { format } from 'date-fns';
import { parseISO } from 'date-fns';


export default {
    data() {
        return {
            invoices: {},
            user: {},
            orders: [
                // Example data, replace with your actual data
                { soNumber: "SO123", orderNumber: "OrderNumber1", description: "Paper Box", quantity: 250, unitPrice: 1.5, totalAmount: 375 },
                { soNumber: "SO124", orderNumber: "OrderNumber2", description: "USB Cable", quantity: 100, unitPrice: 2, totalAmount: 200 },
                // Add more orders as needed
            ]
        };
    },
    created() {
        this.invoice();
    },
    methods: {
        numberToWords(num) {
            const ones = [
                "",
                "one",
                "two",
                "three",
                "four",
                "five",
                "six",
                "seven",
                "eight",
                "nine",
            ];
            const teens = [
                "ten",
                "eleven",
                "twelve",
                "thirteen",
                "fourteen",
                "fifteen",
                "sixteen",
                "seventeen",
                "eighteen",
                "nineteen",
            ];
            const tens = [
                "",
                "",
                "twenty",
                "thirty",
                "forty",
                "fifty",
                "sixty",
                "seventy",
                "eighty",
                "ninety",
            ];
            const scales = ["", "thousand", "million", "billion", "trillion"];

            const convertToHundreds = (num) => {
                return num >= 100
                    ? `${ones[Math.floor(num / 100)]} hundred ${convertToTens(
                        num % 100
                    )}`
                    : convertToTens(num);
            };

            const convertToTens = (num) => {
                return num < 10
                    ? ones[num]
                    : num < 20
                        ? teens[num - 10]
                        : `${tens[Math.floor(num / 10)]} ${ones[num % 10]}`;
            };

            const numToWords = (num) => {
                if (num === 0) return "zero";
                let words = "";
                for (let i = 0; num > 0; i++) {
                    if (num % 1000 !== 0) {
                        words = `${convertToHundreds(num % 1000)} ${scales[i]
                            } ${words}`;
                    }
                    num = Math.floor(num / 1000);
                }
                return words.trim();
            };

            return numToWords(num);
        },
        date(recieve) {
            if (recieve.created_at) {
                // Parse the datetime string using date-fns
                const parsedDateTime = parseISO(recieve.created_at);
                // Format the parsed date using date-fns
                return format(parsedDateTime, 'dd-MM-yyyy');
            } else {
                return '';
            }
        },
        async invoice() {

            const invoiceID = this.$route.params.id;
            console.log(invoiceID);
            NProgress.start();

            await axios.get('/api/supplier/invoice/' + invoiceID)
                .then(response => {

                    this.invoices = response.data.inv;
                    this.user = response.data.user;
                    console.log(response.data);

                    NProgress.done();
                })
                .catch(error => {
                    NProgress.done();

                    console.error(error);
                });
        }
    },
    computed: {
        totalValueInWords() {
            return this.numberToWords(this.totalAmount);
        },
        totalQuantity() {
            if (Array.isArray(this.invoices.orders)) {
                return this.invoices.orders.reduce((total, order) => total + parseInt(order.quantity_unit), 0);
            } else {
                return 0;
            }
        },
        totalAmount() {
            if (Array.isArray(this.invoices.orders)) {
                return this.invoices.orders.reduce((total, order) => total + (order.quantity_unit * order.buyingprice), 0);
            } else {
                return 0;
            }
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
