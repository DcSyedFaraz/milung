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
                    <div class="col-5 text-white py-3 rounded-3" style="background-color: #14245c;" >
                        <div class="col-12 text-uppercase mb-5">
                            item sales ravenue:
                        </div>
                        <div class="col-12">
                            <div class="row text-center my-3 ">

                                <div class="col-6 border-end border-2"><span class="fw-bold fs-4 ">US${{sales}}</span> <br>Amount</div>
                                <div class="col-6"><span class="fw-bold fs-4">XXXpcs</span> <br>Quantity</div>
                            </div>
                        </div>
                        <div class="col-12 mt-5">Average Unit Sales Amount: <span class="fw-bold">US$xxx</span></div>
                    </div>
                    <div class="col-5 text-white py-3 rounded-3 " style="background-color: #009de1;" >
                        <div class="col-12 text-uppercase mb-5">
                            item purchase ravenue:
                        </div>
                        <div class="col-12">
                            <div class="row text-center my-3">

                                <div class="col-6 border-end border-2"><span class="fw-bold fs-4 ">US${{purchase}}</span> <br>Amount</div>
                                <div class="col-6"><span class="fw-bold fs-4">XXXpcs</span> <br>Quantity</div>
                            </div>
                        </div>
                        <div class="col-12 mt-5">Average Unit Sales Amount: <span class="fw-bold">US$xxx</span></div>
                    </div>
                </div>
            </div>
        </div>
        <apexchart
            type="line"
            height="350"
            :options="options"
            :series="series"
        ></apexchart>
    </div>
</template>

<script>
import NProgress from "nprogress";
import "nprogress/nprogress.css";

export default {
    data() {
        return {
            selected: {},
            sales: '',
            purchase: '',
            selectedDateRange: null,
            buyers: [],
            supplier: [],
            product: [],
            options: {
                xaxis: {
                    categories: [
                        1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998,
                    ],
                },
            },
            series: [
                {
                    name: "series-1",
                    data: [30, 40, 45, 50, 49, 60, 70, 91],
                },
            ],
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

        sendFilterData() {
            let formData = {
                buyerid: this.selected.BuyerId?.id,
                supplierid: this.selected.SupplierId?.id,
                productgroup: this.selected.productgroup?.id,
            };
            // console.log(this.selectedDateRange[1]);
            // If selectedDateRange is an array (range is selected)
            if (
                Array.isArray(this.selectedDateRange) &&
                this.selectedDateRange.length === 2
            ) {
                if (this.selectedDateRange && !this.selectedDateRange[1]) {
                    // Show Toastr notification
                    toastr.error("Please select an end date.");
                    return;
                }
                const formatDate = (date) => {
                    const day = date.getDate();
                    const month = (date.getMonth() + 1)
                        .toString()
                        .padStart(2, "0");
                    const year = date.getFullYear();
                    return `${day}-${month}-${year}`;
                };

                const [startDate, endDate] =
                    this.selectedDateRange.map(formatDate);
                formData.date = { startDate, endDate };
            }

            // Here, you can send the filter data to your API
            console.log("Sending filter data to API:", formData);
            // Example of sending data using Axios
            axios
                .post("/api/statfilter", formData)
                .then((response) => {
                    if(response.data.buyers){
                        this.sales = response.data.buyers;
                    }
                    if(response.data.supplier){
                        this.purchase = response.data.supplier;
                    }
                    console.log(response.data);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    created() {
        this.fetchFilter().then(() => {
            setTimeout(() => {}, 1000); // Delay of 1 second
        });
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
