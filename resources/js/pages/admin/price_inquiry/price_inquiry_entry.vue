<template>
    <section class="section">
        <form @submit.prevent="onSubmit" enctype="multipart/form-data">
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
                                <Select v-model="buyer" optionLabel="buyer_id" optionValue="id"
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
                                <InputText v-model="inquiry.inquiry_number" class="w-100" />
                                <Message severity="error" class="my-1" v-if="errors.inquiry_number">{{
            errors.inquiry_number[0] }}</Message>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Article Number<span class="text-danger">*</span>:</p>
                            </div>
                            <div class="col-8">
                                <InputText v-model="inquiry.article" class="w-100" />
                                <Message severity="error" class="my-1" v-if="errors.article">{{ errors.article[0] }}
                                </Message>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Group:</p>
                            </div>
                            <div class="col-8">
                                <Select v-model="inquiry.group" :options="groups" optionLabel="group_name"
                                    optionValue="id" placeholder="Select a product group" class="w-100"
                                    @change="fetchSupplierProfiles(inquiry.group)" />
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Name<span class="text-danger">*</span>:</p>
                            </div>
                            <div class="col-8">
                                <InputText v-model="inquiry.name" class="w-100" />
                                <Message severity="error" class="my-1" v-if="errors.name">{{ errors.name[0] }}</Message>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Description/Specification<span class="text-danger">*</span>:
                                </p>
                            </div>
                            <div class="col-8">
                                <Textarea v-model="inquiry.description" class="w-100" rows="10" />
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
                                    <RadioButton class="mx-2" inputId="generalCargo" v-model="inquiry.cargo"
                                        value="general" />
                                    <label for="generalCargo" class="ml-2">General Cargo</label>
                                    <RadioButton class="mx-2" inputId="dangerCargo" v-model="inquiry.cargo"
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
                                <InputText v-model="inquiry.incoterm" class="w-100" />
                                <Message severity="error" class="my-1" v-if="errors.incoterm">{{ errors.incoterm[0] }}
                                </Message>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
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
                                <InputText v-model="inquiry.method" class="w-100" />
                                <Message severity="error" class="my-1" v-if="errors.method">{{ errors.method[0] }}
                                </Message>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Printing Color:</p>
                            </div>
                            <div class="col-8">
                                <InputText v-model="inquiry.color" class="w-100" />
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Standard Packaging:</p>
                            </div>
                            <div class="col-8">
                                <InputText v-model="inquiry.packaging" class="w-100" />
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Special Requirement:</p>
                            </div>
                            <div class="col-8">
                                <Textarea v-model="inquiry.requirements" class="w-100" rows="10" />
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
                                <Select v-model="inquiry.status"
                                    :options="['ML Checking', 'Supplier Checking', 'Buyer Follow Up', 'Supplier Follow Up', 'Supplier Replied', 'ML Quoted']"
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
                                <input class="form-check-input " id="urgent" type="checkbox" v-model="inquiry.urgent" />
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
                                <Button v-show="follow_up" label="Follow Up"
                                    class="p-button-sm p-button-warning m-2 col-3 text-white" @click="followup" />
                                <Button v-show="follow_up" label="Quote Buyer"
                                    class="p-button-sm p-button-info m-2 col-3" :disabled="!supplierInquiry.length"
                                    @click="quote" :style="{ backgroundColor: supplierInquiry.length ? 'aqua' : '' }" />

                                <Button v-show="follow_up" label="Create Order"
                                    class="p-button-sm p-button-milung m-2 col-3" style="background-color: #bc7803;"
                                    @click="openOrderModal()" />

                                <Button v-show="follow_up" label="Supplier To Buyer"
                                    class="p-button-sm p-button-milung m-2 col-3" style="background-color: #41b400;" />
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
                        <Column field="currency" header="Currency" :body="() => 'USD'" />
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
                <Button label="Create Order" class="p-button-primary" @click="createOrder(inquiry)" />
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

export default {
    emits: ['profileUpdated'],

    props: {
        mode: String, // "create" or "edit"

    },
    data() {
        return {
            selectedSupplier: null,
            selectedQuantity: null,
            selectedCapacity: null,
            loader: false,
            inquiry: {
                urgent: false,
                materials: [{ quantity: 0 }], // Initialize with default values
                capacity: [{ quantity: 0, unit: '' }],
            },
            cargo_place: [],
            supplierData: {},
            materials: [{ quantity: 0 }],
            capacity: [{ quantity: 0, unit: '' }],
            selectedBuyerId: [],
            buyers: [],
            buyer: '',
            imageLoaded: false,
            groups: [],
            errors: [],
            supplierInquiry: [],
            supplier_profiles: [],
            follow_up: false,
            showSupplierModal: false,
            showOrderModal: false,
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
            // Uncheck and disable all other suppliers' rows
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
                ...this.inquiry,
                selectedQuantity: this.selectedQuantity,
                selectedCapacity: this.selectedCapacity
            };
            this.$store.dispatch('updateInquiry', inquiryData);
            this.$router.push({
                name: 'order_entry',
                // query: { inquiry: JSON.stringify(inquiry) },
            });
        },

        precheckSelected() {
            console.log(this.supplierData);
            Object.values(this.supplierData).forEach(rows => {
                rows.forEach(row => {
                    if (row.selected) {
                        this.supplierInquiry.push(row.id);
                    }
                });
            });
        },
        isSupplierIdChecked(supplierId) {
            // const index = this.selectedSupplierIds.indexOf(supplierId);
            // if (index === -1) {
            //     this.selectedSupplierIds.push(supplierId);
            // } else {
            //     this.selectedSupplierIds.splice(index, 1);
            // }
            // console.log( this.inquiry.supplier_ids.some(id => id.toString() === supplierId.toString()));
            return this.inquiry.supplier_ids.some(id => id.toString() === supplierId.toString());
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
            console.log(this.supplierInquiry, this.selectedSupplier);
            if (inquiryid) {
                let formData
                if (this.selectedSupplier) {
                    formData = {
                        // quoteIds: this.supplierInquiry
                        quoteIds: this.supplierData[this.selectedSupplier].map(row => row.id)
                    };

                } else {
                    formData = {
                        quoteIds: this.supplierInquiry
                    };
                }
                try {
                    this.loader = true;
                    const response = await axios.post('/api/inquiry/quote/' + inquiryid, formData);
                    console.log(response);
                    this.loader = false;
                    toastr.success(response.data.message)
                    this.fetchInquiry();
                } catch (error) {
                    this.loader = false;
                    console.error(error);
                    // Handle the error if needed
                }
            }
        },
        updateInquiryMaterials() {
            this.inquiry.materials = this.materials.map(material => ({ quantity: material.quantity }));
        },
        updateInquiryCapacity() {
            this.inquiry.capacity = this.capacity.map(capacity => ({ quantity: capacity.quantity, unit: capacity.unit }));
            console.log(this.capacity, this.inquiry.capacity);
        },
        fetchBuyers() {
            axios.get('/api/buyerOrder')
                .then(response => {
                    this.buyers = response.data;
                    console.log(this.buyers);
                    const selectedbuyerIds = Number(this.inquiry.buyer);
                    const selectedbuyer = this.buyers.find(buyer => buyer.id === selectedbuyerIds);
                    if (selectedbuyer) {
                        this.selectedBuyerId = selectedbuyer;
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        },
        fetchSupplierProfiles(groupId) {
            NProgress.start();
            console.log(groupId);
            axios.get(`/api/supplier_profiles/${groupId}`) // Replace '/api/supplier_profiles/' with your API endpoint
                .then(response => {
                    if (this.inquiry.supplier_ids) {

                        const supplierIds = this.inquiry.supplier_ids.map(id => Number(id));

                        this.supplier_profiles = response.data.map(supplier => {
                            const supplierId = Number(supplier.id);

                        supplier.checked = supplierIds.includes(supplierId);
                        supplier.checked = supplierIds.includes(supplierId);
                        // console.log('Checked:', supplier.checked, 'for Supplier:', supplier,this.inquiry.supplier_ids.includes(supplierId));
                            supplier.checked = supplierIds.includes(supplierId);
                        // console.log('Checked:', supplier.checked, 'for Supplier:', supplier,this.inquiry.supplier_ids.includes(supplierId));

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
                    NProgress.done();
                })
                .catch(error => {
                    console.error(error);
                    this.loader = false;
                    NProgress.done();
                });
        },
        fetchProductGroups() {
            NProgress.start();
            axios.get('/api/product_group_get') // Replace '/api/product-groups' with your API endpoint
                .then(response => {
                    this.groups = response.data;
                    console.log(response);
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
                ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas context

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
            } else {
                console.log('event', this.file);
                this.loadImageFromPath(this.file, this.$refs.canvas);
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

        importImage1() {
            this.$refs.fileInput1.click();
        },
        loadImage1(event) {
            const file = event.target.files[0];
            if (file) {
                const canvas = this.$refs.canvas1;
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas context

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
            // Assuming you have a function to display toastr error messages
            for (const key in validationErrors) {
                if (validationErrors.hasOwnProperty(key)) {
                    const messages = validationErrors[key];
                    // Display each validation error message
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
                formData.append('buyer', this.buyer);
                formData.append('inquiry_number', this.inquiry.inquiry_number);
                formData.append('article', this.inquiry.article);
                formData.append('group', this.inquiry.group);
                formData.append('name', this.inquiry.name);
                formData.append('description', this.inquiry.description);
                formData.append('cargo', this.inquiry.cargo);
                this.cargo_place.forEach(place => {
                    formData.append('cargo_place[]', place);
                });
                formData.append('incoterm', this.inquiry.incoterm);
                formData.append('urgent', this.inquiry.urgent ? 'true' : 'false' );
                formData.append('method', this.inquiry.method);
                formData.append('color', this.inquiry.color);
                formData.append('packaging', this.inquiry.packaging);
                formData.append('requirements', this.inquiry.requirements);
                formData.append('status', this.inquiry.status);
                if (this.$refs.fileInput.files[0]) {
                    formData.append('file', this.$refs.fileInput.files[0]);
                }

                if (this.$refs.fileInput1.files[0]) {
                    formData.append('file1', this.$refs.fileInput1.files[0]);
                };

                this.selectedSupplierIds.forEach(id => {
                    formData.append('supplier_ids[]', id);
                });

                for (let i = 0; i < this.inquiry.materials.length; i++) {
                    formData.append(`pcs[${i}]`, this.inquiry.materials[i].quantity);
                }

                this.capacity.forEach((caps, index) => {
                    const capacityString = `${caps.quantity}${caps.unit}`;
                    formData.append(`capacity[${index}]`, capacityString);
                });
                console.log(formData);
                const inquiryid = this.$route.params.id;
                const url = this.mode === 'edit' ? `/api/update_price_inquiry/${inquiryid}` : '/api/price_inquiry';
                // const method = this.mode === 'edit' ? 'put' : 'post';
                const method = 'post';
                const response = await axios[method](url, formData);

                this.loader = false;
                if (response.status === 201 || response.status === 200) {
                    NProgress.done();
                    toastr.success(response.data.message);
                    this.$router.push({ name: 'price_inquiry' });
                    // if (this.mode === 'edit') {
                    //     this.$emit('record-updated');
                    // }
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
        fetchInquiry() {

            const inquiryid = this.$route.params.id;
            axios.get('/api/price_inquiry_get/' + inquiryid)
                .then(response => {
                    this.inquiry = response.data.price;
                    this.supplierData = response.data.users;
                    console.log(this.inquiry, this.supplierData);


                    if (this.inquiry != null) {
                        this.cargo_place = this.inquiry.cargo_place || [];
                        this.loadImageFromPath(this.inquiry.file, this.$refs.canvas);

                        if (this.inquiry.file1 != null) {
                            this.loadImageFromPath(
                                this.inquiry.file1,
                                this.$refs.canvas1
                            );
                        }
                        if (this.inquiry.file != null) {
                            this.loadImageFromPath(
                                this.inquiry.file,
                                this.$refs.canvas
                            );
                        }

                        this.materials = this.inquiry && this.inquiry.pcs ? this.inquiry.pcs.map(quantity => ({ quantity })) : [{ quantity: '' }];
                        this.capacity = this.inquiry && this.inquiry.capacity ? this.inquiry.capacity.map(capacity => {
                            const [quantity, unit] = capacity.match(/(\d+)([a-zA-Z]+)/).slice(1); // Extract quantity and unit from combined value
                            return { quantity: parseInt(quantity), unit }; // Parse quantity to integer and keep unit as extracted
                        }) : [{ quantity: '', unit: '' }];
                    }

                    this.buyer = Number(this.inquiry.buyer);
                    this.inquiry.group = Number(this.inquiry.group);
                    // const selectedbuyer = this.buyers.find(buyer => buyer.id === selectedbuyerIds);
                    // if (selectedbuyer) {
                    //     this.selectedBuyerId = selectedbuyer;
                    // }

                    if (this.inquiry.group) {
                        this.fetchSupplierProfiles(this.inquiry.group);
                    }
                    this.precheckSelected();
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
            return this.inquiry.capacity.length * this.inquiry.pcs.length;
        },
        formattedCapacity() {
            return this.capacity.map(caps => `${caps.quantity}${caps.unit}`);
        },
        selectedSupplierIds() {
            return this.supplier_profiles
                .filter(supplier => supplier.checked)
                .map(supplier => supplier.id);
        },
    },
    watch: {
        'capacity[indexs].quantity': function (newVal) {
            console.log(newVal);

            this.updateInquiryCapacity(newVal);
        }
        // selectedBuyerId(newValue) {
        //     // console.log(newValue);
        //     this.buyer = newValue.id;
        // },
        // inquiry: {
        //     handler(newValue) {
        //         const selectedbuyerIds = Number(newValue.buyer);
        //         const selectedbuyer = this.buyers.find(buyer => buyer.id === selectedbuyerIds);
        //         if (selectedbuyer) {
        //             this.selectedBuyerId = selectedbuyer;
        //         }
        //     },
        //     deep: true,
        // },
    },
    unmounted() {
        // console.log('beforeDestroy');
        this.$store.dispatch('CLEAR_INQUIRY_DATA');
    },
    mounted() {
        NProgress.configure({ showSpinner: false });
        const inquiryData = this.$store.getters.getInquiryData;
        if (inquiryData) {
            this.inquiry = { ...this.inquiry, ...inquiryData };
        };
        this.fetchProductGroups();
        this.fetchBuyers();
        this.$refs.fileInput.addEventListener('change', this.loadImage);
        this.$refs.fileInput1.addEventListener('change', this.loadImage1);

        // Trigger loadImage method if in edit mode and there's an existing image
        if (this.mode === 'edit') {
            this.fetchInquiry();
            this.follow_up = true;
        }
        if (this.mode === 'edit' && this.file) {
            this.loadImageFromPath(this.file, this.$refs.canvas);
        }
        if (this.mode === 'edit' && this.file1) {
            this.loadImageFromPath(this.file1, this.$refs.canvas1);
        }
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
