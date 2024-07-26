<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">

                                <div class="d-flex col-11 my-4">
                                    <div class="col-3 my-auto">
                                        <p class="fw-bold text-milung text-uppercase my-auto">
                                            id#:
                                        </p>
                                    </div>
                                    <div class="col-7">
                                        <!-- <input type="text" v-model="so.buyerid" class="form-control"> -->
                                        <multiselect v-model="selectedUserId" :options="users" label="buyer_id"
                                            track-by="id">
                                        </multiselect>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="d-flex justify-content-between align-items-center mx-3">
                            <span>
                                <span class="fw-bold fs-4 text-uppercase" style="color: #14245c">Outstanding payment
                                    order list:</span>
                            </span>
                        </div> -->
                    </div>

                    <!-- // Loader -->
                    <div class="card-body rounded-top" v-if="isLoading">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border text-warning" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <!-- // Loader -->
                    <div class="card-body border-bottom border-3 rounded-top table-responsive" v-else>
                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-hover">
                            <thead style="color: #009de1" class="text-center">
                                <tr style="">
                                    <th class="text-nowrap">POS</th>
                                    <th class="text-nowrap">Invoice Number</th>
                                    <th class="text-nowrap">
                                        Invoice Value
                                    </th>
                                    <th class="text-nowrap">
                                        Shipping Date
                                    </th>
                                    <th class="text-nowrap">Shipping Method</th>
                                    <th class="text-nowrap">ETA Date</th>
                                    <th class="text-nowrap">Payment Settled</th>
                                    <th class="text-nowrap">Payment Settled Date</th>
                                    <th class="text-nowrap">Outstanding Balance</th>
                                    <th class="text-nowrap">Buyer Remittance Slip</th>
                                    <th class="text-nowrap">MiLung Remittance Slip</th>
                                    <th class="text-nowrap">Remarks</th>
                                    <th class="text-nowrap">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                <tr v-for="(item, index) in invoices" :key="index - 1" v-if="invoices.length > 0">
                                    <td>
                                        {{ item.id }}
                                    </td>
                                    <td>{{ item.information?.invoice }}</td>
                                    <td>{{ item.information?.totalpayable }}</td>
                                    <td>
                                        {{ item.shipment?.ship_date }}
                                    </td>
                                    <td>{{ item.method }}</td>
                                    <td class="text-nowrap"> {{ item.shipment?.delivery }}</td>

                                    <td><input v-if="item.editable" v-model="settle_amount" type="number"
                                            class="form-control">
                                        <span v-else>USD {{ item.settleamount?.settle_amount ?? 0 }}</span>
                                    </td>
                                    <td>{{ item.settleamount?.settle_date ?? 'Not settled yet'}}</td>

                                    <td :class="{ 'text-danger': item.settleamount?.outstanding_amount > 0 }">
                                        <span v-if="item.settleamount?.outstanding_amount"
                                            :contenteditable="item.editable">

                                            USD {{ item.settleamount?.outstanding_amount }}
                                        </span>
                                        <span v-else class="text-danger">
                                           USD {{ item.information?.totalpayable }}

                                        </span>
                                    </td>
                                    <td>
                                        <a v-if="item.settleamount?.slip" :href="'/storage/' +
                                            item.settleamount?.slip" download
                                            class="btn px-4 mx-2 btn-outline-primary  ">
                                            <i class="bi bi-file-earmark-text fw-bold"></i>
                                        </a>
                                        <p v-else class="fst-italic text-muted">
                                            Not provided
                                        </p>
                                    </td>
                                    <td>
                                        <a v-if="item.settleamount?.admin_slip" :href="'/storage/' +
                                            item.settleamount?.admin_slip" download
                                            class="btn px-4 mx-2 btn-outline-primary  ">
                                            <i class="bi bi-file-earmark-text fw-bold"></i>
                                        </a>
                                        <span v-else>
                                            <button @click="importImage(index)" type="button"
                                                class="btn btn-sm px-4 btn-outline-primary">
                                                Upload
                                            </button>
                                            <!-- <button>submit</button> -->
                                        </span>
                                        <input :key="index" :ref="'fileInput'" :data-index="index" type="file"
                                            class="form-control d-none" accept=".jpg,.png">
                                    </td>
                                    <td>
                                        <input type="text" v-model="remarks[item.id]" class="form-control">
                                    </td>
                                    <td>
                                        <template v-if="!item.editable">
                                            <button @click="toggleEditMode(index)"
                                                class="btn btn-light text-success btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button @click="saveItem(index)" class="btn btn-light text-danger btn-sm">
                                                <i class="bi bi-save2"></i>
                                            </button>
                                        </template>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td colspan="17">
                                        <p class="text-center">
                                            No invoices to display.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body mt-5" v-show="!isLoading">
                        <div class="row">
                            <div class="col-md-6">
                                <span class="fw-bold fs-6 text-uppercase" style="color: #14245c">General Outstanding
                                    account
                                    Recievable:</span>

                                <!-- Table with stripped rows -->
                                <table class="table table-striped table-hover">
                                    <thead style="color: #009de1" class="text-center">
                                        <tr style="">
                                            <th class="text-nowrap">Buyer ID</th>
                                            <th class="text-nowrap">
                                                Outstanding Amount
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr v-for="(item, index) in remaining" :key="index" v-if="remaining.length > 0">
                                            <td>{{ item.buyer_id }}</td>
                                            <td>USD {{ item.total_outstanding_per_buyer }}</td>
                                        </tr>
                                        <tr v-else>
                                            <td colspan="17">
                                                <p class="text-center">
                                                    No data to display.
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <td style="color: #009de1">
                                                Total:
                                            </td>
                                            <td style="color: #009de1">
                                                USD {{ totalOutstanding }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <span class="fw-bold fs-6 text-uppercase" style="color: #14245c"> Annual Sales
                                    Revenue:</span>

                                <!-- Table with stripped rows -->
                                <table class="table table-striped table-hover">
                                    <thead style="color: #009de1" class="text-center">
                                        <tr style="">
                                            <th class="text-nowrap">Buyer ID</th>
                                            <th class="text-nowrap">
                                                Total Sales
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr v-for="(item, index) in sales" :key="index" v-if="sales.length > 0">
                                            <td>{{ item.buyer_id }}</td>
                                            <td>USD {{ item.total_payable_per_buyer }}</td>
                                        </tr>
                                        <tr v-else>
                                            <td colspan="17">
                                                <p class="text-center">
                                                    No data to display.
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <td style="color: #009de1">
                                                Total:
                                            </td>
                                            <td style="color: #009de1">
                                                USD {{ totalSales }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</template>

<script>
import NProgress from "nprogress";
import "nprogress/nprogress.css";
import { format } from "date-fns";
import { parseISO } from "date-fns";
import axios from "axios";
export default {
    data() {


        return {
            isLoading: true,
            selectedUserId: "",
            invoices: [],
            remaining: [],
            sales: [],
            users: [],
            remarks: {},
            settle_amount: '',
            fileInputs: [],
            totalSales: 0,
            totalOutstanding: 0,
        }
    },
    watch: {
        selectedUserId(newVal) {
            if (newVal) {
                console.log('new', newVal);
                this.fetchInvoices(newVal.id);
            }
        },
        sales(newVal) {
            this.totalSales = newVal.reduce((acc, curr) => curr.total_payable_per_buyer, 0);
        },
        remaining(newVal) {
            this.totalOutstanding = newVal.reduce((acc, curr) => acc + curr.total_outstanding_per_buyer, 0);
        },
    },
    created() {
        this.fetchUsers().then(() => {
            setTimeout(() => {
                this.isLoading = false;
            }, 1000); // Delay of 1 second
        });
    },
    methods: {
        importImage(index) {
            const fileInput = this.$refs['fileInput'][index];
            console.log(this.$refs['fileInput'], index);
            if (fileInput) {
                fileInput.click();
            } else {
                console.error('Invalid index:', index);
            }
        },
        toggleEditMode(index) {
            this.invoices[index].editable = true;
        },
        saveItem(index) {
            const updatedItem = this.invoices[index];
            const remarks = this.remarks[updatedItem.id];
            const fileInput = this.$refs['fileInput'][index];
            console.log('file ', updatedItem.buyerid);


            if (!this.settle_amount && !remarks && !fileInput.files && fileInput.files.length === 0) {
                toastr.error("Please fill in all fields.");
                return;
            }

            const formData = new FormData();
            if (this.settle_amount) {
                formData.append('settle_amount', this.settle_amount);
            }
            if (remarks != undefined) {
                formData.append('remarks', remarks);
            }
            if (fileInput.files.length > 0) {
                formData.append('image', fileInput.files[0]);
            }

            this.invoices[index].editable = false;

            axios
                .post("/api/rcvablesave/" + updatedItem.id, formData)
                .then((response) => {
                    console.log(response);
                    toastr.success(response.data.message);
                    this.fetchInvoices(updatedItem.buyerid);
                })
                .catch((error) => {
                    console.error("Error updating data:", error);
                    if (error.response && error.response.status === 422) {
                        const validationErrors = error.response.data.errors;
                        this.handleValidationErrors(validationErrors);
                    } else {
                        // Non-validation error, log the error
                        console.error(error);

                        // Show a toastr error notification
                        toastr.error("An error occurred while adding the user");
                    }
                });
        },

        async fetchInvoices(userID) {
            NProgress.start();

            try {
                // console.log(userID);
                const response = await axios.get(`/api/invoice/${userID}`);
                this.invoices = response.data;
                console.log(this.invoices);

                this.invoices.forEach((item) => {
                    if (item.settleamount && item.settleamount.admin_remarks) {
                        this.remarks[item.id] = item.settleamount.admin_remarks;
                    }
                });

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error("Error fetching SOs:", error);
                toastr.error("Error fetching data");
            }
        },
        handleValidationErrors(validationErrors) {
            for (const key in validationErrors) {
                if (validationErrors.hasOwnProperty(key)) {
                    const messages = validationErrors[key];
                    // console.log(messages);
                    toastr.error(messages);
                }
            }
        },

        async fetchUsers() {
            NProgress.start();

            try {
                const response = await axios.get(`/api/buyerFinance`);
                this.users = response.data.users;
                this.sales = response.data.sales;
                this.remaining = response.data.remaining;
                console.log(response.data);

                console.log('sp', this.users);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error("Error fetching Users:", error);
                toastr.error("Error fetching data");
            }
        },
    },
}
</script>

<style lang="scss" scoped></style>
