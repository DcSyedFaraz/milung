<template>
    <section class="section">
        <form @submit.prevent="submitForm" enctype="multipart/form-data">

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
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Article Number:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="product.article" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Status:</p>
                            </div>
                            <div class="col-8">
                                <select v-model="product.status" class="form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">InActive</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Name:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="product.name" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Description:</p>
                            </div>
                            <div class="col-8">
                                <textarea v-model="product.description" class="form-control" cols="36"
                                    rows="10"></textarea>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Group:</p>
                            </div>
                            <div class="col-8">
                                <multiselect v-model="group" :options="productOptions" label="group_name" track-by="id">
                                </multiselect>
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
                                            v-model="product.cargo">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            General Cargo
                                        </label>
                                    </div>
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="radio" value="danger"
                                            v-model="product.cargo">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Danger Goods
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex my-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" v-model="product.cargo_place"
                                            value="hongkong">
                                        <label class="form-check-label" for="flexCheckDefault1">
                                            Hong Kong
                                        </label>
                                    </div>
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="checkbox" v-model="product.cargo_place"
                                            value="china">
                                        <label class="form-check-label" for="flexCheckDefault2">
                                            Mainland China
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex col-11 ">
                            <div class="col-4 my-auto">
                                <label for="chips-input">Product Colors:</label>
                            </div>
                            <div class="col-8">
                                <Chips v-model="product.color" />
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4 ">
                                <p for="v-model" class="">Product Material:</p>
                            </div>
                            <div class="col-7">
                                <div class="input-group">
                                    <Chips v-model="product.material" />
                                    <!-- <span class="input-group-text">mm</span> -->
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4 ">
                                <p for="v-model" class="">Product Size (L*W*H)/(L*Dia):</p>
                            </div>
                            <div class="col-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="product.size" />
                                    <span class="input-group-text">mm</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4 ">
                                <p for="v-model" class="" style="font-size: 0.9rem!important;">Product Net Weight
                                    (Product
                                    Only
                                    per
                                    pcs):</p>
                            </div>
                            <div class="col-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="product.weight" />
                                    <span class="input-group-text">g</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Specifications:</p>
                            </div>
                            <div class="col-8">
                                <textarea v-model="product.specification" class="form-control" cols="36"
                                    rows="10"></textarea>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">Product Memory Storage (if
                                    applicable):
                                </p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="product.memory" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Features:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="product.feature" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">Specify Accrssories (i.e
                                    Cable,Manual,etc):
                                </p>
                            </div>
                            <div class="col-8">
                                <Chips v-model="product.accessory" />
                                <!-- <input type="text" v-model="product.accessory" class="form-control"> -->
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">Accessories Total Net Weight
                                    (Accessories
                                    Only per pc):</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group d-flex">
                                    <input type="text" class="form-control" v-model="product.accessory_weight" />
                                    <span class="input-group-text">g</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4 ">
                                <p for="v-model" class=" fs-7">HS-DE Code:</p>
                            </div>
                            <div class="col-8">
                                <p>{{ group.hs_de }}</p>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4 ">
                                <p for="v-model" class=" fs-7">HS-CN Code:</p>
                            </div>
                            <div class="col-8">
                                <p>{{ group.hs_cn }}</p>
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase">7. Battery Details</h3>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Battey Type:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="product.battery_type" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Battey Rated Capacity:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="text" v-model="product.rated" class="form-control">
                                    <input type="text" v-model="product.capacity" class="form-control">
                                    <span class="input-group-text px-3"> mAh/Wh </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Battey Nominal Voltage:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="product.voltage" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">No. of Battey Contained:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="number" v-model="product.pcs" class="form-control">
                                    <span class="input-group-text px-3"> pcs </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">No. of Battey Contained:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="number" v-model="product.mAh" class="form-control">
                                    <span class="input-group-text px-3"> mAh </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">No. of Battey Contained:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="number" v-model="product.mm" class="form-control">
                                    <span class="input-group-text px-3"> mm </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">No. of Battey Contained:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="number" v-model="product.gram" class="form-control">
                                    <span class="input-group-text px-3"> g </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">MSDS IATA Edition No.:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="product.edition" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">MSDS Expiry Date:</p>
                            </div>
                            <div class="col-8">
                                <input type="date" v-model="product.msds_expiry" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">UN38.3 Expiry Date:</p>
                            </div>
                            <div class="col-8">
                                <input type="date" v-model="product.un_expiry" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">CN Air Safety Report Expiry Date:
                                </p>
                            </div>
                            <div class="col-8 ">
                                <input type="date" v-model="product.air_safety_expiry" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">CN Sea Safety Report Expiry Date:
                                </p>
                            </div>
                            <div class="col-8 ">
                                <input type="date" v-model="product.sea_safety_expiry" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">CN Train Safety Report Expiry
                                    Date:
                                </p>
                            </div>
                            <div class="col-8">
                                <input type="date" v-model="product.train_safety_expiry" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-milung fw-bold text-uppercase">2. Product Photo</h3>
                        <div class="d-flex col-11 my-2">
                            <ImageSelector @imagesSelected="handleImagesSelected" />
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase">3. Certificates & Test Reports</h3>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">Validate Certificate & Testing
                                    Report:
                                    (CE,ROHS,RED,REACH,LFGB,FSC,etc.)</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="product.certificate" class="form-control">
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase">4. Printing Details</h3>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">Standard Printing Method:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="product.printing_method" class="form-control">
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase">5. Packing Details</h3>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="v-model" style="font-size: 0.9rem!important;">Unit Packaging (1 pc) Net Weight
                                    (not include product) -Paper:</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" v-model="product.unit_packaging_paper" class="form-control">
                                    <span class="input-group-text px-3"> g </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="v-model" style="font-size: 0.9rem!important;">Unit Packaging (1 pc) Net Weight
                                    (not include product) -Plastic:</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" v-model="product.unit_packaging_plastic" class="form-control">
                                    <span class="input-group-text px-3"> g </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="v-model" style="font-size: 0.9rem!important;">Unit Packaging (1 pc) Net Weight
                                    (not include product) -Metal:</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" v-model="product.unit_packaging_metal" class="form-control">
                                    <span class="input-group-text px-3"> g </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="v-model" style="font-size: 0.9rem!important;">Unit Packaging (1 pc) Net Weight
                                    (not include product) -Others:</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" v-model="product.unit_packaging_others" class="form-control">
                                    <span class="input-group-text px-3"> g </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="v-model">Specify Packaging Material:</p>
                            </div>
                            <div class="col-6">
                                <input type="text" v-model="product.packaging_material" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="v-model" style="font-size: 0.9rem!important;">Total Packaging Net Weight:</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" v-model="product.packaging_weight" class="form-control">
                                    <span class="input-group-text px-3"> g </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="v-model">Standard Packaging:</p>
                            </div>
                            <div class="col-6">
                                <input type="text" v-model="product.standart_packaging" class="form-control">
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase mt-4">6. Manual, Label, Safety Sheet</h3>

                        <fileinput label="Safety Sheet:" inputName="safety_sheet" @file-uploaded="handleFileUploaded">
                        </fileinput>
                        <fileinput label="Manual:" inputName="manual" @file-uploaded="handleFileUploaded"></fileinput>
                        <fileinput label="Product Label:" inputName="product_label" @file-uploaded="handleFileUploaded">
                        </fileinput>
                        <fileinput label="Packaging Label:" inputName="packaging_label"
                            @file-uploaded="handleFileUploaded">
                        </fileinput>

                    </div>
                </div>
            </div>
            <div class="container d-flex p-4" style="background-color: #14245c;">
                <div class="text-uppercase text-white col-4 fw-bolder my-auto">8. Quote Expire Date:</div>
                <div class="col-6 d-flex">
                    <VueDatePicker calendar-cell-class-name="dp-custom-cell" class="dp__new" v-model="Dates"
                        mode='single' format="dd-MM-yyyy" @input="sendDateOnly"></VueDatePicker>
                    <button class="btn btn-warning mx-2 fw-bold" type="reset">Reset</button>
                </div>
            </div>
        </form>
    </section>
    <div v-if="loader" class="loader-overlay">
        <div class="loader"></div>
    </div>
</template>

<script>
import ImageSelector from './imageselector.vue';
import fileinput from './file-input.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';




export default {
    emits: ['profileUpdated'],
    components: {
        ImageSelector,
        fileinput,
        VueDatePicker,
    },
    data() {
        return {
            loader: false,
            group: '',
            Dates: '',
            productOptions: [],
            selectedImages: [],
            selectedFiles: [],
            uploadedFiles: {},
            product: {
                cargo_place: [],
                color: [],
                material: [],
                accessory: [],
                safety_sheet: null,
                manual: null,
                product_label: null,
                packaging_label: null,
            },
        };
    },
    mounted() {
        this.fetchProductOptions();
    },
    watch: {
        Dates: function (newDate, oldDate) {
            this.sendDateOnly();
        }
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
        handleFileUploaded(inputName, fileName) {
            console.log(`File uploaded for input ${inputName}: ${fileName}`);
            this.uploadedFiles[inputName] = fileName;
        },
        handleImagesSelected(images) {
            // Update selectedImages in parent component
            console.log('new  ', images);
            this.selectedImages = images;
        },
        sendDateOnly() {

            // Extract date part from quoteExpiredDate
            const selectedDate = new Date(this.Dates);
            const formattedDate = `${selectedDate.getFullYear()}-${selectedDate.getMonth() + 1}-${selectedDate.getDate()}`;
            this.product.quoteExpiredDate = formattedDate;
            // Now you can send the formattedDate to your backend
            console.log('Selected Date:', this.product.quoteExpiredDate);
        },
        async submitForm() {
            this.loader = true;

            this.product.color = Array.isArray(this.product.color) ? this.product.color : [this.product.color];
            this.product.material = Array.isArray(this.product.material) ? this.product.material : [this.product.material];
            this.product.accessory = Array.isArray(this.product.accessory) ? this.product.accessory : [this.product.accessory];
            // Create a new FormData object
            const formData = new FormData();


            formData.append('group', this.group.id);
            // Append form fields to FormData dynamically
            Object.keys(this.product).forEach((key) => {
                formData.append(key, this.product[key]);
            });
            for (const image of this.selectedImages) {
                formData.append('images[]', image);
            }

            console.log(formData);
            // Append file inputs to the FormData object
            Object.entries(this.uploadedFiles).forEach(([inputName, fileName]) => {
                formData.append(inputName, this.uploadedFiles[inputName]);
            });
            // const token = this.$store.state.authToken;
            // if (token) {
            //     axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            // }

            try {
                console.log(this.group.id);
                // Send the form data to the API endpoint
                const addProduct = await axios.post('/api/addprod', formData);
                this.loader = false;
                if (addProduct.status === 201) {
                    toastr.success(addProduct.data.message);
                    this.$router.push({ name: 'product' });
                } else {
                    // Handle other status codes or unexpected responses
                    toastr.error('Unexpected response from the server');
                }
            } catch (error) {
                this.loader = false;
                if (error.response.status === 422) {
                    const validationErrors = error.response.data.errors;
                    this.handleValidationErrors(validationErrors);
                } else {
                    toastr.error('An error occurred while updating the user');
                }
            }
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
    },
};
</script>

<style>
.dp-custom-cell {
    border-radius: 50%;
}

.dp__input_icon {
    color: #009de1 !important;
}

.rotate-icon {
    transform: rotate(180deg);
}

.p-chips-token {
    background-color: #009de1 !important;
    color: white !important;

}

.p-chips-form {
    position: relative !important;
    flex: 1 1 auto !important;
    width: 1% !important;
    min-width: 0 !important;
}

.p-chips-multiple-container {
    margin-bottom: 0 !important;

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
