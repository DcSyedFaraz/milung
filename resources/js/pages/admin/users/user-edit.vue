<!-- UserAccordion.vue -->
<template>
    <div v-if="loader" class="loader-overlay">
        <div class="loader"></div>
    </div>
    <section class="section" v-else>
        <div class="row">
            <div class="col-lg-12 ">

                <div class="card  mx-2">
                    <div class="card-header pt-3 pb-5 text-white rounded-top-new mx-new"
                        style="background-color: #14245c">
                        <div class="d-flex justify-content-between align-items-center mx-3">
                            <span class=" mt-2 fw-bold fs-4">USERS LIST</span>
                            <span class="fw-bold ">Edit User</span>
                        </div>
                    </div>


                    <div class="card-body px-0">
                        <div>
                            <form @submit.prevent="updateUser(user.id, user)">
                                <div class="col-12 px-3" style="background-color: #e2f2f9;">
                                    <div class="row">
                                        <div class="mb-3 col-4">
                                            <label for="registerEmail" class="form-label">Company Name</label>
                                            <input type="text" class="form-control" v-model="user.name">
                                        </div>
                                        <div class="mb-3 col-4">
                                            <label for="registerEmail" class="form-label">Register Email</label>
                                            <input type="email" class="form-control" v-model="user.email">
                                        </div>

                                        <div class="mb-3 col-2">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" v-model="user.status" required>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>

                                        </div>
                                        <div class="mb-3 col-2">
                                            <label for="userIdContactPerson" class="form-label">ID:</label>
                                            <input type="text" disabled class="form-control" :value="user.userid">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-3">
                                            <label for="oneTimePassword" class="form-label">One Time Password:</label>
                                            <input type="text" class="form-control" v-model="user.otp">
                                        </div>
                                        <div class="mb-3 col-3">
                                            <label for="oneTimePassword" class="form-label">User ID Contact
                                                Person:</label>
                                            <input type="text" class="form-control" v-model="user.contact_person">
                                        </div>
                                        <div class="mb-3 col-3">
                                            <label for="oneTimePassword" class="form-label">User Contact
                                                Number:</label>
                                            <input type="text" class="form-control" v-model="user.contact_number">
                                        </div>
                                        <div class="mb-3 col-1" style="display: flex !important;">
                                            <button type="submit" class="btn btn-milung  align-self-end">Save</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 ">
                                    <div class="row py-5">
                                        <div class="col-3"
                                            v-if="user.roles.includes('Admin') || user.roles.includes('Internal')">
                                            <div class="col-12 d-flex justify-content-between mb-3">
                                                <div class="fs-5 fw-bold col-6" style="color: #14245c;">
                                                    Admin</div>
                                                <div class="form-check my-auto col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        v-model="admin.selectAll" @change="adminSelectAllChanged">
                                                    <label class="form-check-label  " for="productEntry">Select
                                                        All</label>
                                                </div>
                                            </div>

                                            <div v-for="(adm, index) in admin.checkboxes" :key="index"
                                                class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    :checked="user.permissions.includes(adm.id)"
                                                    @change="handleCheckboxChange(user, adm.id)" :value="adm.id">
                                                <label class="form-check-label">{{ adm.label
                                                    }}</label>
                                            </div>


                                        </div>
                                        <div class="col-3"
                                            v-if="user.roles.includes('Admin') || user.roles.includes('Internal')">
                                            <div class="col-12 d-flex justify-content-between mb-3">
                                                <div class="fs-5 fw-bold col-6" style="color: #14245c;">
                                                    Operations </div>
                                                <div class="form-check my-auto col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        v-model="operation.selectAll" @change="operationselect">
                                                    <label class="form-check-label fs-6 " for="productEntry">Select
                                                        All</label>
                                                </div>
                                            </div>
                                            <div v-for="(ope, index) in operation.checkboxes" :key="index"
                                                class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    :checked="user.permissions.includes(ope.id)"
                                                    @change="handleCheckboxChange(user, ope.id)" :value="ope.id">

                                                <label class="form-check-label">{{ ope.label
                                                    }}</label>
                                            </div>

                                        </div>
                                        <div class="col-3"
                                            v-if="user.roles.includes('Admin') || user.roles.includes('Internal')">
                                            <div class="col-12 d-flex justify-content-between mb-3">
                                                <div class="fs-5 fw-bold col-6" style="color: #14245c;">
                                                    Finance</div>
                                                <div class="form-check my-auto col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        v-model="finance.selectAll" @change="financeselect">
                                                    <label class="form-check-label  " for="productEntry">Select
                                                        All</label>
                                                </div>
                                            </div>
                                            <div v-for="(fin, index) in finance.checkboxes" :key="index"
                                                class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    :checked="user.permissions.includes(fin.value)"
                                                    @change="handleCheckboxChange(user, fin.value)" :value="fin.value">

                                                <label class="form-check-label">{{ fin.label
                                                    }}</label>
                                            </div>


                                        </div>
                                        <div class="col-3"
                                            v-if="user.roles.includes('Admin') || user.roles.includes('Internal')">
                                            <div class="col-12 d-flex justify-content-between mb-3">
                                                <div class="fs-5 fw-bold col-6" style="color: #14245c;">
                                                    Statistics</div>
                                                <div class="form-check my-auto col-6">
                                                    <input class="form-check-input" type="checkbox" v-model="selectAll"
                                                        @change="selectAllItems" value="true">
                                                    <label class="form-check-label  " for="productEntry">Select
                                                        All</label>
                                                </div>
                                            </div>

                                            <div v-for="(item, index) in items" :key="index" class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    :checked="user.permissions.includes(item.value)" :value="item.value"
                                                    @change="handleCheckboxChange(user, item.value)">

                                                <label class="form-check-label" :for="item.id">{{ item.label }}</label>
                                            </div>

                                        </div>
                                        <div class="col-12" v-if="user.roles[0] == 'Buyer'">
                                            <div class="col-12 d-flex  mb-3">
                                                <div class="fs-5 fw-bold col-1" style="color: #14245c;">
                                                    Buyer</div>
                                                <div class="form-check my-auto col-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        v-model="buyer.selectAll">
                                                    <label class="form-check-label  " for="productEntry">Select
                                                        All</label>
                                                </div>
                                            </div>
                                            <div class="row px-2">
                                                <div v-for="(fin, index) in buyer.checkboxes" :key="index"
                                                    class="form-check col-3">
                                                    <input class="form-check-input" type="checkbox"
                                                        :checked="user.permissions.includes(fin.id)"
                                                        @change="handleCheckboxChange(user, fin.id)" :value="fin.id">
                                                    <label class="form-check-label">{{ fin.label
                                                        }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12" v-if="user.roles[0] == 'Supplier'">
                                            <div class="col-12 d-flex  mb-3">
                                                <div class="fs-5 fw-bold col-2" style="color: #14245c;">
                                                    Supplier</div>
                                                <div class="form-check my-auto col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        v-model="supplier.selectAll">
                                                    <label class="form-check-label  " for="productEntry">Select
                                                        All</label>
                                                </div>
                                            </div>
                                            <div class="row px-2">
                                                <div v-for="(fin, index) in supplier.checkboxes" :key="index"
                                                    class="form-check col-3">
                                                    <input class="form-check-input" type="checkbox"
                                                        :checked="user.permissions.includes(fin.id)"
                                                        @change="handleCheckboxChange(user, fin.id)" :value="fin.id">
                                                    <label class="form-check-label">{{ fin.label
                                                        }}</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</template>

<script>
export default {

    data() {
        return {
            user: {},
            loader: false,
            updateuser: {
                id: null,
                name: '',
                email: '',
                status: '',
                userid: '',
                roles: '',
                permissions: [],
            },
            operation: {
                selectAll: false,
                checkboxes: [
                    { id: 'addNewSupplierEntry', label: 'Add New Supplier Entry' },
                    { id: 'editSupplierEntry', label: 'Edit Supplier Entry' },
                    { id: 'setEditSupplierIDCode', label: 'Set/Edit Supplier ID Code' },
                    { id: 'addNewBuyerEntry', label: 'Add New Buyer Entry' },
                    { id: 'editBuyerEntry', label: 'Edit Buyer Entry' },
                    { id: 'addProductEntry', label: 'Add Product Entry' },
                    { id: 'editProductEntry', label: 'Edit Product Entry' },
                    { id: 'accessImportExportCertificateTestingReport', label: 'Access/Import/Export Certificate & Testing Report' },
                    { id: 'createProductGroup', label: 'Create Product Group' },
                    // { id: 'accessNotifyImportExportFunctionForMinorEKPrice', label: 'Access/Notify/Import/Export Function for Minor EK Price' },
                    { id: 'createPriceInquiry', label: 'Create Price Inquiry' },
                    { id: 'orderGeneralSinglePage', label: 'Order General & Single Page' },
                    { id: 'createNewOrder', label: 'Create New Order' },
                    { id: 'editOrderDetails', label: 'Edit Order Details' },
                    { id: 'voidOrder', label: 'Void Order' },
                    { id: 'miLungOrderPriceEnquiry', label: 'MiLung Order Price Enquiry' },
                    { id: 'printviewConfirmRejectButton', label: 'Printview Confirm or Reject Button' },
                    { id: 'massCargoPhotoApproval', label: 'Mass Cargo Photo Approval' },
                    { id: 'createSONumber', label: 'Create SO Number' },
                    { id: 'shipmentOverview', label: 'Shipment Overview' },
                    { id: 'editShipmentOverview', label: 'Edit Shipment Overview' },
                    { id: 'exportShippingDocuments', label: 'Export Shipping Documents' },
                ],
            },
            supplier: {
                selectAll: false,
                checkboxes: [
                    { id: 'priceInquiry', label: 'Price Inquiry' },
                    { id: 'supplierOrderPriceQuote', label: 'Supplier Order Price Quote' },
                    { id: 'supplierOrderConfirmationNotification', label: 'Supplier Order Confirmation Notification' },
                    { id: 'supplierOrderGeneralSinglePage', label: 'Supplier Order General & Single Page' },
                    { id: 'uploadPrintview', label: 'Upload Printview' },
                    { id: 'cargoReadyConfirmation', label: 'Cargo Ready Confirmation' },
                    { id: 'uploadMassCargoPhoto', label: 'Upload Mass Cargo Photo' },
                    { id: 'shipmentOverview', label: 'Shipment Overview' },
                    { id: 'createReceiptNote', label: 'Create Receipt Note' },
                    { id: 'inputPackingList', label: 'Input and Generate Packing List (CSV optional)' },
                    { id: 'supplierAccountsReceivable', label: 'Supplier Accounts Receivable' },
                ],
            },
            buyer: {
                selectAll: false,
                checkboxes: [
                    { id: 'accessImportExportCertificateTestingReport', label: 'Access/Import/Export Certificate & Testing Report' },
                    { id: 'createBuyerPriceInquiry', label: 'Create Buyer Price Inquiry' },
                    { id: 'editBuyerPriceInquiry', label: 'Edit Buyer Price Inquiry' },
                    { id: 'createNewBuyerOrder', label: 'Create New Buyer Order' },
                    { id: 'editBuyerOrder', label: 'Edit Buyer Order' },
                    { id: 'confirmRejectPrintview', label: 'Confirm/Reject Printview' },
                    { id: 'buyerShipmentOverview', label: 'Buyer Shipment Overview' },
                    { id: 'addATCNumber', label: 'Add ATC Number' },
                    { id: 'exportShippingDocuments', label: 'Export Shipping Documents' },
                    { id: 'buyerAccountPayable', label: 'Buyer Account Payable' },
                    { id: 'bestSales', label: 'Best Sales 20 Item No. & Qty' },
                    { id: 'bestPurchase', label: 'Best Purchase 20 Item No. & Qty' },
                    { id: 'salesRevenue', label: 'Sales Revenue (Qty/Volume/Weight Weekly/Monthly/Yearly)' },
                    { id: 'purchaseRevenue', label: 'Purchase Revenue (Qty/Volume/Weight Weekly/Monthly/Yearly)' },
                    // { id: 'accessToUSBChipPrice', label: 'Access to USB Chip Price' },
                ]
            },
            finance: {
                selectAll: false,
                checkboxes: [
                    { id: 'transactionOverview', label: 'Transaction Overview', value: 'transactionOverview' },
                    { id: 'accountPayable', label: 'Account Payable', value: 'accountPayable' },
                    { id: 'accountReceivable', label: 'Account Receivable', value: 'accountReceivable' },
                ],
            },
            admin: {
                selectAll: false,
                checkboxes: [
                    { id: 'issueNewLoginIdPassword', label: 'Issue New Login ID & Password, Reset Password' },
                    { id: 'setAccessAuthority', label: 'Right to set Access Authority' },
                    { id: 'userManagement', label: 'User Management (can edit or delete users)' },
                ],
            },
            selectAll: false,
            items: [
                { id: 'bestSales', label: 'Best Sales 20 Item No. & Qty', value: 'bestSales' },
                { id: 'bestPurchase', label: 'Best Purchase 20 Item No. & Qty', value: 'bestPurchase' },
                { id: 'salesRevenue', label: 'Sales Revenue (Qty/Volume/Weight Weekly/Monthly/Yearly)', value: 'salesRevenue' },
                { id: 'purchaseRevenue', label: 'Purchase Revenue (Qty/Volume/Weight Weekly/Monthly/Yearly)', value: 'purchaseRevenue' },
            ],
        };
    },
    created() {
        this.loader = true;
        axios.get(`/api/users/${this.$route.params.id}`)
            .then(response => {
                this.user = response.data;
                console.log(this.user);
                this.loader = false;
            })
            .catch(error => {
                this.loader = false;
                console.error(error);
            });
    },
    methods: {
        handleCheckboxChange(user, value) {
            const index = user.permissions.indexOf(value);
            if (index === -1) {
                // If not found, add to permissions
                user.permissions.push(value);
                this.updateuser.permissions = user.permissions;
            } else {
                // If found, remove from permissions
                user.permissions.splice(index, 1);
                this.updateuser.permissions = user.permissions;
            }
            // You can also console.log the updated permissions here to verify the changes
            console.log('Updated Permissions:', this.updateuser.permissions);
        },
        isPermissionChecked(value, checkboxModel) {
            return checkboxModel.includes(value);
        },

        updateUser(id, user) {
            this.loader = true;

            const formData = {
                staticsitems: this.staticsitems,
                adminitems: this.adminitems,
                operationitems: this.operationitems,
                financeitems: this.financeitems,
            };
            const allItems = Object.values(formData).flat();

            axios.put(`/api/updateusers/${id}`, {
                updateuser: user,
                formData: allItems,
            })
                .then(response => {
                    this.loader = false;

                    if (response.status === 200) {
                        toastr.success('User updated successfully');

                        this.$router.push({ name: 'user' });
                    }
                })
                .catch(error => {
                    this.loader = false;

                    if (error.response.status === 422) {
                        const errors = error.response.data.errors;

                        errors.forEach(errorMessage => {
                            toastr.error(errorMessage);
                        });
                    } else {
                        toastr.error('An error occurred while updating the user');
                    }
                });
        },
        adminSelectAllChanged() {
            if (this.admin.selectAll) {
                this.adminitems = this.admin.checkboxes.map(item => item.id);
            } else {
                this.adminitems = [];
            }
        },
        //...
    }
}
</script>

<style scoped>
.loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    /* Semi-transparent black overlay */
    display: flex;
    justify-content: center;
    align-items: center;
    backdrop-filter: blur(5px);
    /* Add blur effect */
    z-index: 9999;
    /* Ensure it's above other elements */
}

.loader {
    border: 4px solid #f3f3f3;
    /* Light gray border */
    border-top: 4px solid #3498db;
    /* Blue border for spinning effect */
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 2s linear infinite;
    /* Spin animation */
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

.rounded-top-new {
    border-top-left-radius: 2.25rem !important;
    border-top-right-radius: 2.25rem !important;
}

.rounded-bottom-new {
    border-bottom-left-radius: 2.25rem !important;
    border-bottom-right-radius: 2.25rem !important;
}
</style>
