<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="text-milung">For Milung:</p>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-3">
                        <multiselect
                            placeholder="Buyer ID"
                            v-model="selected.BuyerId"
                            :options="buyers"
                            field="id"
                            label="userid"
                            track-by="id"
                        >
                        </multiselect>
                    </div>
                    <div class="col-3">
                        <multiselect
                            placeholder="Supplier ID"
                            v-model="selected.SupplierId"
                            :options="supplier"
                            field="id"
                            label="userid"
                            track-by="id"
                        >
                        </multiselect>
                    </div>
                    <div class="col-3">
                        <multiselect
                            placeholder="Product Group"
                            v-model="selected.productgroup"
                            :options="product"
                            field="id"
                            label="group_name"
                            track-by="id"
                        >
                        </multiselect>
                    </div>
                    <div class="col-3">
                        <VueDatePicker
                            v-model="selectedDateRange"
                            :range="true"
                            :input-class="['date-picker-input']"
                            start-placeholder="Start Date"
                            placeholder="Date range"
                            input-class-name="dp-custom-input"
                            format="dd-MM-yyyy"
                        ></VueDatePicker>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row my-5 justify-content-around">
                    <div
                        class="col-5 text-white py-3 rounded-3"
                        style="background-color: #14245c"
                    >
                        <div class="col-12 text-uppercase mb-5">
                            item sales ravenue:
                        </div>
                        <div class="col-12">
                            <div class="row text-center my-3">
                                <div class="col-6 border-end border-2">
                                    <span class="fw-bold fs-4"
                                        >US${{ sales.price }}</span
                                    >
                                    <br />Amount
                                </div>
                                <div class="col-6">
                                    <span class="fw-bold fs-4"
                                        >{{ sales.qty }}pcs</span
                                    >
                                    <br />Quantity
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-5">
                            Average Unit Sales Amount:
                            <span class="fw-bold">US$xxx</span>
                        </div>
                    </div>
                    <div
                        class="col-5 text-white py-3 rounded-3"
                        style="background-color: #009de1"
                    >
                        <div class="col-12 text-uppercase mb-5">
                            item purchase ravenue:
                        </div>
                        <div class="col-12">
                            <div class="row text-center my-3">
                                <div class="col-6 border-end border-2">
                                    <span class="fw-bold fs-4"
                                        >US${{ purchase.price }}</span
                                    >
                                    <br />Amount
                                </div>
                                <div class="col-6">
                                    <span class="fw-bold fs-4"
                                        >{{ purchase.qty }}pcs</span
                                    >
                                    <br />Quantity
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-5">
                            Average Unit Sales Amount:
                            <span class="fw-bold">US$xxx</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 border rounded-2">
                <p class="text-blue fw-bold">
                    Top Product Group By Quantity in Date Range / Supplier /
                    Buyer
                </p>
                <apexchart
                    type="pie"
                    :options="chartOptions"
                    :series="chartSeries"
                ></apexchart>
            </div>
            <div class="col-6 border rounded-2">
                <p class="text-blue fw-bold">
                    Top Product Group By Ravenue in Date Range / Supplier /
                    Buyer
                </p>
                <apexchart
                    type="bar"
                    :options="barChartOptions"
                    :series="barChartSeries"
                ></apexchart>
            </div>
        </div>
    </div>
</template>

<script>
import NProgress from "nprogress";
import "nprogress/nprogress.css";

export default {
    data() {
        return {
            selected: {},
            sales: [],
            purchase: [],
            selectedDateRange: null,
            buyers: [],
            supplier: [],
            product: [],
            barChartOptions: {
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        dataLabels: {
                            position: "top", // top, center, bottom
                        },
                    },
                },
                labels: [],
                chart: {
                    type: "bar",
                    height: 350,
                },
                xaxis: {
                    categories: [], // Categories will be dynamically populated
                },
            },
            barChartSeries: [
                {
                    name: "Total Quantity",
                    data: [], // Data will be dynamically populated
                },
            ],
            chartOptions: {
                chart: {
                    type: "pie",
                },
                labels: [], // Labels will be dynamically populated
            },
            chartSeries: [],
        };
    },
    watch: {
        selected: {
            handler(newValue) {
                this.sendFilterData(newValue);
            },
            deep: true,
        },
        selectedDateRange(newValue) {
            this.sendFilterData(newValue);
        },
    },
    methods: {
        async fetchFilter() {
            NProgress.start();
            try {
                const response = await axios.get("/api/statfilter");
                this.buyers = response.data.buyers;
                this.supplier = response.data.supplier;
                this.product = response.data.product;
                console.log(response.data);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error("Error fetching filters:", error);
                toastr.error("Error fetching data");
            }
        },
        formatBarData(productData) {
            const labels = [];
            const values = [];
            productData.forEach((product) => {
                labels.push(product.group_name);
                values.push(product.total_quantity);
            });
            // this.barChartOptions.xaxis.categories = labels;
            this.barChartOptions.xaxis.categories.splice(
                0,
                this.barChartOptions.xaxis.categories.length,
                ...labels
            );
            this.barChartSeries = [
                {
                    name: "Total Ravenue(USD)",
                    data: values,
                },
            ];
            if (productData.length === 1) {
                this.barChartSeries[0].data.push(0); // Add a placeholder value for the single record
            }
        },
        formatChartData(productData) {
            // Initialize arrays to store labels and values
            const label = [];
            const values = [];

            // Extract labels and values from product data
            productData.forEach((product) => {
                label.push(product.group_name);
                values.push(product.total_quantity);
            });
            this.chartOptions.labels.splice(
                0,
                this.chartOptions.labels.length,
                ...label
            );
            // Update chartOptions and chartSeries with formatted data
            // this.chartOptions.labels = label;
            this.chartSeries = values;
            // console.log("hi ", this.chartOptions, this.chartSeries);
        },

        async sendFilterData() {
            let formData = {
                buyerid: this.selected.BuyerId?.id,
                supplierid: this.selected.SupplierId?.id,
                productgroup: this.selected.productgroup?.id,
            };

            if (
                Array.isArray(this.selectedDateRange) &&
                this.selectedDateRange.length === 2
            ) {
                if (this.selectedDateRange && !this.selectedDateRange[1]) {
                    toastr.error("Please select an end date.");
                    return;
                }

                const formatDate = (date) => {
                    const year = date.getFullYear();
                    const month = (date.getMonth() + 1)
                        .toString()
                        .padStart(2, "0");
                    const day = date.getDate().toString().padStart(2, "0");
                    const hours = date.getHours().toString().padStart(2, "0");
                    const minutes = date
                        .getMinutes()
                        .toString()
                        .padStart(2, "0");
                    const seconds = date
                        .getSeconds()
                        .toString()
                        .padStart(2, "0");
                    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                };

                const [startDate, endDate] =
                    this.selectedDateRange.map(formatDate);
                formData.date = { startDate, endDate };
            }

            console.log("Sending filter data to API:", formData);

            try {
                const response = await axios.post("/api/statfilter", formData);
                this.sales.price = response.data.buyers || "xxx";
                this.purchase.price = response.data.supplier || "xxx";
                this.sales.qty = response.data.buyersqty || "xxx";
                this.purchase.qty = response.data.supplierqty || "xxx";
                if (response.data.product) {
                    const productData = response.data.product;
                    this.formatChartData(productData);
                }
                if (response.data.productvalue) {
                    const productValueData = response.data.productvalue;
                    this.formatBarData(productValueData);
                }
                console.log('data',response.data);
            } catch (error) {
                console.log(error);
                toastr.error('Error Fetching  Data, Contact to developer');
            }
        },
    },
    created() {
        this.fetchFilter().then(() => {
            setTimeout(() => {}, 1000); // Delay of 1 second
        });
        this.sendFilterData();
    },
};
</script>

<style lang="scss">
.dp-custom-input {
    height: 46px !important;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}
</style>
