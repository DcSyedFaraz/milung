<template>
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-6"></div>
                <div class="col-md-6 gap-2">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-milung mx-2 px-4" type="submit">Save</button>
                        <button class="btn btn-warning px-4" type="reset">Clear</button>
                    </div>
                </div>

            </div>
            <div class="row my-5">
                <div class="col-md-6">
                    <h3 class="text-milung fw-bold text-uppercase">1. Product Information</h3>
                    <div class="d-flex col-11 mt-5">
                        <div class="col-4">
                            <p for="name">Article Number:</p>
                        </div>
                        <div class="col-8"><input type="text" name="article" class="form-control"></div>
                    </div>
                    <div class="d-flex col-11 mt-5">
                        <div class="col-4">
                            <p for="name">Product Name:</p>
                        </div>
                        <div class="col-8">
                            <input type="text" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="d-flex col-11 mt-5">
                        <div class="col-4">
                            <p for="name">Product Description:</p>
                        </div>
                        <div class="col-8">
                            <textarea name="description" class="form-control" cols="36" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="d-flex col-11 mt-5">
                        <div class="col-4">
                            <p for="name">Product Group:</p>
                        </div>
                        <div class="col-8">
                            <select class="form-control" name="group">
                                <option value="Power bank">Power bank</option>
                                <option value="Mobile Storage">Mobile Storage</option>
                                <option value="Travel Adapter">Travel Adapter</option>
                                <option value="Wireless Charger">Wireless Charger</option>
                                <option value="RFID Card">RFID Card</option>
                                <option value="LED Lamp">LED Lamp</option>
                                <option value="Solar Panel">Solar Panel</option>
                                <option value="USB Cable">USB Cable</option>
                                <option value="Fan">Fan</option>
                                <option value="Charger">Charger</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex col-11 mt-5">
                        <div class="col-4">
                            <p for="name">Cargo Classification:</p>
                        </div>
                        <div class="col-8">
                            <div class="d-flex">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="general" name="cardo">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        General Cargo
                                    </label>
                                </div>
                                <div class="form-check mx-2">
                                    <input class="form-check-input" type="radio" value="danger" name="cardo">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Danger Goods
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex my-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cargo" value="hongkong">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Hong Kong
                                    </label>
                                </div>
                                <div class="form-check mx-2">
                                    <input class="form-check-input" type="checkbox" name="cargo" value="china">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Mainland China
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex col-11 mt-5">
                        <div class="col-4">
                            <p for="name">Product Color:</p>
                        </div>
                        <div class="col-8">
                            <input type="text" name="color" class="form-control">
                        </div>
                    </div>
                    <div class="d-flex col-11 mt-5">
                        <div class="col-4 ">
                            <p for="name" class="">Product Material:</p>
                        </div>
                        <div class="col-5">
                            <div class="input-group">
                                <input type="text" class="form-control" name="material"/>
                                <span class="input-group-text">mm</span>
                              </div>
                        </div>
                    </div>
                    <div class="d-flex col-11 mt-5">
                        <div class="col-4 ">
                            <p for="name" class="">Product Size (L*W*H)/(L*Dia):</p>
                        </div>
                        <div class="col-5">
                            <div class="input-group">
                                <input type="text" class="form-control" name="size"/>
                                <span class="input-group-text">mm</span>
                              </div>
                        </div>
                    </div>

                    <div class="d-flex col-11 mt-5">
                        <div class="col-4 ">
                            <p for="name" class="" style="font-size: 0.9rem!important;">Product Net Weight (Product Only per pcs):</p>
                        </div>
                        <div class="col-5">
                            <div class="input-group">
                                <input type="text" class="form-control" name="weight"/>
                                <span class="input-group-text">g</span>
                              </div>
                        </div>
                    </div>
                    <div class="d-flex col-11 mt-5">
                        <div class="col-4">
                            <p for="name">Product Specifications:</p>
                        </div>
                        <div class="col-8">
                            <textarea name="specification" class="form-control" cols="36" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="d-flex col-11 mt-5">
                        <div class="col-4">
                            <p for="name" style="font-size: 0.9rem!important;">Product Memory Storage (if applicable):</p>
                        </div>
                        <div class="col-8">
                            <input type="text" name="memory" class="form-control">
                        </div>
                    </div>
                    <div class="d-flex col-11 mt-5">
                        <div class="col-4">
                            <p for="name" >Product Features:</p>
                        </div>
                        <div class="col-8">
                            <input type="text" name="feature" class="form-control">
                        </div>
                    </div>
                    <div class="d-flex col-11 mt-5">
                        <div class="col-4">
                            <p for="name" style="font-size: 0.9rem!important;">Specify Accrssories (i.e Cable,Manual,etc):</p>
                        </div>
                        <div class="col-8">
                            <input type="text" name="accessory" class="form-control">
                        </div>
                    </div>
                    <div class="d-flex col-11 mt-5">
                        <div class="col-4">
                            <p for="name" style="font-size: 0.9rem!important;">Accessories Total Net Weight (Accessories Only per pc):</p>
                        </div>
                        <div class="col-4">
                            <div class="input-group">
                                <input type="text" class="form-control" name="accessory_weight"/>
                                <span class="input-group-text">g</span>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h2>1. Product Information</h2>

                </div>
            </div>
        </div>
    </section>
</template>

<script>
import './index';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';




export default {
    props: {
        data: {
            type: Array,
            required: true
        },
        perPage: {
            type: Number,
            default: 10
        }
    },
    data() {
        return {
            updateuser: {
                // id: this.$route.params.id,
                name: '',
                email: '',
                status: '',
                buyer_id: '',
                roles: '',
            },
            adminSelectAll: false,
            adminCheckboxes: [
                { id: 'idPassword', label: 'Issue New Login ID & Password to Vim Internal Staff', value: 'idPassword' },
                { id: 'Authority', label: 'Right to set Access Authority', value: 'Authority' },
            ],
            selectAll: false,
            items: [
                { id: 'bestSales', label: 'Best Sales 20 Item No. & Qty', value: 'bestSales' },
                { id: 'bestPurchase', label: 'Best Purchase 20 Item No. & Qty', value: 'bestPurchase' },
                { id: 'salesRevenue', label: 'Sales Revenue (Qty/Volume/Weight Weekly/Monthly/Yearly)', value: 'salesRevenue' },
                { id: 'purchaseRevenue', label: 'Purchase Revenue (Qty/Volume/Weight Weekly/Monthly/Yearly)', value: 'purchaseRevenue' },
            ],
            staticsitems: [],
            adminitems: [],
            operationitems: [],
            financeitems: [],
            operationsSelectAll: false,
            operationsCheckboxes: [
                { id: 'productEntry', label: 'Product Entry', value: 'productEntry', checked: false },
                { id: 'createNewAN', label: 'Create New AN', value: 'createNewAN', checked: false },
                { id: 'createNewOrder', label: 'Create New Order', value: 'createNewOrder', checked: false },
                { id: 'productGroup', label: 'Product Group', value: 'productGroup', checked: false },
                { id: 'confirmOrRejectPrintview', label: 'Confirm or Reject Printview', value: 'confirmOrRejectPrintview', checked: false },
                { id: 'orderGeneralSinglePage', label: 'Order General & Single Page', value: 'orderGeneralSinglePage', checked: false },
                { id: 'atcNumberInput', label: 'ATC Number Input', value: 'atcNumberInput', checked: false },
                { id: 'exportShippingDocuments', label: 'Export Shipping Documents', value: 'exportShippingDocuments', checked: false },
                { id: 'voidOrder', label: 'Void Order', value: 'voidOrder', checked: false },
            ],
            financeSelectAll: false,
            financeCheckboxes: [
                { id: 'accountPayable', label: 'Account Payable', value: 'accountPayable', checked: false },
                { id: 'accountReceivable', label: 'Account Receivable', value: 'accountReceivable', checked: false },
            ],
            users: [],
            accordionOpen: {},
            currentPage: 1
        };
    },
    watch: {
        data(newVal) {
            this.users = newVal;
        }
    },
    computed: {
        totalPages() {
            return Math.ceil(this.users.length / this.perPage)
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.perPage
            const end = start + this.perPage
            return this.users.slice(start, end)
        }
    },
    mounted() {

    },
    created() {
        this.fetchUsers();
    },
    methods: {
        adminSelectAllChanged() {
            if (this.adminSelectAll) {
                this.adminitems = this.adminCheckboxes.map(item => item.value);
            } else {
                this.adminitems = [];
            }
        },
        financeselect() {
            if (this.financeSelectAll) {
                this.financeitems = this.financeCheckboxes.map(item => item.value);
            } else {
                this.financeitems = [];
            }
        },
        operationselect() {
            if (this.operationsSelectAll) {
                this.operationitems = this.operationsCheckboxes.map(item => item.value);
            } else {
                this.operationitems = [];
            }
        },
        selectAllItems() {
            if (this.selectAll) {
                this.staticsitems = this.items.map(item => item.value);
            } else {
                this.staticsitems = [];
            }
        },
        toggleAccordion(user) {
            this.accordionOpen[user.id] = !this.accordionOpen[user.id];
        },
        changePage(page) {
            this.currentPage = page
        },
        async updateUser(id) {
            const formData = {
                staticsitems: this.staticsitems,
                adminitems: this.adminitems,
                operationitems: this.operationitems,
                financeitems: this.financeitems,
            };

            // Send formData to your API
            // console.log('Form Data:', formData);
            try {
                const response = await axios.put(`/api/updateusers/${id}`, [this.updateuser, formData]);

                if (response.status === 200) {
                    toastr.success('User updated successfully');
                    this.$router.push({ name: 'user' });
                }
            } catch (error) {
                if (error.response.status === 422) {
                    toastr.error('Please fix the validation errors and try again');
                } else {
                    toastr.error('An error occurred while updating the user');
                }
            }
        },
        async fetchUsers() {
            try {
                const response = await axios.get('/api/products');
                this.users = response.data;
                // this.pagination.totalItems = response.data.total;
                console.log(response.data);

            } catch (error) {
                console.error('Error fetching users:', error);
                toastr.error('Error fetching data');
            }
        },
        async deleteUser(userId) {
            // Display SweetAlert confirmation dialog
            const result = await Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this user!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            });

            if (result.isConfirmed) {
                // User confirmed, proceed with the deletion
                try {
                    await axios.delete(`/api/prodDelete/${userId}`);

                    // If successful, remove the user from the local data
                    this.users = this.users.filter(user => user.id !== userId);

                    Swal.fire({
                        icon: 'success',
                        title: 'User deleted successfully',
                    });
                } catch (error) {
                    console.error('Error deleting user:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error deleting user',
                    });
                }
            }
        },

    },
};
</script>

<style scoped>
@import url('./style.css');

.rotate-icon {
    transform: rotate(180deg);
}

.table {
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 20px;

    border-radius: 10px 10px 0 0;
    overflow: hidden;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s !important;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}

.page-link {
    border: none !important;
    color: #14245c;
}

.page-item.active .page-link,
.btn-milung {
    background-color: #14245c !important;
    color: white;
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
