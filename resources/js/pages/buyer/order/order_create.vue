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
                                <p for="v-model" class="my-auto ">Status:</p>
                            </div>
                            <div class="col-8">
                                <select class="fw-bold form-select" v-model="orders[0].status">
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
                                <input type="text" v-model="orders[0].buyerorder" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Order Reference:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders[0].reference" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Related inquiry No:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders[0].inquiry" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Milung Order No:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders[0].milungorder" class="form-control ">
                            </div>
                        </div>

                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Order Date:</p>
                            </div>
                            <div class="col-8">
                                <input type="date" v-model="orders[0].orderdate" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Buyer Email:</p>
                            </div>
                            <div class="col-8">
                                <input type="email" v-model="orders[0].buyeremail" class="form-control ">
                            </div>
                        </div>

                        <div class="d-flex col-12 my-2">
                            <div class="col-4 ">
                                <p for="v-model" class="my-auto fs-7">Order Remarks:</p>
                            </div>
                            <div class="col-8">
                                <textarea v-model="orders[0].orderremarks" class="form-control" cols="30"
                                    rows="5"></textarea>
                            </div>
                        </div>

                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Product Group:</p>
                            </div>
                            <div class="col-8">
                                <select class=" form-select" v-model="orders[0].group">
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
                                <input type="text" v-model="orders[0].ftyitem" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Product Name:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders[0].productname" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Product Color: (Pantone if applicable)</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders[0].productcolor" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 mt-2">
                                <p for="v-model" class=" fs-7">Product Capacity:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group my-2" v-for="(caps, indexs) in orders[0].capacity" :="indexs">
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
                                            v-if="indexs !== 0 && orders[0].capacity.length > 1">-</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Accessories:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders[0].accessories" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Product Printing Method:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders[0].printingmethod" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Logo Pantone Color:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders[0].logocolor" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Packaging:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders[0].packaging" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Packaging Printing: <br> (if applicable)</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="text" v-model="orders[0].packagingprinting[0]" class="form-control">
                                    <button class="btn btn-outline-primary" type="button" id="button-addon2"
                                        @click="addInput">+1c Label</button>
                                </div>
                                <div v-for="(input, index) in orders[0].packagingprinting" :key="index">
                                    <div class="input-group mt-2" v-if="index > 0">
                                        <input type="text" class="form-control"
                                            v-model="orders[0].packagingprinting[index]">
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
                                    <input type="number" class="form-control" v-model="orders[0].quantity">
                                    <select style="color: #41b400;" class="fw-bold form-select"
                                        v-model="orders[0].unit">
                                        <option selected value="units">units</option>
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

                                    <input type="text" v-model="orders[0].logfile" class="form-control ">
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
                        <FileInputWithName label="Logo File" :files="orders[0].logoFiles"
                            :fileData="orders[0].logoFiles" @update:files="updateFiles" @export-file="exportFile" />
                        <FileInputWithName label="Label File" :files="orders[0].safetySheetFiles"
                            :fileData="orders[0].safetySheetFiles" @update:files="updateFiles"
                            @export-file="exportFile" />
                        <FileInputWithName label="Manual" :files="orders[0].manualFiles"
                            :fileData="orders[0].manualFiles" @update:files="updateFiles" @export-file="exportFile" />
                        <FileInputWithName label="Safety Sheet" :files="orders[0].labelFiles"
                            :fileData="orders[0].labelFiles" @update:files="updateFiles" @export-file="exportFile" />

                        <!-- <FileInputWithName label="Label File2" v-model="orders[0].multiFiles2"
                            @update:files="updateFiles1" @export-file="exportFile" /> -->


                    </div>
                    <div class="col-md-4">
                        <h4 class="text-milung mb-4 fw-bold ">II. Price:</h4>

                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Selling Price:</p>
                            </div>
                            <div class="col-8">
                                <!-- <input type="text"  class="form-control"> -->
                                <div class="input-group ">
                                    <input type="text" class="form-control" :disabled="!isEditing"
                                        v-model="orders[0].sellingprice">
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
                                        v-model="orders[0].totalvalue">
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
                                <input type="date" v-model="orders[0].sendoutdate" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Notice:</p>
                            </div>
                            <div class="col-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Fix Date"
                                        v-model="orders[0].notice">
                                    <label class="form-check-label">
                                        Fix Date
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="PV to Customer"
                                        v-model="orders[0].notice">
                                    <label class="form-check-label">
                                        PV to Customer
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">ATC#:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders[0].atc_number" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Shipping Document#:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders[0].ship_doc" class="form-control ">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">Incoterm#:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="orders[0].incoterm" class="form-control ">
                            </div>
                        </div>

                        <div class="d-flex col-12 my-2 ">
                            <button class="btn btn-warning  ms-auto fw-bold" name="action" value="create">Create New Order</button>
                        </div>

                    </div>

                </div>
            </div>
        </form>
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
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';

export default {
    components: {
        FileInputWithName,
        ProgressModal
    },
    props: {
        isEditing: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
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
            orders: [
                {

                    packagingprinting: [],
                    logoFiles: [],
                    safetySheetFiles: [],
                    manualFiles: [],
                    labelFiles: [],
                    notice: [],
                    capacity: [{ quantity: '', unit: '' }],
                }
            ],

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
            this.orders[0].buyer = newValue.id;
        },
        selectedsoId(newValue) {
            // console.log(newValue);
            this.orders[0].so_number = newValue.id;
        },
        selectedSupplierId(newValue) {
            this.orders[0].supplier = newValue.id;
            // console.log(this.orders[0].supplier);
        }
    },
    methods: {
        // fetchSO() {
        //     axios.get('/api/shipmentsget')
        //         .then(response => {
        //             this.so = response.data;
        //             console.log(this.so);
        //             // const selectedbuyerIds = Number(this.orders[0].buyer);
        //             const selectedso = this.so.find(sos => sos.id === this.orders[0].so_number);
        //             if (selectedso) {
        //                 this.selectedsoId = selectedso;
        //             }
        //         })
        //         .catch(error => {
        //             console.error(error);
        //         });
        // },
        addInput() {
            this.orders[0].packagingprinting.push('');
        },
        removeInput(index) {
            this.orders[0].packagingprinting.splice(index, 1);
        },
        updateFiles(payload) {
            console.log(payload);

            switch (payload.label) {
                case 'Logo File':
                    if (!Array.isArray(this.orders[0].logoFiles)) {
                        this.orders[0].logoFiles = [];
                    }
                    this.orders[0].logoFiles.push(payload);
                    break;
                case 'Label File':
                    if (!Array.isArray(this.orders[0].labelFiles)) {
                        this.orders[0].labelFiles = [];
                    }
                    this.orders[0].labelFiles.push(payload);
                    break;
                case 'Manual':
                    if (!Array.isArray(this.orders[0].manualFiles)) {
                        this.orders[0].manualFiles = [];
                    }
                    this.orders[0].manualFiles.push(payload);
                    break;
                case 'Safety Sheet':
                    if (!Array.isArray(this.orders[0].safetySheetFiles)) {
                        this.orders[0].safetySheetFiles = [];
                    }
                    this.orders[0].safetySheetFiles.push(payload);
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
            // for (const key in validationErrors) {
            //     if (validationErrors.hasOwnProperty(key)) {
            //         const messages = validationErrors[key];
            //         // Display each validation error message
            //         messages.forEach(message => {
            //             toastr.error(message);
            //         });
            //     }
            // }
        },
        loadImage(event) {
            const file = event.target.files[0];
            this.orders[0].files = file;
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
            // this.showProgress = true;
            NProgress.start();
            console.log(this.orders);

            let method = 'post';
            let url = `/api/buyer/order`;

            this.handleApiCall(method, url, this.orders[0])
                .then(response => {
                    setTimeout(() => {
                        this.showProgress = false;
                    }, 1000);
                    // Handle successful order update or creation
                    console.log(response);
                    NProgress.done();
                    toastr.success('Order added successfully');
                    this.$router.push({ name: 'buyer_order_list' });
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
            this.orders[0].capacity.push({ quantity: '' });
        },
        removecapacity(index) {
            this.orders[0].capacity.splice(index, 1);
        },
        fetchProductGroups() {
            NProgress.start();
            axios.get('/api/buyer/product_group_get')
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
        // fetchorder(orderId) {
        //     NProgress.start();
        //     axios.get(`/api/buyer/orderentry/${orderId}`)
        //         .then(response => {
        //             this.orders[0] = response.data;
        //             console.log(this.orders[0]);
        //             // Pre-fill capacity if it exists
        //             if (this.orders[0].capacity) {
        //                 this.orders[0].capacity = this.orders[0].capacity.map(capacity => {
        //                     const [quantity, unit] = capacity.match(/(\d+)([a-zA-Z]+)/).slice(1);
        //                     return { quantity: parseInt(quantity), unit };
        //                 });
        //             } else {
        //                 // If capacity doesn't exist, initialize it with default values
        //                 this.orders[0].capacity = [{ quantity: '', unit: '' }];
        //             }
        //             if (this.orders[0].quantity_units) {
        //                 const quantityString = this.orders[0].quantity_units;
        //                 console.log(this.orders[0].quantity_units);

        //                 const quantity = parseInt(quantityString.split('units')[0]);
        //                 this.orders[0].quantity = quantity;
        //             }
        //             console.log('files ', this.orders[0].files[0]['filepath']);
        //             this.loadImageFromPath(this.orders[0].files[0]['filepath'], this.$refs.canvas);
        //             NProgress.done();
        //         })
        //         .catch(error => {
        //             console.error(error);
        //             NProgress.done();
        //         });
        // },
    },
    mounted() {
        // if (this.isEditing) {
        //     const orderId = this.$route.params.id;
        //     this.fetchorder(orderId);
        //     // console.log(this.orders[0]);

        // }
        NProgress.configure({ showSpinner: false });
        this.fetchProductGroups();
        this.$refs.fileInput.addEventListener('change', this.loadImage);
    },
    beforeUnmount() {
        this.$refs.fileInput.removeEventListener('change', this.loadImage);
    },
    computed: {
        selectedGroup() {
            return this.groups.find(group => group.id === this.orders[0].group);
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
            return this.orders[0].capacity.map(caps => `${caps.quantity}${caps.unit}`);
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
