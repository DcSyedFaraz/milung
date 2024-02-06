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
                            <div class="col-8"><input type="text" v-model="article" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Name:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="name" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Description:</p>
                            </div>
                            <div class="col-8">
                                <textarea v-model="description" class="form-control" cols="36" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Group:</p>
                            </div>
                            <div class="col-8">
                                <select class="form-control" v-model="group">
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
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Cargo Classification:</p>
                            </div>
                            <div class="col-8">
                                <div class="d-flex">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="general" v-model="cargo">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            General Cargo
                                        </label>
                                    </div>
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="radio" value="danger" v-model="cargo">
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
                                        <input class="form-check-input" type="checkbox" v-model="cargo_place" value="china">
                                        <label class="form-check-label" for="flexCheckDefault2">
                                            Mainland China
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Color:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="color" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4 ">
                                <p for="v-model" class="">Product Material:</p>
                            </div>
                            <div class="col-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="material" />
                                    <span class="input-group-text">mm</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4 ">
                                <p for="v-model" class="">Product Size (L*W*H)/(L*Dia):</p>
                            </div>
                            <div class="col-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="size" />
                                    <span class="input-group-text">mm</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4 ">
                                <p for="v-model" class="" style="font-size: 0.9rem!important;">Product Net Weight (Product
                                    Only
                                    per
                                    pcs):</p>
                            </div>
                            <div class="col-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="weight" />
                                    <span class="input-group-text">g</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Specifications:</p>
                            </div>
                            <div class="col-8">
                                <textarea v-model="specification" class="form-control" cols="36" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">Product Memory Storage (if
                                    applicable):
                                </p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="memory" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Features:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="feature" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">Specify Accrssories (i.e
                                    Cable,Manual,etc):
                                </p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="accessory" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">Accessories Total Net Weight
                                    (Accessories
                                    Only per pc):</p>
                            </div>
                            <div class="col-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="accessory_weight" />
                                    <span class="input-group-text">g</span>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase">3. Battery Details</h3>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Battey Type:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="battery_type" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Battey Rated Capacity:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="text" v-model="rated" class="form-control">
                                    <input type="text" v-model="capacity" class="form-control">
                                    <span class="input-group-text px-3"> mAh/Wh </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Battey Nominal Voltage:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="voltage" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">No. of Battey Contained:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="number" v-model="pcs" class="form-control">
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
                                    <input type="number" v-model="mAh" class="form-control">
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
                                    <input type="number" v-model="mm" class="form-control">
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
                                    <input type="number" v-model="gram" class="form-control">
                                    <span class="input-group-text px-3"> g </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">MSDS IATA Edition No.:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="edition" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">MSDS Expiry Date:</p>
                            </div>
                            <div class="col-8">
                                <input type="date" v-model="msds_expiry" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">UN38.3 Expiry Date:</p>
                            </div>
                            <div class="col-8">
                                <input type="date" v-model="un_expiry" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">CN Air Safety Report Expiry Date:</p>
                            </div>
                            <div class="col-8 ">
                                <input type="date" v-model="air_safety_expiry" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">CN Sea Safety Report Expiry Date:</p>
                            </div>
                            <div class="col-8 ">
                                <input type="date" v-model="sea_safety_expiry" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">CN Train Safety Report Expiry Date:
                                </p>
                            </div>
                            <div class="col-8">
                                <input type="date" v-model="train_safety_expiry" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-milung fw-bold text-uppercase">2. Product Photo</h3>
                        <div class="d-flex col-11 my-2">
                            <ImageSelector @imagesSelected="handleImagesSelected" />
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">Validate Certificate & Testing Report:
                                    (CE,ROHS,RED,REACH,LFGB,FSC,etc.)</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="certificate" class="form-control">
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase">4. Printing Details</h3>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">Standart Printing Method:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="printing_method" class="form-control">
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
                                    <input type="number" v-model="unit_packaging_paper" class="form-control">
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
                                    <input type="number" v-model="unit_packaging_plastic" class="form-control">
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
                                    <input type="number" v-model="unit_packaging_metal" class="form-control">
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
                                    <input type="number" v-model="unit_packaging_others" class="form-control">
                                    <span class="input-group-text px-3"> g </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="v-model">Specify Packaging Material:</p>
                            </div>
                            <div class="col-6">
                                <input type="text" v-model="packaging_material" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="v-model" style="font-size: 0.9rem!important;">Total Packaging Net Weight:</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" v-model="packaging_weight" class="form-control">
                                    <span class="input-group-text px-3"> g </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="v-model">Standard Packaging:</p>
                            </div>
                            <div class="col-6">
                                <input type="text" v-model="standart_packaging" class="form-control">
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase mt-4">6. Manual, Label, Safety Sheet</h3>

                        <fileinput label="Safety Sheet:" inputName="safety_sheet" @file-uploaded="handleFileUploaded">
                        </fileinput>
                        <fileinput label="Manual:" inputName="manual" @file-uploaded="handleFileUploaded"></fileinput>
                        <fileinput label="Product Label:" inputName="product_label" @file-uploaded="handleFileUploaded">
                        </fileinput>
                        <fileinput label="Packaging Label:" inputName="packaging_label" @file-uploaded="handleFileUploaded">
                        </fileinput>

                    </div>
                </div>
            </div>
            <div class="container d-flex p-4" style="background-color: #14245c;">
                <div class="text-uppercase text-white col-4 fw-bolder my-auto">8. Quote Expire Date:</div>
                <div class="col-6 d-flex">
                    <VueDatePicker calendar-cell-class-name="dp-custom-cell" class="dp__new" v-model="quoteExpiredDate"
                        mode='single' format="dd-mm-yyyy"></VueDatePicker>
                    <button class="btn btn-warning mx-2 fw-bold" type="reset">Reset</button>
                </div>
            </div>
        </form>
    </section>
</template>

<script>
import ImageSelector from './product/imageselector.vue';
import fileinput from './product/file-input.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import './index';




export default {
    components: {
        ImageSelector,
        fileinput,
        VueDatePicker
    },
    data() {
        return {
            quoteExpiredDate: '',
            article: '',
            name: '',
            description: '',
            group: '',
            cargo: '',
            cargo_place: [],
            color: '',
            material: '',
            size: '',
            weight: '',
            specification: '',
            memory: '',
            feature: '',
            accessory: '',
            accessory_weight: '',
            battery_type: '',
            rated: '',
            capacity: '',
            voltage: '',
            pcs: 0,
            mAh: 0,
            mm: 0,
            gram: 0,
            edition: '',
            msds_expiry: '',
            un_expiry: '',
            air_safety_expiry: '',
            sea_safety_expiry: '',
            train_safety_expiry: '',
            certificate: '',
            printing_method: '',
            unit_packaging_paper: 0,
            unit_packaging_plastic: 0,
            unit_packaging_metal: 0,
            unit_packaging_others: 0,
            packaging_material: '',
            packaging_weight: 0,
            standart_packaging: '',
            safety_sheet: null,
            manual: null,
            product_label: null,
            packaging_label: null,
            selectedImages: [],
            selectedFiles: [],
            uploadedFiles: {},
        };
    },

    mounted() {

    },
    created() {
        // this.fetchUsers();
    },
    methods: {

        handleFileUploaded(inputName, fileName) {
            console.log(`File uploaded for input ${inputName}: ${fileName}`);
            this.uploadedFiles[inputName] = fileName;
        },
        handleImagesSelected(images) {
            // Update selectedImages in parent component
            // console.log(images);
            this.selectedImages = images;
            // this.selectedFiles.push(images);

            // Convert Blob objects to File objects
            const formData = new FormData();

            images.forEach((image, index) => {
                const file = new File([image], `image_${Date.now()}_${index}.png`, {
                    type: image.type,
                    lastModified: Date.now(),
                });
                formData.append(`image_${index}`, file);
            });

            // Store the selected images in the uploadedFiles object
            const fileArray = Array.from(formData.keys()).map(key => formData.get(key));
            this.uploadedFiles.images = fileArray;
            console.log('new', this.uploadedFiles.images);
        },

        dataURItoBlob(dataURI) {
            const splitData = dataURI.split(',');
            const hasBase64 = splitData[0].indexOf('base64') !== -1;

            let byteString;
            if (hasBase64) {
                byteString = atob(splitData[1]);
            } else {
                byteString = unescape(splitData[1]);
            }

            const ab = new ArrayBuffer(byteString.length);
            const ia = new Uint8Array(ab);

            for (let i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }

            return new Blob([ab], { type: 'image/png' });
        },


        async submitForm() {
            console.log("Form submitted with images:", this.selectedImages);

            // Create a new FormData object
            const formData = new FormData();

            // Define an array of field names
            const formFields = [
                'article', 'name', 'description', 'group', 'cargo', 'cargo_place', 'color',
                'material', 'size', 'weight', 'specification', 'memory', 'feature', 'accessory',
                'accessory_weight', 'battery_type', 'rated', 'capacity', 'voltage', 'pcs',
                'mAh', 'mm', 'gram', 'edition', 'msds_expiry', 'un_expiry', 'air_safety_expiry',
                'sea_safety_expiry', 'train_safety_expiry', 'certificate', 'printing_method',
                'unit_packaging_paper', 'unit_packaging_plastic', 'unit_packaging_metal',
                'unit_packaging_others', 'packaging_material', 'packaging_weight', 'standart_packaging'
            ];

            // Append form fields to FormData dynamically
            formFields.forEach(field => {
                formData.append(field, this[field]);
            });

            this.selectedImages.forEach((image, index) => {
                const file = this.dataURItoBlob(image);
                const originalName = `image_${index}.${file.type.split('/')[1]}`;
                formData.append('images[]', file, originalName);
            });

            // if (this.selectedFiles.length > 0) {
            //     for (const file of this.selectedFiles) {
            //         formData.append("imagesss[]", file);
            //     }
            // }
            // if (this.uploadedFiles.images && this.uploadedFiles.images.length > 0) {
            //     this.uploadedFiles.images.forEach((image, index) => {
            //         formData.append(`images[${index}]`, image);
            //     });
            // }

            // Append file inputs to the FormData object
            Object.entries(this.uploadedFiles).forEach(([inputName, fileName]) => {
                formData.append(inputName, this.uploadedFiles[inputName]);
            });
            // const token = this.$store.state.authToken;
            // if (token) {
            //     axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            // }


            try {
                // Send the form data to the API endpoint
                const addProduct = await axios.post('/api/addprod', formData);

                if (addProduct.status === 201) {
                    toastr.success(addProduct.data.message);
                    this.$router.push({ name: 'product' });
                } else {
                    // Handle other status codes or unexpected responses
                    toastr.error('Unexpected response from the server');
                }
            } catch (error) {
                console.error('Error submitting form:', error);
                toastr.error('An error occurred while submitting the form');
            }
        },


    },
};
</script>

<style scoped>
@import url('./style.css');

.dp-custom-cell {
    border-radius: 50%;
}

.dp__input_icon {
    color: #009de1 !important;
}

.rotate-icon {
    transform: rotate(180deg);
}
</style>
