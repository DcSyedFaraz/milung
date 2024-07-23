<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">

                <div class="card  ">
                    <div class="card-header pt-3 pb-5 text-white rounded-top-new mx-new"
                        style="background-color: #14245c">
                        <div class="d-flex justify-content-between align-items-center mx-3">
                            <span class=" mt-2 fw-bold fs-4">USERS LIST</span>
                            <span class="fw-bold ">Add
                                New</span>
                        </div>
                    </div>


                    <div class="card-body ">
                        <div>
                            <form @submit.prevent="updateUser(user)">
                                <div class="col-12 px-3 pt-3" style="background-color: #e2f2f9;">
                                    <div class="ms-2 row px-2">
                                        <div class="mb-3 col-4">
                                            <label for="registerEmail" class="form-label">Type of ID:</label>

                                            <div class="row">
                                                <div class="form-check col-3">
                                                    <input class="form-check-input" type="radio" v-model="user.roles"
                                                        value="Admin">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        Admin
                                                    </label>
                                                </div>
                                                <div class="form-check col-3">
                                                    <input class="form-check-input" type="radio" v-model="user.roles"
                                                        value="Internal">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        Internal
                                                    </label>
                                                </div>
                                                <div class="form-check col-3">
                                                    <input class="form-check-input" type="radio" v-model="user.roles"
                                                        value="Supplier">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        Supplier
                                                    </label>
                                                </div>
                                                <div class="form-check col-3">
                                                    <input class="form-check-input" value="Buyer" type="radio"
                                                        v-model="user.roles">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        Buyer
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="mb-3 col-3">
                                            <label for="registerEmail" class="form-label">Company Name</label>
                                            <input type="text" required class="form-control" v-model="user.name">
                                        </div>
                                        <div class="mb-3 col-2"
                                            v-if="parent_id && parent_id.length > 0 && (user.roles === 'Supplier' || user.roles === 'Buyer')">
                                            <label for="registerEmail" class="form-label">Supplier/Buyer ID</label>
                                            <multiselect v-model="selectedOption" :options="parent_id"
                                                @change="updateParentIdAndName" label="userid"
                                                v-if="parent_id && parent_id.length > 0 && (user.roles === 'Supplier' || user.roles === 'Buyer')">
                                            </multiselect>
                                            <small v-else-if="user.roles !== 'Supplier' && user.roles !== 'Buyer'"
                                                class=""><br> Selected role is not Supplier/Buyer</small>
                                            <small v-else class=""> No data available for Supplier/Buyer ID</small>
                                        </div>
                                        <div class="mb-3 col-3">
                                            <label for="registerEmail" class="form-label">Register Email</label>
                                            <input type="email" required class="form-control" v-model="user.email">
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-2">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" v-model="user.status" required>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>

                                        </div>
                                        <div class="mb-3 col-2">
                                            <label for="userIdContactPerson" class="form-label">UserID:</label>
                                            <input type="text" class="form-control" v-model="user.userid"
                                                :class="{ 'is-invalid': !userIdPatternValid, 'is-valid': userIdPatternValid }">
                                            <div v-if="!userIdPatternValid" class="invalid-feedback">
                                                User ID must be alphanumeric, between 1 and 20 characters long, and can
                                                include hyphens.
                                            </div>
                                        </div>
                                        <div class="mb-3 col-2">
                                            <label for="oneTimePassword" class="form-label">One Time Password:</label>
                                            <input type="text" v-model="user.otp" required class="form-control">
                                        </div>
                                        <div class="mb-3 col-2">
                                            <label for="oneTimePassword" class="form-label">User Contact
                                                Person:</label>
                                            <input type="text" class="form-control" v-model="user.contact_person">
                                        </div>
                                        <div class="mb-3 col-2">
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
                                        <div class="col-3" v-if="user.roles == 'Internal'">
                                            <div class="col-12 d-flex justify-content-between mb-3">
                                                <div class="fs-5 fw-bold col-6" style="color: #14245c;">
                                                    Admin</div>
                                                <div class="form-check my-auto col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        :indeterminate="admin.indeterminate" v-model="admin.selectAll"
                                                        @change="groupSelectAllChanged('admin')">
                                                    <label class="form-check-label  " for="productEntry">Select
                                                        All</label>
                                                </div>
                                            </div>

                                            <div v-for="(adm, index) in admin.checkboxes" :key="index"
                                                class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    :checked="user.permissions.includes(adm.id)"
                                                    @change="handleCheckboxChange(user, adm.id, 'admin')"
                                                    :value="adm.id">
                                                <label class="form-check-label">{{ adm.label
                                                    }}</label>
                                            </div>


                                        </div>
                                        <div class="col-3" v-if="user.roles == 'Internal'">
                                            <div class="col-12 d-flex justify-content-between mb-3">
                                                <div class="fs-5 fw-bold col-6" style="color: #14245c;">
                                                    Operations </div>
                                                <div class="form-check my-auto col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        :indeterminate="operation.indeterminate"
                                                        v-model="operation.selectAll"
                                                        @change="groupSelectAllChanged('operation')">
                                                    <label class="form-check-label fs-6 " for="productEntry">Select
                                                        All</label>
                                                </div>
                                            </div>
                                            <div v-for="(ope, index) in operation.checkboxes" :key="index"
                                                class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    :checked="user.permissions.includes(ope.id)"
                                                    @change="handleCheckboxChange(user, ope.id, 'operation')"
                                                    :value="ope.id">

                                                <label class="form-check-label">{{ ope.label
                                                    }}</label>
                                            </div>

                                        </div>
                                        <div class="col-3" v-if="user.roles == 'Internal'">
                                            <div class="col-12 d-flex justify-content-between mb-3">
                                                <div class="fs-5 fw-bold col-6" style="color: #14245c;">
                                                    Finance</div>
                                                <div class="form-check my-auto col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        :indeterminate="finance.indeterminate"
                                                        @change="groupSelectAllChanged('finance')"
                                                        v-model="finance.selectAll">
                                                    <label class="form-check-label  " for="productEntry">Select
                                                        All</label>
                                                </div>
                                            </div>
                                            <div v-for="(fin, index) in finance.checkboxes" :key="index"
                                                class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    :checked="user.permissions.includes(fin.value)"
                                                    @change="handleCheckboxChange(user, fin.value, 'finance')"
                                                    :value="fin.value">

                                                <label class="form-check-label">{{ fin.label
                                                    }}</label>
                                            </div>


                                        </div>
                                        <div class="col-3" v-if="user.roles == 'Internal'">
                                            <div class="col-12 d-flex justify-content-between mb-3">
                                                <div class="fs-5 fw-bold col-6" style="color: #14245c;">
                                                    Statics</div>
                                                <div class="form-check my-auto col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        :indeterminate="items.indeterminate" v-model="items.selectAll"
                                                        @change="groupSelectAllChanged('items')" value="true">
                                                    <label class="form-check-label  " for="productEntry">Select
                                                        All</label>
                                                </div>
                                            </div>

                                            <div v-for="(item, index) in items.checkboxes" :key="index"
                                                class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    :checked="user.permissions.includes(item.id)" :value="item.id"
                                                    @change="handleCheckboxChange(user, item.id, 'items')">

                                                <label class="form-check-label" :for="item.id">{{ item.label }}</label>
                                            </div>

                                        </div>
                                        <div class="col-3" v-if="user.roles == 'Buyer'">
                                            <div class="col-12 d-flex justify-content-between mb-3">
                                                <div class="fs-5 fw-bold col-6" style="color: #14245c;">
                                                    Buyer</div>
                                                <div class="form-check my-auto col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        :indeterminate="buyer.indeterminate" v-model="buyer.selectAll"
                                                        @change="groupSelectAllChanged('buyer')">
                                                    <label class="form-check-label  " for="productEntry">Select
                                                        All</label>
                                                </div>
                                            </div>
                                            <div v-for="(fin, index) in buyer.checkboxes" :key="index"
                                                class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    :checked="user.permissions.includes(fin.id)"
                                                    @change="handleCheckboxChange(user, fin.id, 'buyer')"
                                                    :value="fin.id">

                                                <label class="form-check-label">{{ fin.label
                                                    }}</label>
                                            </div>


                                        </div>
                                        <div class="col-3" v-if="user.roles == 'Supplier'">
                                            <div class="col-12 d-flex justify-content-between mb-3">
                                                <div class="fs-5 fw-bold col-6" style="color: #14245c;">
                                                    Supplier</div>
                                                <div class="form-check my-auto col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        :indeterminate="supplier.indeterminate"
                                                        @change="groupSelectAllChanged('supplier')"
                                                        v-model="supplier.selectAll">
                                                    <label class="form-check-label  " for="productEntry">Select
                                                        All</label>
                                                </div>
                                            </div>
                                            <div v-for="(fin, index) in supplier.checkboxes" :key="index"
                                                class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    :checked="user.permissions.includes(fin.id)"
                                                    @change="handleCheckboxChange(user, fin.id, 'supplier')"
                                                    :value="fin.id">

                                                <label class="form-check-label">{{ fin.label
                                                    }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <EventLogTable />
            </div>
        </div>
    </section>
    <div v-if="loader" class="loader-overlay">
        <div class="loader"></div>
    </div>
</template>

<script>
export default {
    emits: ['profileUpdated'],
    data() {
        return {
            parent_id: {},
            selectedOption: '',
            loader: false,
            user: {
                roles: '',
                permissions: [],
            },
            operation: {
                indeterminate: false,
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
                    { id: 'accessNotifyImportExportFunctionForMinorEKPrice', label: 'Access/Notify/Import/Export Function for Minor EK Price' },
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
                indeterminate: false,
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
                indeterminate: false,
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
                    { id: 'accessToUSBChipPrice', label: 'Access to USB Chip Price' },
                ],
            },
            finance: {
                indeterminate: false,
                selectAll: false,
                checkboxes: [
                    { id: 'transactionOverview', label: 'Transaction Overview', value: 'transactionOverview' },
                    { id: 'accountPayable', label: 'Account Payable', value: 'accountPayable' },
                    { id: 'accountReceivable', label: 'Account Receivable', value: 'accountReceivable' },
                ],
            },
            admin: {
                indeterminate: false,
                selectAll: false,
                checkboxes: [
                    { id: 'issueNewLoginIdPassword', label: 'Issue New Login ID & Password, Reset Password' },
                    { id: 'setAccessAuthority', label: 'Right to set Access Authority' },
                    { id: 'userManagement', label: 'User Management (can edit or delete users)' },
                ],
            },
            items:
            {
                selectAll: false,
                indeterminate: false,
                checkboxes: [
                    { id: 'bestSales', label: 'Best Sales 20 Item No. & Qty', value: 'bestSales' },
                    { id: 'bestPurchase', label: 'Best Purchase 20 Item No. & Qty', value: 'bestPurchase' },
                    { id: 'salesRevenue', label: 'Sales Revenue (Qty/Volume/Weight Weekly/Monthly/Yearly)', value: 'salesRevenue' },
                    { id: 'purchaseRevenue', label: 'Purchase Revenue (Qty/Volume/Weight Weekly/Monthly/Yearly)', value: 'purchaseRevenue' },
                ],
            },
        };
    },
    mounted() {
        this.user.roles = 'Admin';
        this.user.name = 'MiLung Trade Limited';
        this.user.status = 'active';
        this.updateSelectAllState('admin');
        this.updateSelectAllState('operation');
        this.updateSelectAllState('supplier');
        this.updateSelectAllState('buyer');
        this.updateSelectAllState('finance');
        this.updateSelectAllState('items');
    },
    methods: {
        groupSelectAllChanged(group) {
            const groupData = this[group];
            groupData.checkboxes.forEach(item => {
                const index = this.user.permissions.indexOf(item.id);
                if (groupData.selectAll && index === -1) {
                    this.user.permissions.push(item.id);
                } else if (!groupData.selectAll && index !== -1) {
                    this.user.permissions.splice(index, 1);
                }
            });
            this.updateSelectAllState(group);
        },
        updateSelectAllState(group) {
            const groupData = this[group];
            const totalItems = groupData.checkboxes.length;
            const selectedItems = groupData.checkboxes.filter(item =>
                this.user.permissions.includes(item.id)
            ).length;

            if (selectedItems === 0) {
                groupData.selectAll = false;
                groupData.indeterminate = false;
            } else if (selectedItems === totalItems) {
                groupData.selectAll = true;
                groupData.indeterminate = false;
            } else {
                groupData.selectAll = false;
                groupData.indeterminate = true;
            }
        },
        updateParentIdAndName(selectedOption) {
            console.log(selectedOption);
            if (selectedOption) {
                this.user.parent_id = selectedOption.id;
                this.user.name = selectedOption.userid;
            } else {
                this.user.parent_id = null;
                this.user.name = '';
            }
        },
        parentid(role) {
            const params = { role: role };
            console.log(params);
            this.loader = true;
            axios.get('/api/parentid', { params })
                .then(response => {
                    this.loader = false;
                    this.parent_id = response.data
                    console.log(this.parent_id);
                })
                .catch(error => {
                    this.loader = false;
                    console.log('catch error:', error);
                    toastr.error('An error occurred while updating the user');
                });
        },
        handleCheckboxChange(user, value, group) {
            const index = user.permissions.indexOf(value);
            if (index === -1) {
                // If not found, add to permissions
                user.permissions.push(value);
            } else {
                // If found, remove from permissions
                user.permissions.splice(index, 1);
            }
            this.updateSelectAllState(group);
            // You can also console.log the updated permissions here to verify the changes
            console.log('Updated Permissions:', this.user.permissions);
        },
        isPermissionChecked(value, checkboxModel) {
            return checkboxModel.includes(value);
        },
        handleValidationErrors(validationErrors) {
            console.log(validationErrors);
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    const messages = validationErrors[key];
                    messages.forEach(message => {
                        toastr.error(message);
                    });
                }
            }
        },
        updateUser(user) {
            this.loader = true;

            console.log(user);
            axios.post('/api/addusers', user)
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
                        const validationErrors = error.response.data.errors;
                        this.handleValidationErrors(validationErrors);
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
    },
    computed: {
        userIdPatternValid() {
            const pattern = /^[a-zA-Z0-9-]{1,20}$/;
            return pattern.test(this.user.userid);
        }
    },
    watch: {
        selectedOption(newValue) {
            console.log(newValue);
            if (newValue) {
                this.user.parent_id = newValue.id;
                this.user.parent_userid = newValue.userid;
                this.user.name = newValue.name;
            } else {
                this.user.parent_id = null;
                this.user.parent_userid = null;
                this.user.name = '';
            }
        },
        'user.permissions': function () {
            this.updateSelectAllState('admin');
            this.updateSelectAllState('operation');
            this.updateSelectAllState('supplier');
            this.updateSelectAllState('buyer');
            this.updateSelectAllState('finance');
            this.updateSelectAllState('items');
        },
        'user.roles': function (newValue) {
            if (newValue === 'Admin' || newValue === 'Internal') {
                this.user.name = 'MiLung Trade Limited';
                this.user.parent_userid = null;
                this.parent_id = {};
            } else if (newValue === 'Supplier') {
                this.parentid('Supplier');
                this.user.name = '';
            } else if (newValue === 'Buyer') {
                this.parentid('Buyer');
                this.user.name = '';
            }
        }
    }
}
</script>

<style scoped>
@import url('../style.css');

.rounded-top-new {
    border-top-left-radius: 2.25rem !important;
    border-top-right-radius: 2.25rem !important;
}

.rounded-bottom-new {
    border-bottom-left-radius: 2.25rem !important;
    border-bottom-right-radius: 2.25rem !important;
}

.mx-new {
    margin-right: 1.23rem !important;
    margin-left: 1.23rem !important;
}

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
</style>
