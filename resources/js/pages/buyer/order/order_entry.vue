<template>
    <section class="section">
        <form @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="container">
                <div class="row my-5">
                    <h3 class="text-milung mb-4 fw-bold text-uppercase">
                        Order Overview
                    </h3>
                    <div class="col-md-4">
                        <h4 class="text-milung mb-4 fw-bold">
                            I. Order Information
                        </h4>

                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto">Status:</p>
                            </div>
                            <div class="col-8">
                                {{ orders[0].status }}
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Buyer Order No:
                                </p>
                            </div>
                            <div class="col-8">
                                {{ orders[0].buyerorder }}
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Order Reference:
                                </p>
                            </div>
                            <div class="col-8">
                                {{ orders[0].reference }}
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Related inquiry No:
                                </p>
                            </div>
                            <div class="col-8">
                                {{ orders[0].inquiry }}
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Milung Order No:
                                </p>
                            </div>
                            <div class="col-8">
                                {{ orders[0].milungorder }}
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Order Date:
                                </p>
                            </div>
                            <div class="col-8">
                                {{ orders[0].orderdate }}
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4">
                                <p for="v-model" class="my-auto fs-7">
                                    Order Remarks:
                                </p>
                            </div>
                            <div class="col-8">
                                {{ orders[0].orderremarks }}
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4">
                                <p for="v-model" class="my-auto fs-7">
                                    QC Remarks:
                                </p>
                            </div>
                            <div class="col-8">
                                {{ orders[0].qcremarks }}
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Product Group:
                                </p>
                            </div>
                            <div class="col-8">
                                {{ orders[0].product_group?.group_name }}
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Fty item No:
                                </p>
                            </div>
                            <div class="col-8">
                                {{ orders[0].ftyitem }}
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Product Name:
                                </p>
                            </div>
                            <div class="col-8">
                                {{ orders[0].productname }}
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Product Color: (Pantone if applicable)
                                </p>
                            </div>
                            <div class="col-8">
                                {{ orders[0].productcolor }}
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 mt-2">
                                <p for="v-model" class="fs-7">
                                    Product Capacity:
                                </p>
                            </div>
                            <div class="col-8">
                                <span class="my-4" v-for="item in orders[0].capacity">
                                    {{ item }}<br />
                                </span>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Accessories:
                                </p>
                            </div>
                            <div class="col-8">
                                {{ orders[0].accessories }}
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Product Printing Method:
                                </p>
                            </div>
                            <div class="col-8">
                                {{ orders[0].printingmethod }}
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Logo Pantone Color:
                                </p>
                            </div>
                            <div class="col-8">
                                {{ orders[0].logocolor }}
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Packaging:
                                </p>
                            </div>
                            <div class="col-8">
                                {{ orders[0].packaging }}
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Packaging Printing: <br />
                                    (if applicable)
                                </p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <span class="my-1" v-for="item in orders[0]
            .packagingprinting">
                                        {{ item }}<br />
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex col-12 my-4">
                            <div class="col-8 my-auto">
                                <p for="v-model my-auto">
                                    Buyer Product Photo/Print View:
                                </p>
                            </div>
                            <div class="col-4">
                                <button @click="importImage" type="button" class="btn btn-sm px-4 btn-milung">
                                    Import
                                </button>
                                <!-- <button>submit</button> -->
                                <input ref="fileInput" type="file" class="form-control d-none" accept=".jpg,.png">
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-8 my-aut">
                                <canvas ref="canvas" width="353" height="300" class="border border-2"></canvas>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-3 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Quantity:
                                </p>
                            </div>
                            <div class="col-9">
                                <div class="input-group my-4">
                                    {{ orders[0].quantity_unit }} Units
                                </div>
                            </div>
                        </div>
                        <!-- <div class="d-flex col-12 my-4">
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
                                    <button type="button" class="btn px-4 mx-2 btn-primary my-4">
                                        Export
                                    </button>
                                </div>
                            </div>
                        </div> -->
                        <!-- <FileInputWithName
                            label="Logo File"
                            :files="orders[0].logoFiles"
                            :fileData="orders[0].logoFiles"
                            @export-file="exportFile"
                        />
                        <FileInputWithName
                            label="Label File"
                            :files="orders[0].safetySheetFiles"
                            :fileData="orders[0].safetySheetFiles"
                            @export-file="exportFile"
                        />
                        <FileInputWithName
                            label="Manual"
                            :files="orders[0].manualFiles"
                            :fileData="orders[0].manualFiles"
                            @export-file="exportFile"
                        />
                        <FileInputWithName
                            label="Safety Sheet"
                            :files="orders[0].labelFiles"
                            :fileData="orders[0].labelFiles"
                            @export-file="exportFile"
                        /> -->
                        <div class="d-flex col-12 my-2">
                            <div class="col-3">
                                <p class="fs-7">Logo File:</p>
                            </div>
                            <div class="col-9">
                                <div class="col-12" :class="{
            'text-muted':
                orders[0].logoFiles?.filename ==
                null,
            'fst-italic':
                orders[0].logoFiles?.filename ==
                null,
        }">
                                    {{
            orders[0].logoFiles?.filename ??
            "not uploaded yet"
        }}
                                </div>
                                <div class="col-12 d-flex justify-content-end" v-if="orders[0].logoFiles?.filename">
                                    <a :href="'/storage/' +
            orders[0].logoFiles?.filepath
            " :download="orders[0].logoFiles?.filename
            " class="btn px-4 mx-2 btn-primary my-2 me-5">
                                        Export
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-3">
                                <p class="fs-7">Label File:</p>
                            </div>
                            <div class="col-9">
                                <div class="col-12" :class="{
            'text-muted':
                orders[0].labelFiles?.filename ==
                null,
            'fst-italic':
                orders[0].labelFiles?.filename ==
                null,
        }">
                                    {{
            orders[0].labelFiles?.filename ??
            "not uploaded yet"
        }}
                                </div>
                                <div class="col-12 d-flex justify-content-end" v-if="orders[0].labelFiles?.filename">
                                    <a :href="'/storage/' +
            orders[0].labelFiles?.filepath
            " :download="orders[0].labelFiles?.filename
            " class="btn px-4 mx-2 btn-primary my-2 me-5">
                                        Export
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-3">
                                <p class="fs-7">Manual:</p>
                            </div>
                            <div class="col-9">
                                <div class="col-12" :class="{
            'text-muted':
                orders[0].manualFiles?.filename ==
                null,
            'fst-italic':
                orders[0].manualFiles?.filename ==
                null,
        }">
                                    {{
            orders[0].manualFiles?.filename ??
            "not uploaded yet"
        }}
                                </div>
                                <div class="col-12 d-flex justify-content-end" v-if="orders[0].manualFiles?.filename">
                                    <a :href="'/storage/' +
            orders[0].manualFiles?.filepath
            " :download="orders[0].manualFiles?.filename
            " class="btn px-4 mx-2 btn-primary my-2 me-5">
                                        Export
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-2">
                            <div class="col-3">
                                <p class="fs-7">Safety Sheet:</p>
                            </div>
                            <div class="col-9">
                                <div class="col-12" :class="{
            'text-muted':
                orders[0].safetySheetFiles
                    ?.filename == null,
            'fst-italic':
                orders[0].safetySheetFiles
                    ?.filename == null,
        }">
                                    {{
            orders[0].safetySheetFiles?.filename ??
            "not uploaded yet"
        }}
                                </div>
                                <div class="col-12 d-flex justify-content-end"
                                    v-if="orders[0].safetySheetFiles?.filename">
                                    <a :href="'/storage/' +
            orders[0].safetySheetFiles?.filepath
            " :download="orders[0].safetySheetFiles?.filename
            " class="btn px-4 mx-2 btn-primary my-2 me-5">
                                        Export
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- <FileInputWithName label="Label File2" v-model="orders[0].multiFiles2"
                            @update:files="updateFiles1" @export-file="exportFile" /> -->
                    </div>
                    <div class="col-md-4">
                        <h4 class="text-milung mb-4 fw-bold">II. Price:</h4>

                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Selling Price:
                                </p>
                            </div>
                            <div class="col-8">
                                <!-- <input type="text"  class="form-control"> -->
                                {{ orders[0].sellingprice }} USD
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Total Order Value:
                                </p>
                            </div>
                            <div class="col-8">
                                <!-- <input type="text"  class="form-control"> -->
                                {{
            orders[0].sellingprice *
            orders[0].quantity_unit
        }}
                                USD
                            </div>
                        </div>
                        <h5 class="text-milung mb-4 fw-bold mt-3">
                            III. Delivery/Shipping Information:
                        </h5>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4">
                                <p for="v-model" class="fs-7">HS Code:</p>
                            </div>
                            <div class="col-8">
                                <p>{{ orders[0].product_group?.hs_de }}</p>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4">
                                <p for="v-model" class="fs-7">HS-CN Code:</p>
                            </div>
                            <div class="col-8">
                                <p>{{ orders[0].product_group?.hs_cn }}</p>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Latest SendOut Date:
                                </p>
                            </div>
                            <div class="col-8">
                                <p class="px-2 my-auto">
                                    {{ orders[0].sendoutdate }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Notice:
                                </p>
                            </div>
                            <div class="col-8">
                                <span class="my-4" v-for="item in orders[0].notice">
                                    {{ item }}<br />
                                </span>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">SO#:</p>
                            </div>
                            <div class="col-8">
                                {{
                                orders[0].shipment_orders?.so_number ??
                                "not provided yet"
                                }}
                            </div>
                        </div>

                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Shipping Document#:
                                </p>
                            </div>
                            <div class="col-8">
                                <p class="px-2 my-auto">
                                    {{ orders[0].ship_doc }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex col-12 my-4">
                            <div class="col-4 my-auto">
                                <p for="v-model" class="my-auto fs-7">
                                    Incoterm#:
                                </p>
                            </div>
                            <div class="col-8">
                                {{ orders[0].incoterm }}
                            </div>
                        </div>
                        <!-- <div class="d-flex col-12 my-4 bg-danger">
                            <p>XD Page not cleared</p>
                        </div> -->
                        <div class="d-flex col-12 my-4 d-flex justify-content-center">
                            <button class="btn btn-warning px-3 mx-2" name="action">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <progress-modal :show="showProgress"></progress-modal>
        <div class="container" v-if="isEditing">
            <printview :id="orders[0].id" :image="orders[0].files" />
        </div>
    </section>
</template>

<script>
// import { ref } from 'vue';
// import useForm from 'laravel-precognition-vue';
import ProgressModal from "../progress/ProgressModal.vue";
import "./../index";
import Swal from "sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import printview from "./printview.vue";
import NProgress from "nprogress";
import "nprogress/nprogress.css";

export default {
    components: {
        printview,
        ProgressModal,
    },
    props: {
        isEditing: {
            type: Boolean,
            default: false,
        },
    },

    data() {
        return {
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
                    capacity: [{ quantity: "", unit: "" }],
                },
            ],
        };
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
        // selectedGroup(newValue) {
        //     const selectedGroup = this.groups.find(group => group.id === newValue.id);
        //     console.log('Selected Group:', selectedGroup);
        //     if (selectedGroup) {
        //         // Create a new object with the updated properties
        //         const updatedGroup = Object.assign({}, this.orders[0].group, {
        //             hs_de: selectedGroup.hs_de,
        //             hs_cn: selectedGroup.hs_cn,
        //         });
        //         this.orders[0].group = updatedGroup;
        //     } else {
        //         // Reset the orders[0].group object if no group is selected
        //         this.orders[0].group = {};
        //     }
        // },
    },
    methods: {
        handleValidationErrors(validationErrors) {
            // Assuming you have a function to display toastr error messages
            validationErrors.forEach((message) => {
                toastr.error(message);
            });
        },
        importImage() {
            this.$refs.fileInput.click();
        },
        loadImage(event) {
            const file = event.target.files[0];
            this.orders[0].files = file;
            if (file) {
                const canvas = this.$refs.canvas;
                const ctx = canvas.getContext("2d");
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
                console.log("event", this.file);
                this.loadImageFromPath(this.file, this.$refs.canvas);
            }
        },

        async onSubmit() {
            this.showProgress = true;
            NProgress.start();
            console.log(this.orders[0].files);


            try {
                const formData = new FormData();
                formData.append("files",this.orders[0].files);

                // console.log(action);

                const response = await axios.post(
                    `/api/buyer/orderentry/${this.orders[0].id}`,
                    formData
                );
                NProgress.done();

                console.log(response);

                toastr.success('Product Photo Uploaded Successfully.');

                setTimeout(() => {
                    this.showProgress = false;
                }, 1000);

                this.$router.push({ name: "buyer_order_list" });
            } catch (error) {
                setTimeout(() => {
                    this.showProgress = false;
                }, 1000);
                NProgress.done();

                if (error.response && error.response.status === 422) {
                    const validationErrors = error.response.data.errors;
                    this.handleValidationErrors(validationErrors);
                } else {
                    console.error(error);
                    toastr.error(
                        this.isEditing
                            ? "An error occurred while updating the order"
                            : "An error occurred while adding the order"
                    );
                }
            };
        },

        loadImageFromPath(imageFileName, canvas) {
            const ctx = canvas.getContext("2d");
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
                console.log(
                    "Image loaded and drawn onto the canvas successfully."
                );
            };
            img.src = imageUrl;
        },
        fetchorder(orderId) {
            NProgress.start();

            axios
                .get(`/api/supplier/orderentry/${orderId}`)
                .then((response) => {
                    this.orders[0] = response.data;
                    console.log(this.orders[0]);
                    console.log("files ", this.orders[0].files);
                    this.loadImageFromPath(
                        this.orders[0].files[0]["filepath"],
                        this.$refs.canvas
                    );
                    NProgress.done();
                })
                .catch((error) => {
                    console.error(error);
                    NProgress.done();
                });
        },
    },
    mounted() {
        if (this.isEditing) {
            const orderId = this.$route.params.id;
            this.fetchorder(orderId);
            // console.log(this.orders[0]);
            //
        }
        this.$refs.fileInput.addEventListener('change', this.loadImage);
        NProgress.configure({ showSpinner: false });
    },
};
</script>

<style>
@import url("./../style.css");

#main {
    padding: 20px 0px !important;
}

.fs-7 {
    font-size: 14px !important;
}
</style>
