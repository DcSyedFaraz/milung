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
                                <tr>
                                    <th class="text-nowrap cursor-pointer" @click="sortTable('id')">POS
                                        <i :class="getSortIcon('id')" class="ms-1"></i>
                                    </th>
                                    <th class="text-nowrap cursor-pointer" @click="sortTable('information.invoice')">
                                        Invoice Number
                                        <i :class="getSortIcon('information.invoice')" class="ms-1"></i>
                                    </th>
                                    <th class="text-nowrap cursor-pointer"
                                        @click="sortTable('information.totalpayable')">Invoice Value
                                        <i :class="getSortIcon('information.totalpayable')" class="ms-1"></i>
                                    </th>
                                    <th class="text-nowrap cursor-pointer" @click="sortTable('shipment.ship_date')">
                                        Shipping Date
                                        <i :class="getSortIcon('shipment.ship_date')" class="ms-1"></i>
                                    </th>
                                    <th class="text-nowrap cursor-pointer" @click="sortTable('method')">Shipping Method
                                        <i :class="getSortIcon('method')" class="ms-1"></i>
                                    </th>
                                    <th class="text-nowrap cursor-pointer" @click="sortTable('shipment.delivery')">ETA
                                        Date
                                        <i :class="getSortIcon('shipment.delivery')" class="ms-1"></i>
                                    </th>
                                    <th class="text-nowrap cursor-pointer"
                                        @click="sortTable('settleamount.settle_amount')">Payment Settled
                                        <i :class="getSortIcon('settleamount.settle_amount')" class="ms-1"></i>
                                    </th>
                                    <th class="text-nowrap cursor-pointer"
                                        @click="sortTable('settleamount.settle_date')">Payment Settled Date
                                        <i :class="getSortIcon('settleamount.settle_date')" class="ms-1"></i>
                                    </th>
                                    <th class="text-nowrap cursor-pointer"
                                        @click="sortTable('settleamount.outstanding_amount')">Outstanding Balance
                                        <i :class="getSortIcon('settleamount.outstanding_amount')" class="ms-1"></i>
                                    </th>
                                    <th class="text-nowrap">Buyer Remittance Slip</th>
                                    <th class="text-nowrap">MiLung Remittance Slip</th>
                                    <th class="text-nowrap">Remarks</th>
                                    <th class="text-nowrap">Actions</th>
                                </tr>
                            </thead>


                            <tbody class="text-center">
                                <tr v-for="(item, index) in invoices" :key="index - 1" v-if="invoices.length > 0">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                :value="item.information?.invoice" v-if="item.information?.invoice"
                                                v-model="selectedInvoiceIds">
                                            <label class="form-check-label">

                                                {{ index + 1 }}
                                            </label>
                                        </div>
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
                                    <td>{{ item.settleamount?.settle_date ?? 'Not settled yet' }}</td>

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
                    <div class="col-12 d-flex justify-content-end">
                        <div class="col-2">

                            <button class="btn btn-warning mt-2 fw-bold" :disabled="selectedInvoiceIds.length == 0"
                                @click="payment">
                                Payment Reminder
                            </button>
                        </div>

                    </div>

                    <div class="card-body mt-5" v-show="!isLoading">
                        <div class="row">
                            <div class="col-md-6">
                                <span class="fw-bold fs-6 text-uppercase" style="color: #14245c">General Outstanding
                                    account
                                    Receivable:</span>

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
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';


export default {
    data() {
        return {
            isLoading: true,
            sortKey: '',
            sortAsc: true,
            selectedUserId: "",
            invoices: [],
            selectedInvoiceIds: [],
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
        async payment() {

            if (this.selectedInvoiceIds.length === 0) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select at least one invoice to send reminder.',
                    icon: 'error',
                });
                return;
            }
            if (!this.selectedUserId) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select buyer to send reminder.',
                    icon: 'error',
                });
                return;
            }
            // Confirm the upload
            const { isConfirmed } = await Swal.fire({
                title: 'Are you sure you want to send payment reminder?',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
            });

            if (!isConfirmed) {
                return;
            }
            // alert(selectedUserId);

            const formData = {
                invoice_ids: this.selectedInvoiceIds,
                buyerid: this.selectedUserId.id,

            };

            Swal.fire({
                title: 'Please wait...',
                allowOutsideClick: false,
                showConfirmButton: false,
            });
            Swal.showLoading();

            try {
                const response = await axios.post('/api/invoice/reminder', formData);

                Swal.hideLoading();
                console.log(response);

                // Show a success message
                Swal.fire({
                    title: 'Success!',
                    text: 'Reminder sent successfully.',
                    icon: 'success',
                });

                this.selectedInvoiceIds = [];

            } catch (error) {
                console.log(error);
                Swal.hideLoading();
                // Show an error message
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while sending reminder.',
                    icon: 'error',
                });
            }

        },
        sortTable(key) {
            if (this.sortKey === key) {
                this.sortAsc = !this.sortAsc;
            } else {
                this.sortKey = key;
                this.sortAsc = true;
            }
            this.users.sort((a, b) => {
                const getValue = (obj, path) => path.split('.').reduce((acc, part) => acc && acc[part], obj);
                const aValue = getValue(a, key);
                const bValue = getValue(b, key);

                let result = 0;
                if (aValue < bValue) {
                    result = -1;
                } else if (aValue > bValue) {
                    result = 1;
                }
                return this.sortAsc ? result : -result;
            });
        },
        getSortIcon(key) {
            if (this.sortKey === key) {
                return this.sortAsc ? 'fas fa-sort-up' : 'fas fa-sort-down';
            }
            return 'fas fa-sort';
        },
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
