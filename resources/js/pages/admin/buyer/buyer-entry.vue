<template>
    <div>
        <div class="container mt-5">
            <div class="justify-content-start">
                <div class="col-md-12">
                    <h3 class="fw-bold mb-4" style="color: #14245c;">Buyer Entry</h3>
                    <form @submit.prevent="submitForm">
                        <div>
                            <div class="row">
                                <div class="d-flex col-6 my-2">
                                    <div class="col-6">
                                        <label for="buyerId">Buyer ID:</label>
                                    </div>
                                    <div class="col-6">
                                        <InputText class="w-100" id="buyerId" v-model="buyer.buyer_id" required
                                            pattern="[a-zA-Z0-9]{1,10}" :disabled="isEditMode"
                                            :class="{ 'p-invalid': !userIdPatternValid }" />
                                        <Message class="my-2" v-if="!userIdPatternValid" severity="error">User ID must
                                            be alphanumeric and between 1 and 10 characters long.</Message>
                                        <Message class="my-2" v-if="errors.buyer_id" severity="error">{{
                        errors.buyer_id[0] }}</Message>
                                    </div>
                                </div>
                                <div class="d-flex col-6 my-2">
                                    <div class="col-6">
                                        <label for="status">Status:</label>
                                    </div>
                                    <div class="col-6">
                                        <Select id="status" v-model="buyer.status" placeholder="Select status"
                                            class="w-100" :options="statusOptions" optionLabel="label"
                                            optionValue="value" required />
                                        <Message class="my-2" v-if="errors.status" severity="error">{{ errors.status[0]
                                            }}</Message>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex col-6 my-2">
                                    <div class="col-6">
                                        <label for="companyName">Company Name:</label>
                                    </div>
                                    <div class="col-6">
                                        <InputText class="w-100" id="companyName" v-model="buyer.name" />
                                        <Message class="my-2" v-if="errors.name" severity="error">{{ errors.name[0] }}
                                        </Message>
                                    </div>
                                </div>

                                <div class="d-flex col-6 my-2">
                                    <div class="col-6">
                                        <label for="officePhone">Office Phone/Mobile:</label>
                                    </div>
                                    <div class="col-6">
                                        <InputText class="w-100" id="officePhone" v-model="buyer.officePhone" />
                                        <Message class="my-2" v-if="errors.officePhone" severity="error">{{
                        errors.officePhone[0] }}</Message>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="d-flex col-6 my-2">
                                    <div class="col-6">
                                        <label for="address">Address:</label>
                                    </div>
                                    <div class="col-6">
                                        <Textarea v-model="buyer.address" class="w-100" cols="30" rows="1"></Textarea>
                                        <Message class="my-2" v-if="errors.address" severity="error">{{
                        errors.address[0] }}</Message>
                                    </div>
                                </div>
                                <div class="d-flex col-6 my-2">
                                    <div class="col-6">
                                        <label for="website">Website:</label>
                                    </div>
                                    <div class="col-6">
                                        <InputText id="website" class="w-100" v-model="buyer.website" />
                                        <Message class="my-2" v-if="errors.website" severity="error">{{
                        errors.website[0] }}</Message>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3" v-if="isEditMode">
                                <h3 class="fw-bold" style="color: #14245c;">Contact Person</h3>
                                <DataTable :value="buyer.person" responsiveLayout="scroll"
                                    :paginator="buyer.person.length > 10" :rows="10" dataKey="id" :rowHover="true"
                                    :loading="loader">
                                    <template #loading>
                                        Loading contact persons...
                                    </template>
                                    <template #empty>
                                        No contact persons available
                                    </template>
                                    <Column field="userid" header="User ID" sortable style="min-width:12rem">
                                        <template #body="{ data }">
                                            <router-link :to="{ name: 'edituser', params: { id: data.id } }"
                                                v-if="can('editOrderDetails | voidOrder')"
                                                class="text-success mx-2 btn">
                                                {{ data.id }}
                                            </router-link>
                                        </template>
                                    </Column>
                                    <Column field="name" header="Full Name" sortable style="min-width:12rem"></Column>
                                    <Column field="email" header="Email" sortable style="min-width:12rem"></Column>
                                    <Column field="status" header="Status" sortable style="min-width:12rem">
                                        <template #body="{ data }">
                                            <span
                                                :class="{ 'badge': true, 'bg-success-new': data.status === 'active', 'bg-danger': data.status !== 'active' }">
                                                {{ data.status === 'active' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </template>
                                    </Column>
                                </DataTable>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="buyerDescription" class="form-label">Buyer Description</label>
                            <Textarea id="buyerDescription" v-model="buyer.buyerDescription" class="w-100" rows="3"
                                style="height: 120px;"></Textarea>
                            <Message class="my-2" v-if="errors.buyerDescription" severity="error">{{
                        errors.buyerDescription[0] }}</Message>
                        </div>
                        <div class="form-group col-6 my-2">
                            <label class="form-label">Product Group</label>
                            <div class="form-group">
                                <MultiSelect display="chip" filter placeholder="Select Group" v-model="buyer.group"
                                    class="w-100" :options="productOptions" optionLabel="group_name" optionValue="id"
                                    multiple />
                                <Message class="my-2" v-if="errors.group" severity="error">{{ errors.group[0] }}
                                </Message>
                            </div>
                        </div>
                        <div class="d-flex gap-2 my-2">
                            <Button type="submit" severity="success" label="Submit" class="p-button p-button-primary"
                                style="height: 45px;" />
                            <Button type="reset" severity="warn" label="Clear" class="p-button p-button-warning"
                                style="height: 45px;" />
                        </div>
                    </form>
                </div>
                <div class="col-lg-12" v-if="isEditMode">
                    <div class="card">
                        <div class="card-header pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="col-6">
                                    <span class="mt-2 fw-bold fs-4" style="color: #14245c;">Order History:</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body rounded-top">
                            <DataTable :value="orders" responsiveLayout="scroll" :paginator="orders.length > 10"
                                :rows="10" dataKey="id" :rowHover="true" :loading="loader">
                                <template #loading>
                                    Loading orders...
                                </template>
                                <template #empty>
                                    No orders available
                                </template>
                                <Column field="id" header="Order Number" sortable style="min-width:12rem">
                                    <template #body="{data}">
                                        <router-link :to="{ name: 'order_edit', params: { id: data.id } }"
                                            v-if="can('editOrderDetails | voidOrder')" class="text-success mx-2 btn">
                                            {{ data.id }}
                                        </router-link>
                                    </template>
                                </Column>
                                <Column field="orderdate" header="Order Date" sortable style="min-width:12rem"></Column>
                                <Column field="supplierid.supplier_id" header="Supplier ID" sortable
                                    style="min-width:12rem"></Column>
                                <Column field="quantity_unit" header="Quantity" sortable style="min-width:12rem">
                                </Column>
                                <Column field="article" header="Article Number" sortable style="min-width:12rem">
                                </Column>
                            </DataTable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="loader" class="loader-overlay">
            <div class="loader"></div>
        </div>
    </div>
    <EventLogTable :filterValue="'Buyer'" />
</template>

<script>

export default {
    emits: ['profileUpdated'],
    data() {
        return {
            loader: false,
            productOptions: [],
            statusOptions: [
                { label: 'Active', value: 'active' },
                { label: 'Inactive', value: 'inactive' }
            ],
            buyer: {
                name: '',
                buyer_id: '',
                status: '',
                email: '',
                address: '',
                website: '',
                contact_person: '',
                officePhone: '',
                buyerDescription: '',
                group: []
            },
            errors: [],
            isEditMode: false,
            buyerId: null,
            orders: [],
        };
    },
    methods: {
        async fetchProductOptions() {
            try {
                const response = await axios.get('/api/product_group_get');
                this.productOptions = response.data;
                console.log(this.productOptions);
            } catch (error) {
                console.error(error);
            }
        },
        async fetchBuyerDetails(buyerId) {
            try {
                this.loader = true;
                const response = await axios.get(`/api/buyers/${buyerId}`);
                const buyer = response.data.user;
                this.orders = response.data.orders;
                console.log(buyer, this.orders);

                this.buyer = {
                    name: buyer.name,
                    buyer_id: buyer.buyer_id,
                    email: buyer.email,
                    status: buyer.status,
                    address: buyer.address,
                    website: buyer.website,
                    contact_person: buyer.contact_person,
                    officePhone: buyer.office_phone,
                    buyerDescription: buyer.buyer_description,
                    person: buyer.person,
                    group: buyer.group
                };
                this.loader = false;
            } catch (error) {
                this.loader = false;
                console.error(error);
            }
        },
        async submitForm() {
            this.loader = true;
            this.errors = [];
            const requiredFields = ['name', 'buyer_id', 'address', 'website', 'buyerDescription', 'group'];
            requiredFields.forEach(field => {
                if (!this.buyer[field] || (Array.isArray(this.buyer[field]) && !this.buyer[field].length)) {
                    this.errors.push(`${field.charAt(0).toUpperCase() + field.slice(1)} is required.`);
                }
            });

            if (!this.errors.length) {
                const formData = {
                    ...this.buyer,
                    group: this.buyer.group
                };

                try {
                    let response;
                    if (this.isEditMode) {
                        response = await axios.post(`/api/buyers/${this.buyerId}`, formData);
                    } else {
                        response = await axios.post('/api/addbuyers', formData);
                    }

                    this.resetForm();

                    if (response.status === 201 || response.status === 200) {
                        toastr.success(response.data.message);
                        this.$router.push({ name: 'Databuyer' });
                    } else {
                        toastr.error('Unexpected response from the server');
                    }
                    this.loader = false;
                } catch (error) {
                    this.loader = false;
                    console.error(error);
                    if (error.response && error.response.status === 422) {
                        const validationErrors = error.response.data.errors;
                        this.errors = validationErrors;
                        Object.values(validationErrors).forEach(errorMessage => {
                            toastr.error(errorMessage[0]);
                        });
                    } else {
                        toastr.error('An error occurred while saving the buyer');
                    }
                }
            } else {
                this.loader = false;
                this.errors.forEach(error => {
                    toastr.error(error);
                });
                toastr.options = {
                    'closeButton': true,
                    'timeOut': '3000'
                }
            }
        },
        resetForm() {
            this.buyer = {
                name: '',
                buyer_id: '',
                email: '',
                address: '',
                website: '',
                contact_person: '',
                officePhone: '',
                buyerDescription: '',
                group: []
            };
            this.errors = [];
        }
    },
    async mounted() {
        await this.fetchProductOptions();
        this.buyer.status = 'active';
        if (this.$route.params.id) {
            this.isEditMode = true;
            this.buyerId = this.$route.params.id;
            await this.fetchBuyerDetails(this.buyerId);
        }
    },
    computed: {
        userIdPatternValid() {
            const pattern = /^[a-zA-Z0-9]{1,10}$/;
            return pattern.test(this.buyer.buyer_id);
        }
    }
};
</script>



<style>
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #14245c !important;
    color: white;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remov {
    float: right !important;
    margin-left: 5px !important;
    margin-right: -2px !important;
}

.table {
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 20px;

    border-radius: 10px 10px 0 0;
    overflow: hidden;
}
</style>
