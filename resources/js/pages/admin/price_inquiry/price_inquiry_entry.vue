<template>
    <section class="section">
        <form @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="d-flex justify-content-between">
                <button class="btn btn-secondary ms-4" type="button" @click="$router.back()">Back</button>
                <button class="btn btn-primary px-4 me-4 " @click="this.save = true;">Save</button>
            </div>

            <div class="container">
                <div class="row my-5">
                    <h3 class="text-milung mb-4 fw-bold text-uppercase">Price Inquiry</h3>

                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Buyer ID<span class="text-danger">*</span>:</p>
                            </div>
                            <div class="col-8">
                                <Select v-model="draftData.inquiry.buyer" optionLabel="buyer_id" filter optionValue="id"
                                    placeholder="Select Buyer" class="w-100" :options="buyers" />
                                <Message severity="error" class="my-1" v-if="errors.buyer">{{ errors.buyer[0] }}
                                </Message>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Inquiry Number<span class="text-danger">*</span>:</p>
                            </div>
                            <div class="col-8">
                                <InputText v-model="draftData.inquiry.inquiry_number" class="w-100" />
                                <Message severity="error" class="my-1" v-if="errors.inquiry_number">{{
                                    errors.inquiry_number[0] }}</Message>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Article Number<span class="text-danger">*</span>:</p>
                            </div>
                            <div class="col-8">
                                <InputText v-model="draftData.inquiry.article" class="w-100" />
                                <Message severity="error" class="my-1" v-if="errors.article">{{ errors.article[0] }}
                                </Message>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Group:</p>
                            </div>
                            <div class="col-8">
                                <Select v-model="draftData.inquiry.group" :options="groups" optionLabel="group_name"
                                    optionValue="id" placeholder="Select a product group" class="w-100"
                                    @change="fetchSupplierProfiles(draftData.inquiry.group)" />
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Name<span class="text-danger">*</span>:</p>
                            </div>
                            <div class="col-8">
                                <InputText v-model="draftData.inquiry.name" class="w-100" />
                                <Message severity="error" class="my-1" v-if="errors.name">{{ errors.name[0] }}</Message>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Description/Specification<span class="text-danger">*</span>:
                                </p>
                            </div>
                            <div class="col-8">
                                <Textarea v-model="draftData.inquiry.description" class="w-100" rows="10" />
                                <Message severity="error" class="my-1" v-if="errors.description">{{
                                    errors.description[0] }}</Message>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Cargo Classification<span class="text-danger">*</span>:</p>
                            </div>
                            <div class="col-8">
                                <div class="d-flex">
                                    <RadioButton class="mx-2" inputId="generalCargo" v-model="draftData.inquiry.cargo"
                                        value="general" />
                                    <label for="generalCargo" class="ml-2">General Cargo</label>
                                    <RadioButton class="mx-2" inputId="dangerCargo" v-model="draftData.inquiry.cargo"
                                        value="danger" />
                                    <label for="dangerCargo" class="ml-2">Danger Goods</label>
                                </div>
                                <div class="d-flex my-2">
                                    <Checkbox class="mx-2" inputId="hongkong" v-model="cargo_place" value="hongkong" />
                                    <label for="hongkong" class="ml-2">Hong Kong</label>
                                    <Checkbox inputId="china" v-model="cargo_place" value="china" class="mx-2" />
                                    <label for="china" class="ml-2">Mainland China</label>
                                </div>
                                <Message severity="error" class="my-1" v-if="errors.cargo">{{ errors.cargo[0] }}
                                </Message>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Incoterm<span class="text-danger">*</span>:</p>
                            </div>
                            <div class="col-8">
                                <InputText v-model="draftData.inquiry.incoterm" class="w-100" />
                                <Message severity="error" class="my-1" v-if="errors.incoterm">{{ errors.incoterm[0] }}
                                </Message>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model">Inquiry Quantity<span class="text-danger">*</span>:</p>
                            </div>
                            <div class="col-8">
                                <div v-for="(material, index) in materials" :key="index"
                                    class="d-flex align-items-center my-2">
                                    <input type="number" v-model="materials[index].quantity" class="w-75 form-control"
                                        @input="updateInquiryMaterials" />
                                    <span class="mx-2 fw-bold" style="color: #41b400;">Pcs</span>
                                    <div class="input-buttons">
                                        <Button icon="pi pi-plus" class="p-button-warning ml-2"
                                            @click="addMaterial(index)" v-if="index === 0" />
                                        <Button icon="pi pi-minus" class="p-button-danger ml-2"
                                            @click="removeMaterial(index)" v-if="index !== 0 && materials.length > 1" />
                                    </div>
                                </div>
                                <Message severity="error" class="my-1" v-if="errors.pcs">{{ errors.pcs[0] }}</Message>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Capacity<span class="text-danger">*</span>:</p>
                            </div>
                            <div class="col-8">
                                <div v-for="(caps, indexs) in capacity" :key="indexs"
                                    class="d-flex align-items-center my-2">
                                    <input type="number" v-model="capacity[indexs].quantity" class="w-75 form-control"
                                        @input="updateInquiryCapacity" />
                                    <Select v-model="capacity[indexs].unit" :options="['GB', 'mAh']"
                                        @select="updateInquiryCapacity" class="w-25 mx-2" />
                                    <div class="input-buttons">
                                        <Button icon="pi pi-plus" class="p-button-warning ml-2"
                                            @click="addcapacity(indexs)" v-if="indexs === 0" />
                                        <Button icon="pi pi-minus" class="p-button-danger ml-2"
                                            @click="removecapacity(indexs)"
                                            v-if="indexs !== 0 && capacity.length > 1" />
                                    </div>
                                </div>
                                <Message severity="error" class="my-1" v-if="errors.capacity">{{ errors.capacity[0] }}
                                </Message>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Printing Method<span class="text-danger">*</span>:</p>
                            </div>
                            <div class="col-8">
                                <InputText v-model="draftData.inquiry.method" class="w-100" />
                                <Message severity="error" class="my-1" v-if="errors.method">{{ errors.method[0] }}
                                </Message>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Printing Color:</p>
                            </div>
                            <div class="col-8">
                                <InputText v-model="draftData.inquiry.color" class="w-100" />
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Standard Packaging:</p>
                            </div>
                            <div class="col-8">
                                <InputText v-model="draftData.inquiry.packaging" class="w-100" />
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Special Requirement:</p>
                            </div>
                            <div class="col-8">
                                <Textarea v-model="draftData.inquiry.requirements" class="w-100" rows="10" />
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" class="my-1">Status<span class="text-danger">*</span>:</p>
                            </div>
                            <div class="col-8">
                                <Select v-model="draftData.inquiry.status"
                                    :options="['ML Checking', 'Supplier Checking', 'ML Follow Up', 'Supplier Follow Up', 'Supplier Replied', 'ML Quoted']"
                                    class="w-100" />
                                <Message severity="error" class="my-1" v-if="errors.status">{{ errors.status[0] }}
                                </Message>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Notice:</p>
                            </div>
                            <div class="col-8">
                                <input class="form-check-input " id="urgent" type="checkbox"
                                    v-model="draftData.inquiry.urgent" />
                                <label for="urgent" class="mx-2">Urgent</label>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Buyer Product Photo/3D Artwork:</p>
                                <button @click="importImage" type="button" class="btn px-4 btn-milung">
                                    Import
                                </button>
                                <button type="button" class="btn px-4 btn-primary my-2">
                                    Export
                                </button>
                            </div>
                            <div class="col-8">
                                <input ref="fileInput" type="file" class="form-control d-none" accept=".jpg,.png">
                                <canvas ref="canvas" width="322" height="300" class="border border-2"></canvas>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Supplier Product Photo/3D Artwork:</p>
                                <button @click="importImage1" type="button" class="btn px-4 btn-milung">
                                    Import
                                </button>
                                <button type="button" class="btn px-4 btn-primary my-2">
                                    Export
                                </button>
                            </div>
                            <div class="col-8">
                                <input ref="fileInput1" type="file" class="form-control d-none" accept=".jpg,.png">
                                <canvas ref="canvas1" width="322" height="300" class="border border-2"></canvas>
                            </div>
                        </div>

                        <div class="col-12 my-2">
                            <div class="row ms-2">
                                <Button label="Send To Supplier" class="p-button-sm p-button-milung m-2 col-3"
                                    @click="openSupplierModal" />
                                <Button v-show="follow_up" label="Follow Up" severity="warn"
                                    class="p-button-sm p-button-warning m-2 col-3 text-white" @click="followup" />
                                <Button v-show="follow_up" label="Quote Buyer"
                                    class="p-button-sm p-button-info m-2 col-3" :disabled="!supplierInquiry.length"
                                    @click="quote" :style="{ backgroundColor: supplierInquiry.length ? 'aqua' : '' }" />

                                <Button v-show="follow_up" label="Create Order"
                                    class="p-button-sm p-button-milung m-2 col-3"
                                    style="background-color: #bc7803; border-color: #bc7803;"
                                    @click="openOrderModal()" />

                                <Button v-show="follow_up" severity="success" label="Supplier To Buyer"
                                    class="p-button-sm p-button-milung m-2 col-3" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Supplier Inquiry Quote Table -->
                <div class="row" v-for="(rows, index) in supplierData" :key="index"
                    v-if="supplierData && Object.keys(supplierData).length > 0">
                    <h3 class="text-milung mb-4 fw-bold text-uppercase">{{ index }} Inquiry Quote</h3>
                    <div class="">
                        <RadioButton v-model="selectedSupplier" :value="index" @change="selectAllRows(index)">
                        </RadioButton>
                        <label class="mx-2">Select
                            All for {{ index }}
                        </label>
                    </div>
                    <DataTable :value="rows" class="w-100">
                        <Column header="Product Capacity">
                            <template #body="slotProps">
                                <div class="flex flex-wrap gap-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" v-model="supplierInquiry"
                                            :disabled="selectedSupplier !== null && selectedSupplier !== slotProps.index"
                                            :value="slotProps.data.id" :checked="!!slotProps.data.selected">
                                        <label class="form-check-label">
                                            {{ slotProps.data.capacity }}
                                        </label>
                                    </div>
                                </div>
                            </template>
                        </Column>

                        <Column field="quantity" header="Quantity" />
                        <Column field="currency" header="Currency"> <template #body="slotProps">
                                <span>USD</span>
                            </template></Column>
                        <Column field="exw" header="EXW Price"
                            :body="(row) => row.exw || '<span class=\'fst-italic text-muted\'>Not Provided</span>'" />
                        <Column field="remarks" header="Remarks"
                            :body="(row) => row.supplierremarks?.remarks || '<span class=\'fst-italic text-muted\'>Not Provided</span>'"
                            :rowspan="totalRows" v-show="index === 0" />
                    </DataTable>
                </div>
            </div>

            <!-- Modals -->
            <!-- Supplier Modal -->
            <Dialog header="Select Supplier" v-model:visible="showSupplierModal" :style="{ width: '450px' }"
                :modal="true">
                <div class="my-2" v-for="(supplier, index) in supplier_profiles" :key="index">
                    <input class="form-check-input mx-2" type="checkbox" :value="supplier.id" :id="supplier.id"
                        :checked="mode === 'edit' ? isSupplierIdChecked(supplier.id) : false"
                        v-model="supplier.checked">
                    <label for="flexCheckDefault" class="ml-2">{{ supplier.name }}</label>
                </div>
                <Button label="Create Inquiry" class="my-2" @click="closeSupplierModal" />
            </Dialog>

            <!-- Create Order Modal -->
            <Dialog header="Select Quantity and Capacity" v-model:visible="showOrderModal" :style="{ width: '450px' }"
                :modal="true">
                <div class="mb-3">
                    <label for="quantity" class="form-label mx-2">Select Quantity</label>
                    <Select v-model="selectedQuantity" class="w-100" :options="materials.map((m) => m.quantity)" />
                </div>
                <div class="mb-3">
                    <label for="capacity" class="form-label mx-2">Select Capacity</label>
                    <Select v-model="selectedCapacity" class="w-100"
                        :options="capacity.map((c) => `${c.quantity} ${c.unit}`)" />
                </div>
                <Button label="Create Order" class="p-button-primary" @click="createOrder(draftData.inquiry)" />
            </Dialog>
        </form>
        <EventLogTable :filterValue="'Inquiry'" />
    </section>

    <div v-if="loader" class="loader-overlay">
        <div class="loader"></div>
    </div>
</template>

<script>
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';
import swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import draftMixin from '@/mixins/draftMixin';

export default {
    mixins: [draftMixin],
    emits: ['profileUpdated'],

    props: {
        mode: {
            type: String,
            required: false, // "create" or "edit"
        },
        draftKey: {
            type: String,
            default: 'priceInquiry', // Unique key for this draft
        },
        initialData: {
            type: Object,
            default: () => ({
                buyer: null,
                inquiry: {
                    urgent: false,
                    materials: [{ quantity: 0 }],
                    capacity: [{ quantity: 0, unit: '' }],
                    inquiry_number: '',
                    article: '',
                    group: null,
                    name: '',
                    description: '',
                    cargo: '',
                    cargo_place: [],
                    incoterm: '',
                    method: '',
                    color: '',
                    packaging: '',
                    requirements: '',
                    status: '',
                    // Add any other fields as needed
                },
                // Include other data properties if necessary
            }),
        },
        recordId: {
            type: [String, Number],
            default: null,
        },
    },
    data() {
        return {
            materials: [{ quantity: 0 }],
            capacity: [{ quantity: 0, unit: '' }],
            cargo_place: [],
            supplierData: {},
            selectedSupplier: null,
            selectedQuantity: null,
            selectedCapacity: null,
            buyers: [],
            buyer: null,
            errors: [],
            groups: [],
            supplierInquiry: [],
            supplier_profiles: [],
            follow_up: false,
            showSupplierModal: false,
            showOrderModal: false,
            loader: false,
        };
    },
    methods: {
        openSupplierModal() {
            this.showSupplierModal = true;
        },
        closeSupplierModal() {
            this.showSupplierModal = false;
            this.onSubmit();
        },
        openOrderModal() {
            this.showOrderModal = true;
        },
        closeOrderModal() {
            this.showOrderModal = false;
        },
        selectAllRows(supplierIndex) {
            this.supplierData[supplierIndex].forEach(row => {
                row.selected = true;
            });
            Object.keys(this.supplierData).forEach(key => {
                if (key !== supplierIndex) {
                    this.supplierData[key].forEach(row => {
                        row.selected = false;
                        row.disabled = true;
                    });
                } else {
                    this.supplierData[key].forEach(row => {
                        row.disabled = false;
                    });
                }
            });
        },
        createOrder(inquiry) {
            const inquiryData = {
                ...this.draftData.inquiry,
                selectedQuantity: this.selectedQuantity,
                selectedCapacity: this.selectedCapacity
            };
            this.$store.dispatch('updateInquiry', inquiryData);
            this.$router.push({
                name: 'order_entry',
            });
        },
        updateInquiryMaterials() {
            this.draftData.inquiry.materials = this.materials.map(material => ({ quantity: material.quantity }));
        },
        updateInquiryCapacity() {
            this.draftData.inquiry.capacity = this.capacity.map(capacity => ({ quantity: capacity.quantity, unit: capacity.unit }));
        },
        followup() {
            NProgress.start();
            this.loader = true;
            const inquiryid = this.$route.params.id;
            console.log(inquiryid);
            axios.get(`/api/inquiry_followup/${inquiryid}`) // Replace '/api/supplier_profiles/' with your API endpoint
                .then(response => {

                    console.log(response);
                    this.loader = false;
                    toastr.success(response.data.message);
                    this.inquiry.status = 'ML Follow Up';
                    NProgress.done();
                })
                .catch(error => {
                    console.error(error);
                    this.loader = false;
                    NProgress.done();
                });
        },
        async quote() {
            if (!this.supplierInquiry.length) {
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select at least one quote from the supplier!',
                });
                NProgress.done();
                this.loader = false;
                return;
            }
            const inquiryid = this.$route.params.id;
            let formData;
            if (this.selectedSupplier) {
                formData = {
                    quoteIds: this.supplierData[this.selectedSupplier].map(row => row.id)
                };
            } else {
                formData = {
                    quoteIds: this.supplierInquiry
                };
            }

            try {
                this.loader = true;
                const response = await axios.post(`/api/inquiry/quote/${inquiryid}`, formData);
                this.loader = false;
                toastr.success(response.data.message);
                this.fetchInquiry();
            } catch (error) {
                this.loader = false;
                console.error(error);
            }
        },
        fetchBuyers() {
            axios.get('/api/buyerOrder')
                .then(response => {
                    this.buyers = response.data;
                    const selectedbuyerIds = Number(this.draftData.inquiry.buyer);
                    const selectedbuyer = this.buyers.find(buyer => buyer.id === selectedbuyerIds);
                    if (selectedbuyer) {
                        this.buyer = selectedbuyer;
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        },
        fetchSupplierProfiles(groupId) {
            NProgress.start();
            axios.get(`/api/supplier_profiles/${groupId}`)
                .then(response => {
                    if (this.draftData.inquiry.supplier_ids) {
                        const supplierIds = this.draftData.inquiry.supplier_ids.map(id => Number(id));
                        this.supplier_profiles = response.data.map(supplier => {
                            const supplierId = Number(supplier.id);
                            supplier.checked = supplierIds.includes(supplierId);
                            return supplier;
                        });
                    } else {
                        this.supplier_profiles = response.data;
                    }
                    NProgress.done();
                })
                .catch(error => {
                    console.error(error);
                    NProgress.done();
                });
        },
        fetchProductGroups() {
            NProgress.start();
            axios.get('/api/product_group_get')
                .then(response => {
                    this.groups = response.data;
                    NProgress.done();
                })
                .catch(error => {
                    console.error(error);
                    NProgress.done();
                });
        },
        addMaterial() {
            this.materials.push({ quantity: '' });
        },
        removeMaterial(index) {
            this.materials.splice(index, 1);
        },
        addcapacity() {
            this.capacity.push({ quantity: '' });
        },
        removecapacity(index) {
            this.capacity.splice(index, 1);
        },
        importImage() {
            this.$refs.fileInput.click();
        },
        loadImage(event) {
            const file = event.target.files[0];
            if (file) {
                const canvas = this.$refs.canvas;
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                const reader = new FileReader();
                reader.onload = (event) => {
                    const img = new Image();
                    img.onload = () => {
                        const aspectRatio = canvas.width / canvas.height;
                        let newWidth, newHeight;
                        if (img.width > img.height) {
                            newWidth = canvas.width;
                            newHeight = (img.height * newWidth) / img.width;
                        } else {
                            newHeight = canvas.height;
                            newWidth = (img.width * newHeight) / img.height;
                        }
                        ctx.drawImage(img, 0, 0, newWidth, newHeight);
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        importImage1() {
            this.$refs.fileInput1.click();
        },
        loadImage1(event) {
            const file = event.target.files[0];
            if (file) {
                const canvas = this.$refs.canvas1;
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                const reader = new FileReader();
                reader.onload = (event) => {
                    const img = new Image();
                    img.onload = () => {
                        const aspectRatio = canvas.width / canvas.height;
                        let newWidth, newHeight;
                        if (img.width > img.height) {
                            newWidth = canvas.width;
                            newHeight = (img.height * newWidth) / img.width;
                        } else {
                            newHeight = canvas.height;
                            newWidth = (img.width * newHeight) / img.height;
                        }
                        ctx.drawImage(img, 0, 0, newWidth, newHeight);
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        handleValidationErrors(validationErrors) {
            for (const key in validationErrors) {
                if (validationErrors.hasOwnProperty(key)) {
                    const messages = validationErrors[key];
                    messages.forEach(message => {
                        toastr.error(message);
                    });
                }
            }
        },
        async onSubmit() {
            NProgress.start();
            this.loader = true;
            try {
                const formData = new FormData();
                formData.append('buyer', this.draftData.inquiry.buyer);
                formData.append('save', this.save);
                formData.append('inquiry_number', this.draftData.inquiry.inquiry_number);
                formData.append('article', this.draftData.inquiry.article);
                formData.append('name', this.draftData.inquiry.name);
                formData.append('description', this.draftData.inquiry.description);
                formData.append('cargo', this.draftData.inquiry.cargo);
                this.cargo_place.forEach(place => {
                    formData.append('cargo_place[]', place);
                });
                formData.append('incoterm', this.draftData.inquiry.incoterm);
                formData.append('urgent', this.draftData.inquiry.urgent ? 'true' : 'false');
                formData.append('method', this.draftData.inquiry.method);
                if (this.draftData.inquiry.color !== null && this.draftData.inquiry.color !== undefined) {
                    formData.append('color', this.draftData.inquiry.color);
                }
                if (this.draftData.inquiry.group !== null && this.draftData.inquiry.group !== undefined) {
                    formData.append('group', this.draftData.inquiry.group);
                }
                if (this.draftData.inquiry.packaging !== null && this.draftData.inquiry.packaging !== undefined) {
                    formData.append('packaging', this.draftData.inquiry.packaging);
                }
                if (this.draftData.inquiry.requirements !== null && this.draftData.inquiry.requirements !== undefined) {
                    formData.append('requirements', this.draftData.inquiry.requirements);
                }
                formData.append('status', this.draftData.inquiry.status);
                if (this.$refs.fileInput.files[0]) {
                    formData.append('file', this.$refs.fileInput.files[0]);
                }

                if (this.$refs.fileInput1.files[0]) {
                    formData.append('file1', this.$refs.fileInput1.files[0]);
                };

                this.selectedSupplierIds.forEach(id => {
                    formData.append('supplier_ids[]', id);
                });

                for (let i = 0; i < this.draftData.inquiry.materials.length; i++) {
                    formData.append(`pcs[${i}]`, this.draftData.inquiry.materials[i].quantity);
                }

                this.capacity.forEach((caps, index) => {
                    const capacityString = `${caps.quantity}${caps.unit}`;
                    console.log(caps);

                    formData.append(`capacity[${index}]`, capacityString);
                });

                const inquiryid = this.$route.params.id;
                const url = this.mode === 'edit' ? `/api/update_price_inquiry/${inquiryid}` : '/api/price_inquiry';
                const method = 'post';
                const response = await axios[method](url, formData);

                this.loader = false;
                if (response.status === 201 || response.status === 200) {
                    NProgress.done();
                    toastr.success(response.data.message);
                    this.clearDraft(this.generateDraftKey());
                    this.$router.push({ name: 'price_inquiry' });
                } else {
                    NProgress.done();
                    toastr.error('Something is not correct');
                }

            } catch (error) {
                this.loader = false;
                NProgress.done();
                if (error.response && error.response.status === 422) {
                    const validationErrors = error.response.data.errors;
                    this.errors = validationErrors;
                    this.handleValidationErrors(validationErrors);
                } else {
                    console.error(error);
                    toastr.error('An error occurred while adding the user');
                }
            }
        },
        loadImageFromPath(imageFileName, canvas) {
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas context

            // Construct the URL to the file in the storage folder
            const imageUrl = `/storage/files/${imageFileName}`;
            // console.log(imageUrl,ctx);

            const img = new Image();
            img.onload = () => {
                const aspectRatio = canvas.width / canvas.height;
                let newWidth, newHeight;
                if (img.width > img.height) {
                    newWidth = canvas.width;
                    newHeight = (img.height * newWidth) / img.width;
                } else {
                    newHeight = canvas.height;
                    newWidth = (img.width * newHeight) / img.height;
                }
                ctx.drawImage(img, 0, 0, newWidth, newHeight);
                console.log('Image loaded and drawn onto the canvas successfully.');
            };
            img.src = imageUrl;
        },
        fetchInquiry() {
            const inquiryid = this.$route.params.id;
            axios.get('/api/price_inquiry_get/' + inquiryid)
                .then(response => {
                    this.draftData.inquiry = response.data.price;
                    this.supplierData = response.data.users;
                    console.log(response.data);


                    if (this.draftData.inquiry != null) {
                        this.cargo_place = this.draftData.inquiry.cargo_place || [];
                        this.loadImageFromPath(this.draftData.inquiry.file, this.$refs.canvas);

                        if (this.draftData.inquiry.file1 != null) {
                            this.loadImageFromPath(
                                this.draftData.inquiry.file1,
                                this.$refs.canvas1
                            );
                        }

                        this.materials = this.draftData.inquiry && this.draftData.inquiry.pcs ? this.draftData.inquiry.pcs.map(quantity => ({ quantity })) : [{ quantity: '' }];
                        this.capacity = this.draftData.inquiry && this.draftData.inquiry.capacity
                            ? this.draftData.inquiry.capacity.map(capacity => {
                                const match = capacity.match(/(\d+)([a-zA-Z]+)/); // Extract quantity and unit from combined value
                                if (match) {
                                    const [quantity, unit] = match.slice(1);
                                    return { quantity: parseInt(quantity), unit }; // Parse quantity to integer and keep unit as extracted
                                }
                                // Return a default object if the pattern does not match
                                return { quantity: '', unit: '' };
                            })
                            : [{ quantity: '', unit: '' }];

                    }

                    this.draftData.buyer = Number(this.draftData.inquiry.buyer);
                    this.draftData.inquiry.group = Number(this.draftData.inquiry.group);
                    if (this.draftData.inquiry.group) {
                        this.fetchSupplierProfiles(this.draftData.inquiry.group);
                    }
                    this.updateInquiryMaterials();
                    this.updateInquiryCapacity();
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },
    computed: {
        totalRows() {
            return this.draftData.inquiry.capacity.length * this.draftData.inquiry.pcs.length;
        },
        selectedSupplierIds() {
            return this.supplier_profiles
                .filter(supplier => supplier.checked)
                .map(supplier => supplier.id);
        },
    },
    mounted() {
        NProgress.configure({ showSpinner: false });

        this.fetchProductGroups();
        this.fetchBuyers();

        if (this.mode === 'edit') {
            this.fetchInquiry();
            this.follow_up = true;
        }

        this.$refs.fileInput.addEventListener('change', this.loadImage);
        this.$refs.fileInput1.addEventListener('change', this.loadImage1);
    },
    beforeUnmount() {
        this.$refs.fileInput.removeEventListener('change', this.loadImage);
        this.$refs.fileInput1.removeEventListener('change', this.loadImage1);
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
    display: flex;
    justify-content: center;
    align-items: center;
    backdrop-filter: blur(5px);
    z-index: 9999;
}

.loader {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 2s linear infinite;
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
