<template>
    <section class="section">
        <form @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="container">

                <div class="row my-5">
                    <h3 class="text-milung mb-4 fw-bold text-uppercase">Price Inquiry</h3>
                    <div class="col-md-6">
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Buyer ID:</p>
                            </div>
                            <div class="col-8">
                                <!-- <input type="text" v-model="inquiry.buyer" class="form-control"> -->
                                <multiselect v-model="selectedBuyerId" :options="buyers" field="id" label="buyer_id"
                                     track-by="id">
                                </multiselect>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Inquiry Number:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="inquiry.inquiry_number" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Article Number:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="inquiry.article" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Group:</p>
                            </div>
                            <div class="col-8">
                                <select class=" form-select" v-model="inquiry.group"
                                    @change="fetchSupplierProfiles(inquiry.group)">
                                    <option selected disabled>Select a product group</option>
                                    <option v-for="group1 in groups" :key="group1.id" :value="group1.id">
                                        {{ group1.group_name }}
                                    </option>
                                </select>

                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Name:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="inquiry.name" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Description/ Specification:</p>
                            </div>
                            <div class="col-8">
                                <textarea v-model="inquiry.description" class="form-control" cols="36"
                                    rows="10"></textarea>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Cargo Classification:</p>
                            </div>
                            <div class="col-8">
                                <div class="d-flex">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="general"
                                            v-model="inquiry.cargo">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            General Cargo
                                        </label>
                                    </div>
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="radio" value="danger"
                                            v-model="inquiry.cargo">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Danger Goods
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex my-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" v-model="cargo_place"
                                            value="hongkong">
                                        <label class="form-check-label" for="flexCheckDefault1">
                                            Hong Kong
                                        </label>
                                    </div>
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="checkbox" v-model="cargo_place"
                                            value="china">
                                        <label class="form-check-label" for="flexCheckDefault2">
                                            Mainland China
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Incoterm:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="inquiry.incoterm" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Inquiry Quantity:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group my-2" v-for="(material, index) in materials" :="index">
                                    <input type="number" class="form-control" v-model="materials[index].quantity"
                                        @input="updateInquiryMaterials" />
                                    <span class="input-group-text mx-2 fw-bold" style="color: #41b400;">Pcs</span>
                                    <div class="input-buttons">
                                        <button class="btn btn-warning btn ms-1" type="button"
                                            @click="addMaterial(index)" v-if="index === 0">+</button>
                                        <button class="btn btn-danger  ms-2" type="button"
                                            @click="removeMaterial(index)"
                                            v-if="index !== 0 && materials.length > 1">-</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Capacity:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group my-2" v-for="(caps, indexs) in capacity" :="indexs">
                                    <input type="number" class="form-control" v-model="capacity[indexs].quantity"
                                        @input="updateInquiryCapacity" />
                                    <select style="color: #41b400;" class="fw-bold form-control mx-2"
                                        v-model="capacity[indexs].unit">
                                        <option value="GB">GB</option>
                                        <option value="mAh">mAh</option>
                                    </select>
                                    <div class="input-buttons">
                                        <button class="btn btn-warning btn ms-1" type="button"
                                            @click="addcapacity(indexs)" v-if="indexs === 0">+</button>
                                        <button class="btn btn-danger  ms-2" type="button"
                                            @click="removecapacity(indexs)"
                                            v-if="indexs !== 0 && capacity.length > 1">-</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Printing Method:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="inquiry.method" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Printing Color:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="inquiry.color" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Standard Packaging:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="inquiry.packaging" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Special Requirement:</p>
                            </div>
                            <div class="col-8">
                                <textarea v-model="inquiry.requirements" class="form-control" cols="36"
                                    rows="10"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" class="my-1">Status:</p>
                            </div>
                            <div class="col-8"><select class="fw-bold form-control" v-model="inquiry.status">
                                    <option value="ML Checking">ML Checking</option>
                                    <option value="Supplier Checking">Supplier Checking</option>
                                    <option value="Buyer Follow Up">Buyer Follow Up</option>
                                    <option value="Supplier Follow Up">Supplier Follow Up</option>
                                    <option value="Supplier Replied">Supplier Replied</option>
                                    <option value="ML Quoted">ML Quoted</option>
                                </select></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Notice
                                </label>
                            </div>
                            <div class="col-8">
                                <div class="form-check">
                                    <input class="form-check-input " id="urgent" type="checkbox"
                                        v-model="inquiry.urgent">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Urgent
                                    </label>
                                </div>
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

                                <button type="button" class="btn btn-sm  fw-bold btn-milung m-2 col-3"
                                    data-bs-toggle="modal" data-bs-target="#supplierModal">Send To Supplier</button>

                                <button type="button" v-show="follow_up" @click="followup"
                                    class="btn btn-sm  fw-bold btn-warning m-2 col-3 text-white">Follow
                                    Up</button>

                                <button type="button"
                                    :style="{ 'background-color: aqua !important;': supplierInquiry.length }" style=""
                                    v-show="follow_up" class="btn btn-sm  fw-bold btn-info m-2 col-3"
                                    :disabled="!supplierInquiry.length" @click="quote">Quote Buyer</button>

                                <button style="background-color: #bc7803 !important;" v-show="follow_up" type="button"
                                    class="btn btn-sm  fw-bold btn-milung m-2 col-3" data-bs-toggle="modal"
                                    data-bs-target="#createOrderModal">Create Order</button>

                                <button type="button" style="background-color: #41b400 !important;" v-show="follow_up"
                                    class="btn btn-sm  fw-bold btn-milung m-2 col-3">Supplier To Buyer</button>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="row" v-for="(rows, index) in supplierData" :key="index"
                    v-if="supplierData && Object.keys(supplierData).length > 0">
                    <h3 class="text-milung mb-4 fw-bold text-uppercase">{{ index }} Inquiry Quote
                    </h3>
                    <div class="d-flex justify-content-between">
                        <label>
                            <input type="radio" :value="index" v-model="selectedSupplier"
                                @change="selectAllRows(index)">
                            Select All for {{ index }}
                        </label>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead style="color: #009de1" class="text-center">
                            <tr style="">
                                <th class="text-nowrap">Product Capacity</th>
                                <th class="text-nowrap">Quantity</th>
                                <th class="text-nowrap">Currency</th>
                                <th class="text-nowrap">EXW Price</th>
                                <th class="text-nowrap">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr v-for="(row, indexs) in rows" :key="indexs">
                                <td class="text-nowrap">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" v-model="supplierInquiry"
                                            :disabled="selectedSupplier !== null && selectedSupplier !== index"
                                            :value="row.id" :checked="!!row.selected">
                                        <label class="form-check-label">
                                            {{ row.capacity }}
                                        </label>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    {{ row.quantity }}
                                </td>
                                <td class="text-nowrap">USD</td>
                                <td class="text-nowrap" style="width: 13% !important">

                                    <span v-if="row.exw">
                                        {{ row.exw }}
                                    </span>

                                    <span v-else class="fst-italic text-muted">
                                        Not Provided
                                    </span>
                                </td>
                                <td v-show="indexs === 0" :rowspan="totalRows">

                                    <span v-if="row.supplierremarks?.remarks">
                                        {{ row.supplierremarks?.remarks }}
                                    </span>

                                    <span v-else class="fst-italic text-muted">
                                        Not Provided
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Modal 1-->
            <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Select Supplier</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-check" v-for="(supplier, index) in supplier_profiles" :key="index">
                                <input class="form-check-input" type="checkbox" :value="supplier.id" :id="supplier.id"
                                    :checked="mode === 'edit' ? isSupplierIdChecked(supplier.id) : false"
                                    v-model="supplier.checked">
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ supplier.name }}
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                            <button class="btn btn-primary" data-bs-dismiss="modal">Create Inquiry</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Modal 1-->
            <!-- Modal 2-->
            <div class="modal fade" id="createOrderModal" tabindex="-1" aria-labelledby="createOrderModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createOrderModalLabel">Select Quantity and Capacity</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Select Quantity</label>
                                <select v-model="selectedQuantity" class="form-select" id="quantity">
                                    <option v-for="(material, index) in materials" :key="index"
                                        :value="material.quantity">
                                        {{ material.quantity }} Pcs
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="capacity" class="form-label">Select Capacity</label>
                                <select v-model="selectedCapacity" class="form-select" id="capacity">
                                    <option v-for="(caps, index) in capacity" :key="index"
                                        :value="`${caps.quantity} ${caps.unit}`">
                                        {{ caps.quantity }} {{ caps.unit }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                @click="createOrder(inquiry)">Create
                                Order</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Modal 2-->
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
                materials: [{ quantity: '' }], // Initialize with default values
                capacity: [{ quantity: '', unit: '' }],
            },
            cargo_place: [],
            supplierData: {},
            materials: [{ quantity: '' }],
            capacity: [{ quantity: '', unit: '' }],
            selectedBuyerId: [],
            buyers: [],
            imageLoaded: false,
            groups: [],
            supplierInquiry: [],
            supplier_profiles: [],
            follow_up: false,
        };
    },
    methods: {
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
            console.log(this.supplierInquiry,this.selectedSupplier);
            if (inquiryid) {
                let formData
                if(this.selectedSupplier){
                    formData = {
                        // quoteIds: this.supplierInquiry
                        quoteIds: this.supplierData[this.selectedSupplier].map(row => row.id)
                    };

                } else{
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
            // console.log(this.capacity);
            this.inquiry.capacity = this.capacity.map(capacity => ({ quantity: capacity.quantity, unit: capacity.unit }));
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
                    this.supplier_profiles = response.data.map(supplier => {
                        supplier.checked = this.mode === 'edit' ? this.isSupplierIdChecked(supplier.id) : false;
                        return supplier;
                    });
                    console.log(this.supplier_profiles);

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
                formData.append('urgent', this.inquiry.urgent ? 'true' : 'false');
                formData.append('method', this.inquiry.method);
                formData.append('color', this.inquiry.color);
                formData.append('packaging', this.inquiry.packaging);
                formData.append('requirements', this.inquiry.requirements);
                formData.append('status', this.inquiry.status);
                formData.append('file', this.$refs.fileInput.files[0]);
                formData.append('file1', this.$refs.fileInput1.files[0]);

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

                    const selectedbuyerIds = Number(this.inquiry.buyer);
                    const selectedbuyer = this.buyers.find(buyer => buyer.id === selectedbuyerIds);
                    if (selectedbuyer) {
                        this.selectedBuyerId = selectedbuyer;
                    }

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
        selectedBuyerId(newValue) {
            // console.log(newValue);
            this.buyer = newValue.id;
        },
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
    mounted() {
        NProgress.configure({ showSpinner: false });
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
