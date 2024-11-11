<template>
    <div class="" id="invoice-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-milung fw-bold text-center">
                        MiLung Trade Limited
                    </h1>
                    <p class="text-center text-milung fw-bold my-3">
                        Unit 1704-05, 17/F. Hang Seng North Point Building,<br />
                        341 North Point, Hong Kong. <br />
                        Tel: 852 2540 2488
                    </p>
                </div>
                <div class="col-12">
                    <div class="row mx-6 mt-4">
                        <div class="col mx-1 border rounded-3 rounded bg-milung">
                            <div class="text-center p-3">
                                <p class="fw-bold">
                                    Invoice No: <br />
                                    {{ info.invoice ?? "---" }}
                                </p>
                            </div>
                        </div>
                        <div class="col mx-1 border rounded-3 rounded bg-blue">
                            <div class="text-center p-3">
                                <p class="fw-bold">
                                    Cust Ref. (ATC): <br />
                                    {{ atc ?? "---" }}
                                </p>
                            </div>
                        </div>
                        <div class="col mx-1 border rounded-3 rounded bg-warning">
                            <div class="text-center p-3">
                                <p class="fw-bold">
                                    Date: <br />
                                    {{ created_at(info) ?? "---" }}
                                </p>
                            </div>
                        </div>
                        <div class="col mx-1 border rounded-3 rounded bg-orange">
                            <div class="text-center p-3">
                                <p class="fw-bold">
                                    Prepred By: <br />
                                    {{ info.user?.userid ?? "---" }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-5">
                    <form>
                        <div class="row mb-4">
                            <div class="col-6">
                                <div class="d-flex col-11 my-2">
                                    <div class="">
                                        <label
                                            class="form-label text-milung fw-bold text-uppercase fs-5">Shipper:</label>
                                        <p class="mb-6">{{ info.shipper }}</p>
                                        <!-- <textarea v-model="info.shipper" class="form-control" cols="58" rows="6"></textarea> -->
                                    </div>
                                </div>
                                <div class="d-flex col-11 my-2">
                                    <div class="">
                                        <label
                                            class="form-label text-milung fw-bold text-uppercase fs-5">consignee:</label>
                                        <p class="mb-6">{{ info.consignee }}</p>
                                    </div>
                                </div>
                                <div class="col-11 my-2">
                                    <div class="">
                                        <label class="form-label text-milung fw-bold text-uppercase fs-5">notify
                                            party:</label>
                                        <p class="">{{ info.party }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex col-11 my-2">
                                    <div class="">
                                        <label class="form-label text-milung fw-bold text-uppercase fs-5">carton
                                            mark:</label>
                                        <p class="mb-6">{{ info.carton }}</p>
                                    </div>
                                </div>
                                <div class="col-11 my-4">
                                    <div class="">
                                        <label class="form-label text-milung fw-bold text-uppercase fs-5">port of
                                            loading:</label>
                                        <p class="">{{ info.loading }}</p>
                                    </div>
                                </div>
                                <div class="col-11 my-3">
                                    <div class="">
                                        <label class="form-label text-milung fw-bold text-uppercase fs-5">final
                                            destination:</label>
                                        <p class="">{{ info.destination }}</p>
                                    </div>
                                </div>
                                <div class="col-11 my-2">
                                    <div class="">
                                        <label
                                            class="form-label text-milung fw-bold text-uppercase fs-5">payment:</label>
                                        <p class="">{{ info.payment }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container p-4" style="background-color: #14245c">
            <div class="row justify-content-between">
                <div class="col-3 my-2">
                    <div class="d-flex">
                        <div class="col-4 my-auto">
                            <p for="v-model" class="my-auto fs-7 text-white">
                                <i class="bi bi-box text-warning"></i> SO#:
                            </p>
                        </div>
                        <div class="col-8">
                            <input type="text" v-model="info.shipment_order_id" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container my-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class=""></div>
                            <div class="d-flex justify-content-between align-items-center mx-3">
                                <span>
                                    <span class="fw-bold fs-4 text-uppercase" style="color: #14245c">Comercial
                                        Invoice:</span>
                                </span>

                                <div class="col-4 d-flex">
                                    <div class="col-12 d-flex">
                                        <div class="col-12">
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        style="color: #41b400"
                                                        class="bx bx-filter-alt fw-bold fs-4"></i></span>
                                                <input type="text" name="search" class="form-control"
                                                    v-model="searchQuery" ref="search"
                                                    placeholder="Write here to filter..." />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body rounded-top table-responsive border-top border-bottom">
                            <!-- Table with stripped rows -->
                            <table class="table table-striped table-hover">
                                <thead style="color: #009de1" class="text-center fs-7">
                                    <tr style="">
                                        <th class="text-nowrap">Order No.</th>
                                        <th class="text-nowrap">Description</th>
                                        <th class="text-nowrap">
                                            <span>Quantity</span> <br />
                                            <span class="text-milung">Pcs or set</span>
                                        </th>
                                        <th class="text-nowrap">
                                            Unit Price US$
                                        </th>
                                        <th class="text-nowrap">
                                            Total Amount US$
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr v-for="(item, index) in packinglst" :key="index" v-if="packinglst.length > 0">
                                        <td>
                                            {{ item.order_id }}
                                        </td>
                                        <td>
                                            {{
                                                item.orders?.product_group
                                                    ?.group_name
                                            }}
                                        </td>
                                        <td>
                                            {{ item.orders?.quantity_unit }}
                                        </td>
                                        <td>
                                            US$ {{ item.orders?.sellingprice }}
                                        </td>
                                        <td>
                                            US$ {{ item.orders?.totalvalue }}
                                        </td>
                                    </tr>
                                    <tr v-else>
                                        <td colspan="17">
                                            <p class="text-center">
                                                No data to display.
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                                <span>
                                    <table class="table table-striped table-hover w-25">
                                        <thead style="color: #009de1" class="text-center fs-7">
                                            <tr style="">
                                                <th class="text-nowrap">
                                                    HS Code.
                                                </th>
                                                <th class="text-nowrap">
                                                    Description
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in packinglst" class="text-center">
                                                <td>
                                                    {{
                                                        item.orders
                                                            ?.product_group
                                                            ?.hs_de
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                        item.orders
                                                            ?.product_group
                                                            ?.group_name
                                                    }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </span>
                                <tbody class="w-full border-top border-3">
                                    <tr class="fw-bold">
                                        <td class="text-blue" colspan="2" style="color: #009de1">
                                            Total:
                                        </td>
                                        <td class="text-blue" colspan="2" style="color: #009de1">
                                            <span class="ms-5">{{
                                                totalQtys
                                                }}</span>
                                        </td>
                                        <td class="text-blue" colspan="2" style="color: #009de1">
                                            <span class="text-center ms-5">US$ {{ totalvalue }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card mt-3">
                            <div class="">
                                <div class="d-flex col-4 my-2">
                                    <div class="col-5 my-auto">
                                        <p for="v-model" class="my-auto fs-6 text-uppercase fw-bold">
                                            Incoterms:
                                        </p>
                                    </div>
                                    <div class="col-7">
                                        <input type="text" v-model="blue.incoterm" class="form-control" />
                                    </div>
                                </div>
                                <div class="d-flex col-6 my-2">
                                    <div class="col-3 my-auto">
                                        <p for="v-model" class="my-auto fs-6 fw-bold">
                                            Total in words:
                                        </p>
                                    </div>
                                    <div class="col-7 fs-7 text-uppercase">
                                        <p class="my-auto">
                                            {{ totalValueInWords }} Dollars
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex col-6 mt-4">
                                    <h3 class="text-milung fw-bold">
                                        Payment By Telegraphic Transfer:
                                    </h3>
                                </div>
                                <div class="d-flex col-6 mb-5">
                                    <table class="table table-striped table-hover">
                                        <thead style="color: #009de1" class="text-center fs-7">
                                            <tr style="">
                                                <th class="text-nowrap">
                                                    Item
                                                </th>
                                                <th class="text-nowrap">
                                                    Information
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <td class="fw-bolder">
                                                    Beneficiary Bank
                                                </td>
                                                <td>Hang Seng Bank Limited</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td class="fw-bolder">
                                                    Beneficiary Bank Address
                                                </td>
                                                <td>
                                                    83 Des Voeux Road Central.
                                                    Hong Kong
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <td class="fw-bolder">
                                                    SWIFT Code
                                                </td>
                                                <td>HASEHKHH</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td class="fw-bolder">
                                                    CHIPS No
                                                </td>
                                                <td>10522</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td class="fw-bolder">
                                                    Beneficiary Name
                                                </td>
                                                <td>MILUNG TRADE LTD.</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td class="fw-bolder">
                                                    Beneficiary Account Number
                                                </td>
                                                <td>787-646660-883</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="col-12 d-flex justify-content-end">
            <div class="col-2 align-items-end">
                <button class="btn btn-milung px-5" @click="generatePdf">
                    Export
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { format } from "date-fns";
import { parseISO } from "date-fns";
import NProgress from "nprogress";
import "nprogress/nprogress.css";
import jsPDF from "jspdf";
import html2canvas from "html2canvas";

export default {
    emits: ['profileUpdated'],
    data() {
        return {
            info: {},
            blue: {},
            packinglst: [],
            searchQuery: "",
            atc: "",
            submitting: false,
        };
    },
    computed: {
        totalQtys() {
            return this.packinglst.reduce(
                (sum, item) =>
                    parseInt(sum) +
                    (parseFloat(item.orders?.quantity_unit) || 0),
                0
            );
        },
        totalvalue() {
            return this.packinglst.reduce(
                (sum, item) =>
                    parseInt(sum) + (parseFloat(item.orders?.totalvalue) || 0),
                0
            );
        },
        totalValueInWords() {
            return this.numberToWords(this.totalvalue);
        },
    },
    methods: {
        generatePdf() {
            NProgress.start();
            const pdfName = "CIBD.pdf";
            // Specify custom dimensions for the page (width, height)
            const pdf = new jsPDF("p", "mm", [210, 297]); // A4 size is [210, 297] mm

            const source = document.getElementById("invoice-content");

            html2canvas(source)
                .then((canvas) => {
                    const imgData = canvas.toDataURL("image/png");
                    const imgWidth = pdf.internal.pageSize.getWidth() - 20;
                    const imgHeight = (imgWidth * canvas.height) / canvas.width;

                    pdf.addImage(imgData, "PNG", 10, 10, imgWidth, imgHeight);

                    // Save the PDF temporarily
                    const tempPdfName = "CIBD.pdf";
                    pdf.save(tempPdfName);

                    // Remove the first page from the temporary PDF
                    const pdfDoc = new jsPDF();
                    const tempPdf = new jsPDF();
                    tempPdf.loadFile(tempPdfName, () => {
                        for (
                            let i = 2;
                            i <= tempPdf.internal.getNumberOfPages();
                            i++
                        ) {
                            pdfDoc.addPage(tempPdf.getPage(i));
                        }
                        pdfDoc.save(pdfName);

                        // Clean up - delete the temporary PDF
                        setTimeout(() => {
                            tempPdf.deleteFile(tempPdfName);
                        }, 100);
                    });

                    NProgress.done();
                })
                .catch((error) => {
                    NProgress.done();
                    console.error("Error generating PDF:", error);
                });
        },

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
                if (num === 0) return "";
                return num >= 100
                    ? `${ones[Math.floor(num / 100)]} hundred ${convertToTens(num % 100)}`
                    : convertToTens(num);
            };

            const convertToTens = (num) => {
                const tensIndex = Math.floor(num / 10);
                const onesIndex = Math.floor(num % 10);
                return num < 10
                    ? ones[num]
                    : num < 20
                        ? teens[num - 10]
                        : `${tens[tensIndex]} ${ones[onesIndex]}`;
            };

            const numToWords = (num) => {
                if (num === 0) return "zero";
                let words = "";
                let scaleIndex = 0;

                while (num > 0) {
                    const chunk = num % 1000;
                    if (chunk !== 0) {
                        words = `${convertToHundreds(chunk)} ${scales[scaleIndex]} ${words}`;
                    }
                    num = Math.floor(num / 1000);
                    scaleIndex++;
                }

                return words.trim();
            };

            // Ensure the number has exactly two decimal places
            const [integerPartStr, fractionalPartStr] = Number(num).toFixed(2).split(".");

            const integerPart = parseInt(integerPartStr, 10);
            const fractionalPart = parseInt(fractionalPartStr, 10);

            let words = numToWords(integerPart);

            if (fractionalPart > 0) {
                words += ` and ${numToWords(fractionalPart)} cents`;
            }

            return words;
        },
        created_at(info) {
            if (info.created_at) {
                // Parse the datetime string using date-fns
                const parsedDateTime = parseISO(info.created_at);
                // Format the parsed date using date-fns
                return format(parsedDateTime, "dd-MM-yyyy");
            } else {
                return "---";
            }
        },

        handleValidationErrors(validationErrors) {
            // Assuming you have a function to display toastr error messages
            for (const key in validationErrors) {
                if (validationErrors.hasOwnProperty(key)) {
                    const messages = validationErrors[key];
                    // Display each validation error message
                    messages.forEach((message) => {
                        toastr.error(message);
                    });
                }
            }
        },
        async fetchSO() {
            const soId = this.$route.params.id;
            NProgress.start();
            try {
                const response = await axios.get("/api/shipmentget/" + soId);
                this.packinglst = response.data.packing;
                this.atc = response.data.data?.atc_no;
                this.blue.incoterm = response.data.shipment.incoterm;
                // this.pagination.totalItems = response.data.total;
                console.log(response.data);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error("Error fetching shipment:", error);
                toastr.error("Error fetching data");
            }
        },
        async fetchInfo() {
            const soId = this.$route.params.id;
            console.log(soId);

            NProgress.start();
            try {
                const response = await axios.get("/api/information/" + soId);
                this.info = response.data;
                this.info.shipment_order_id = this.$route.params.so_number;
                // this.pagination.totalItems = response.data.total;
                console.log(response.data);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error("Error fetching shipment:", error);
                toastr.error("Error fetching data");
            }
        },
    },
    mounted() {
        this.fetchSO();
        this.fetchInfo();
    },
};
</script>

<style scoped>
.mb-6 {
    margin-bottom: 2rem !important;
    height: 6rem !important;
    max-width: 10rem !important;
}

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
