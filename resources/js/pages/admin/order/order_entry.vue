<template>
    <section class="section">
        <form @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="container">
                <div class="row my-5">
                    <h3 class="text-milung mb-4 fw-bold text-uppercase">Order Overview</h3>
                    <div class="col-md-4">
                        <h4 class="text-milung mb-4 fw-bold ">I. Order Information</h4>

                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Article Number:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders.article" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto ">Status:</p>
                            </div>
                            <div class="col-8">
                                <select class="fw-bold form-select" v-model="orders.status">
                                    <option value="New Order">New Order</option>
                                    <option value="Printview Confirmation">Printview Confirmation</option>
                                    <option value="Printview Reject">Printview Reject</option>
                                    <option value="Order Confirm">Order Confirm</option>
                                    <option value="Cargo Ready">Cargo Ready</option>
                                    <option value="Shipment Approval">Shipment Approval</option>
                                    <option value="Export/Import">Export/Import</option>
                                    <option value="Delivered">Delivered</option>

                                </select>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Buyer Order No:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders.buyerorder" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Order Reference:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders.reference" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Related inquiry No:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders.inquiry" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Milung Order No:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders.milungorder" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Supplier ID:</p>
                            </div>
                            <div class="col-8">
                                <!-- <input type="text" v-model="orders.supplier" class="form-control "> -->
                                <multiselect v-model="selectedSupplierId" :disabled="!this.isEditing"
                                    :options="suppliers" field="id" label="userid" track-by="id">
                                </multiselect>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Order Date:</p>
                            </div>
                            <div class="col-8">
                                <input type="date" v-model="orders.orderdate" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Buyer Email:</p>
                            </div>
                            <div class="col-8">
                                <input type="email" v-model="orders.buyeremail" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Buyer ID:</p>
                            </div>
                            <div class="col-8">
                                <!-- <input type="text" v-model="orders.buyer" class="form-control "> -->
                                <multiselect v-model="selectedBuyerId" :options="buyers" field="id" label="userid"
                                    track-by="id">
                                </multiselect>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 ">
                                <p for="v-model" class="my-auto fs-7">Order Remarks:</p>
                            </div>
                            <div class="col-8">
                                <textarea v-model="orders.orderremarks" class="form-control" cols="30"
                                    rows="5"></textarea>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 ">
                                <p for="v-model" class="my-auto fs-7">QC Remarks:</p>
                            </div>
                            <div class="col-8">
                                <textarea v-model="orders.qcremarks" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Product Group:</p>
                            </div>
                            <div class="col-8">
                                <select class=" form-select" v-model="orders.group">
                                    <option selected disabled>Select a product group</option>
                                    <option v-for="group1 in groups" :key="group1.id" :value="group1.id">
                                        {{ group1.group_name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Fty item No:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders.ftyitem" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Product Name:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders.productname" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Product Color: (Pantone if applicable)</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders.productcolor" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 mt-2">
                                <p for="v-model" class=" fs-7">Product Capacity:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group my-2" v-for="(caps, indexs) in orders.capacity" :="indexs">
                                    <input type="number" class="form-control" v-model="caps.quantity">
                                    <select style="color: #41b400;" class="fw-bold form-select mx-2"
                                        v-model="caps.unit">
                                        <option selected value="GB">GB</option>
                                        <option value="mAh">mAh</option>
                                    </select>
                                    <div class="input-buttons">
                                        <button class="btn btn-warning btn ms-1" type="button"
                                            @click="addcapacity(indexs)" v-if="indexs === 0">+</button>
                                        <button class="btn btn-danger  ms-2" type="button"
                                            @click="removecapacity(indexs)"
                                            v-if="indexs !== 0 && orders.capacity.length > 1">-</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Accessories:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders.accessories" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Product Printing Method:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders.printingmethod" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Logo Pantone Color:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders.logocolor" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Packaging:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders.packaging" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Packaging Printing: <br> (if applicable)</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="text" v-model="orders.packagingprinting[0]" class="form-control">
                                    <button class="btn btn-outline-primary" type="button" id="button-addon2"
                                        @click="addInput">+1c Label</button>
                                </div>
                                <div v-for="(input, index) in orders.packagingprinting" :key="index">
                                    <div class="input-group mt-2" v-if="index > 0">
                                        <input type="text" class="form-control"
                                            v-model="orders.packagingprinting[index]">
                                        <button class="btn btn-outline-danger" type="button"
                                            @click="removeInput(index)">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="d-flex col-12 my-2 ">
                            <div class="col-8 my-auto">
                                <p for="v-model my-auto">Buyer Product Photo/Print View:</p>
                            </div>
                            <div class="col-4">
                                <button @click="importImage" type="button" class="btn btn-sm px-4 btn-milung">
                                    Import
                                </button>
                                <!-- <button>submit</button> -->
                                <input ref="fileInput" type="file" class="form-control d-none" accept=".jpg,.png">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2 ">
                            <div class="col-8 my-aut">
                                <canvas ref="canvas" width="353" height="300" class="border border-2"></canvas>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-3 my-auto">
                                <p for="v-model" class="my-auto fs-7">Quantity:</p>
                            </div>
                            <div class="col-9">
                                <div class="input-group my-2">
                                    <input type="number" class="form-control" v-model="orders.quantity">
                                    <select style="color: #41b400;" class="fw-bold form-select" v-model="orders.unit">
                                        <option value="units">units</option>
                                        <!-- <option value="mAh">mAh</option> -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Log File:</p>
                            </div>
                            <div class="col-8">
                                <div class="col-12">

                                    <input type="text" v-model="orders.logfile" class="form-control ">
                                </div>
                                <div class="col-12  justify-content-between">
                                    <button type="button" class="btn px-4 btn-milung" >
                                        Import
                                    </button>
                                    <button type="button" class="btn px-4 mx-2 btn-primary my-2">
                                        Export
                                    </button>
                                </div>
                            </div>
                        </div> -->
                        <FileInputWithName label="Logo File" :files="orders.logoFiles" :fileData="orders.logoFiles"
                            @update:files="updateFiles" @export-file="exportFile" />
                        <FileInputWithName label="Label File" :files="orders.safetySheetFiles"
                            :fileData="orders.safetySheetFiles" @update:files="updateFiles" @export-file="exportFile" />
                        <FileInputWithName label="Manual" :files="orders.manualFiles" :fileData="orders.manualFiles"
                            @update:files="updateFiles" @export-file="exportFile" />
                        <FileInputWithName label="Safety Sheet" :files="orders.labelFiles" :fileData="orders.labelFiles"
                            @update:files="updateFiles" @export-file="exportFile" />

                        <!-- <FileInputWithName label="Label File2" v-model="orders.multiFiles2"
                            @update:files="updateFiles1" @export-file="exportFile" /> -->


                    </div>
                    <div class="col-md-4">
                        <h4 class="text-milung mb-4 fw-bold ">II. Price:</h4>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Byuing Price:</p>
                            </div>
                            <div class="col-8">
                                <!-- <input type="text"  class="form-control"> -->
                                <div class="input-group ">
                                    <input type="text" class="form-control" disabled v-model="orders.buyingprice">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">USD</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Selling Price:</p>
                            </div>
                            <div class="col-8">
                                <!-- <input type="text"  class="form-control"> -->
                                <div class="input-group ">
                                    <input type="text" class="form-control" :disabled="!isEditing"
                                        v-model="orders.sellingprice">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">USD</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Total Order Value:</p>
                            </div>
                            <div class="col-8">
                                <!-- <input type="text"  class="form-control"> -->
                                <div class="input-group ">
                                    <input type="text" class="form-control" :disabled="!isEditing"
                                        v-model="orders.totalvalue">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">USD</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="text-milung mb-4 fw-bold mt-3">III. Delivery/Shipping Information:</h5>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 ">
                                <p for="v-model" class=" fs-7">HS Code:</p>
                            </div>
                            <div class="col-8">
                                <p>{{ selectedProductGroupCode.hs_de }}</p>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 ">
                                <p for="v-model" class=" fs-7">HS-CN Code:</p>
                            </div>
                            <div class="col-8">
                                <p>{{ selectedProductGroupCode.hs_cn }}</p>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Latest SendOut Date:</p>
                            </div>
                            <div class="col-8">
                                <input type="date" v-model="orders.sendoutdate" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Notice:</p>
                            </div>
                            <div class="col-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Fix Date"
                                        v-model="orders.notice">
                                    <label class="form-check-label">
                                        Fix Date
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="PV to Customer"
                                        v-model="orders.notice">
                                    <label class="form-check-label">
                                        PV to Customer
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">SO#:</p>
                            </div>
                            <div class="col-8">
                                <!-- <input type="text" v-model="orders.so_number" class="form-control "> -->
                                <multiselect v-model="selectedsoId" :options="so" field="id" label="so_number"
                                    track-by="id">
                                </multiselect>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">ATC#:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders.atc_number" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Shipping Document#:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders.ship_doc" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Incoterm#:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders.incoterm" class="form-control ">
                            </div>
                        </div>
                        <!-- <div class="d-flex col-12 my-2 bg-danger">
                            <p>
                                XD Page not cleared
                            </p>
                        </div> -->
                        <div class="d-flex col-12 my-2 ">
                            <button class="btn btn-milung mx-2 px-3" name="action" value="save">Save </button>
                            <button class="btn btn-warning mx-2" name="action" value="create">Create New Order</button>
                        </div>

                    </div>

                </div>
            </div>
        </form>
        <div class="container" v-show="showPrintView" v-if="can('printviewConfirmRejectButton')">
            <printview :id="orders.id" :image="orders.files" />
        </div>
        <progress-modal :show="showProgress"></progress-modal>
    </section>
</template>

<script>
// import { ref } from 'vue';
// import useForm from 'laravel-precognition-vue';
import ProgressModal from "../progress/ProgressModal.vue";
import './../index';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import FileInputWithName from './FileInputWithName.vue';
import printview from "./printview.vue";
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';

export default {
    emits: ['profileUpdated'],
    components: {
        FileInputWithName,
        ProgressModal,
        printview
    },
    props: {
        isEditing: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            showPrintView: false,
            suppliers: [],
            so: [],
            selectedSupplierId: [],
            selectedsoId: [],
            selectedBuyerId: [],
            buyers: [],
            showProgress: false,
            inputs: [],
            files: [],
            groups: [],
            inquiry: [],
            orders:
            {

                packagingprinting: [],
                logoFiles: [],
                safetySheetFiles: [],
                manualFiles: [],
                labelFiles: [],
                notice: [],
                capacity: [{ quantity: '', unit: '' }],
            }
            ,

        }
    },
    // setup(props) {
    //     console.log(props);
    //     const form = useForm('post', '/api/orderentry', props.orders);

    //     const submit = () => form.submit();

    //     return {
    //         form,
    //         submit,
    //     };
    // },
    watch: {
        selectedBuyerId(newValue) {
            // console.log(newValue);
            this.orders.buyer = newValue.id;
        },
        selectedsoId(newValue) {
            // console.log(newValue);
            this.orders.so_number = newValue.id;
        },
        selectedSupplierId(newValue) {
            this.orders.supplier = newValue.id;
            // console.log(this.orders.supplier);
        }
    },
    created() {
        if (this.$route.query.inquiry) {
            this.inquiry = JSON.parse(this.$route.query.inquiry);
            console.log(this.inquiry,' ho');
    }
  },
    methods: {
        fetchSuppliers() {
            axios.get('/api/Suppliers')
                .then(response => {
                    this.suppliers = response.data;
                    // console.log(this.suppliers);
                    const selectedSupplierId = Number(this.orders.supplier);
                    const selectedSupplier = this.suppliers.find(supplier => supplier.id === selectedSupplierId);
                    if (selectedSupplier) {
                        this.selectedSupplierId = selectedSupplier;
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        },

        fetchBuyers() {
            axios.get('/api/buyerOrder')
                .then(response => {
                    this.buyers = response.data;
                    // console.log(this.buyers);
                    const selectedbuyerIds = Number(this.orders.buyer);
                    const selectedbuyer = this.buyers.find(buyer => buyer.id === selectedbuyerIds);
                    if (selectedbuyer) {
                        this.selectedBuyerId = selectedbuyer;
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        },
        fetchSO() {
            axios.get('/api/shipmentsget')
                .then(response => {
                    this.so = response.data;
                    console.log(this.so);
                    // const selectedbuyerIds = Number(this.orders.buyer);
                    const selectedso = this.so.find(sos => sos.id === this.orders.so_number);
                    if (selectedso) {
                        this.selectedsoId = selectedso;
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        },
        addInput() {
            this.orders.packagingprinting.push('');
        },
        removeInput(index) {
            this.orders.packagingprinting.splice(index, 1);
        },
        updateFiles(payload) {
            console.log(payload);

            switch (payload.label) {
                case 'Logo File':
                    if (!Array.isArray(this.orders.logoFiles)) {
                        this.orders.logoFiles = [];
                    }
                    this.orders.logoFiles.push(payload);
                    break;
                case 'Label File':
                    if (!Array.isArray(this.orders.labelFiles)) {
                        this.orders.labelFiles = [];
                    }
                    this.orders.labelFiles.push(payload);
                    break;
                case 'Manual':
                    if (!Array.isArray(this.orders.manualFiles)) {
                        this.orders.manualFiles = [];
                    }
                    this.orders.manualFiles.push(payload);
                    break;
                case 'Safety Sheet':
                    if (!Array.isArray(this.orders.safetySheetFiles)) {
                        this.orders.safetySheetFiles = [];
                    }
                    this.orders.safetySheetFiles.push(payload);
                    break;
                default:
                    break;
            }
        },

        exportFile(file) {
            // Access the file and file name here
            console.log('File:', file.file);
            console.log('File name:', file.name);
        },
        importImage() {
            this.$refs.fileInput.click();
        },
        handleValidationErrors(validationErrors) {
            // Assuming you have a function to display toastr error messages
            validationErrors.forEach(message => {
                toastr.error(message);
            });
        },
        loadImage(event) {
            const file = event.target.files[0];
            this.orders.files = file;
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
        handleApiCall(method, url, data) {
            return new Promise((resolve, reject) => {
                axios({
                    method: method,
                    url: url,
                    data: data,
                    headers: {
                        'Content-Type': 'multipart/form-data' // Set the correct Content-Type header for FormData
                    }
                })
                    .then(response => {
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        onSubmit() {
            this.showProgress = true;
            NProgress.start();
            console.log(this.orders);
            if (this.isEditing) {
                this.orders.linked_order = event.submitter.getAttribute('value');
            }
            let method = 'post';
            let url = this.isEditing ? `/api/orderentry/${this.orders.id}` : '/api/orderentry';

            this.handleApiCall(method, url, this.orders)
                .then(response => {
                    setTimeout(() => {
                        this.showProgress = false;
                    }, 1000);
                    // Handle successful order update or creation
                    console.log(response);
                    NProgress.done();
                    toastr.success(this.isEditing ? 'Order updated successfully' : 'Order added successfully');
                    this.$router.push({ name: 'order_list' });
                })
                .catch(error => {
                    setTimeout(() => {
                        this.showProgress = false;
                    }, 1000);
                    NProgress.done();

                    if (error.response && error.response.status === 422) {
                        const validationErrors = error.response.data.errors;
                        this.handleValidationErrors(validationErrors);
                    } else {
                        console.error(error);
                        toastr.error(this.isEditing ? 'An error occurred while updating the order' : 'An error occurred while adding the order');
                    }
                });
        },
        addcapacity() {
            this.orders.capacity.push({ quantity: '' });
        },
        removecapacity(index) {
            this.orders.capacity.splice(index, 1);
        },
        fetchProductGroups() {
            NProgress.start();
            axios.get('/api/product_group_get')
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

        loadImageFromPath(imageFileName, canvas) {
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas context

            // Construct the URL to the file in the storage folder
            const imageUrl = `/storage/${imageFileName}`;
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
        fetchorder(orderId) {
            NProgress.start();
            axios.get(`/api/orderentry/${orderId}`)
                .then(response => {
                    this.orders = response.data;
                    console.log(this.orders);
                    const selectedSupplierId = Number(this.orders.supplier);
                    const selectedSupplier = this.suppliers.find(supplier => supplier.id === selectedSupplierId);
                    if (selectedSupplier) {
                        this.selectedSupplierId = selectedSupplier;
                    }
                    // Pre-fill capacity if it exists
                    if (this.orders.capacity) {
                        this.orders.capacity = this.orders.capacity.map(capacity => {
                            const [quantity, unit] = capacity.match(/(\d+)([a-zA-Z]+)/).slice(1);
                            return { quantity: parseInt(quantity), unit };
                        });
                    } else {
                        // If capacity doesn't exist, initialize it with default values
                        this.orders.capacity = [{ quantity: '', unit: '' }];
                    }
                    if (this.orders.quantity_units) {
                        const quantityString = this.orders.quantity_units;
                        console.log(this.orders.quantity_units);

                        const quantity = parseInt(quantityString.split('units')[0]);
                        this.orders.quantity = quantity;
                    }
                    // console.log('files ', this.orders.files[0]['filepath']);
                    if (this.orders.files != null) {
                        this.loadImageFromPath(
                            this.orders.files['filepath'],
                            this.$refs.canvas
                        );
                    }
                    // this.loadImageFromPath(this.orders.files[0]['filepath'], this.$refs.canvas);
                    this.orders.unit = 'units';
                    NProgress.done();

                    setTimeout(() => {
                        this.showPrintView = true;
                    }, 1000);
                })
                .catch(error => {
                    console.error(error);
                    NProgress.done();
                });
        },
    },
    mounted() {

        if (this.isEditing) {
            const orderId = this.$route.params.id;
            this.fetchorder(orderId);



        }
        NProgress.configure({ showSpinner: false });
        this.fetchSuppliers();
        this.fetchBuyers();
        this.fetchSO();
        this.fetchProductGroups();
        this.$refs.fileInput.addEventListener('change', this.loadImage);
    },
    beforeUnmount() {
        this.$refs.fileInput.removeEventListener('change', this.loadImage);
    },
    computed: {
        selectedGroup() {
            return this.groups.find(group => group.id === this.orders.group);
        },
        selectedProductGroupCode() {
            const selectedGroup = this.selectedGroup;
            // console.log('hi ', selectedGroup);
            if (!selectedGroup) {
                return '';
            }
            return selectedGroup; // or any other HS code property you want to display
        },
        formattedCapacity() {
            return this.orders.capacity.map(caps => `${caps.quantity}${caps.unit}`);
        },
    },
}
</script>

<style>
@import url('./../style.css');

#main {
    padding: 20px 0px !important;
}

.multiselect {
    border: 1px solid #ced4da;
    border-radius: 0.25rem
}

.fs-7 {
    font-size: 14px !important;
}
</style>
