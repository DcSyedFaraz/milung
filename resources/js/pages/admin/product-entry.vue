<template>
    <section class="section">
        <form @submit.prevent="submitForm">

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
                                <p for="name">Article Number:</p>
                            </div>
                            <div class="col-8"><input type="text" name="article" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name">Product Name:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name">Product Description:</p>
                            </div>
                            <div class="col-8">
                                <textarea name="description" class="form-control" cols="36" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
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
                        <div class="d-flex col-11 my-2">
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
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name">Product Color:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" name="color" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4 ">
                                <p for="name" class="">Product Material:</p>
                            </div>
                            <div class="col-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="material" />
                                    <span class="input-group-text">mm</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4 ">
                                <p for="name" class="">Product Size (L*W*H)/(L*Dia):</p>
                            </div>
                            <div class="col-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="size" />
                                    <span class="input-group-text">mm</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex col-11 my-2">
                            <div class="col-4 ">
                                <p for="name" class="" style="font-size: 0.9rem!important;">Product Net Weight (Product Only
                                    per
                                    pcs):</p>
                            </div>
                            <div class="col-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="weight" />
                                    <span class="input-group-text">g</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name">Product Specifications:</p>
                            </div>
                            <div class="col-8">
                                <textarea name="specification" class="form-control" cols="36" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name" style="font-size: 0.9rem!important;">Product Memory Storage (if applicable):
                                </p>
                            </div>
                            <div class="col-8">
                                <input type="text" name="memory" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name">Product Features:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" name="feature" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name" style="font-size: 0.9rem!important;">Specify Accrssories (i.e
                                    Cable,Manual,etc):
                                </p>
                            </div>
                            <div class="col-8">
                                <input type="text" name="accessory" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name" style="font-size: 0.9rem!important;">Accessories Total Net Weight (Accessories
                                    Only per pc):</p>
                            </div>
                            <div class="col-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="accessory_weight" />
                                    <span class="input-group-text">g</span>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase">3. Battery Details</h3>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name">Battey Type:</p>
                            </div>
                            <div class="col-8"><input type="text" name="battery_type" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name">Battey Rated Capacity:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="text" name="rated" class="form-control">
                                    <input type="text" name="capacity" class="form-control">
                                    <span class="input-group-text px-3"> mAh/Wh </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name">Battey Nominal Voltage:</p>
                            </div>
                            <div class="col-8"><input type="text" name="voltage" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name">No. of Battey Contained:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="number" name="pcs" class="form-control">
                                    <span class="input-group-text px-3"> pcs </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name">No. of Battey Contained:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="number" name="mAh" class="form-control">
                                    <span class="input-group-text px-3"> mAh </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name">No. of Battey Contained:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="number" name="mm" class="form-control">
                                    <span class="input-group-text px-3"> mm </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name">No. of Battey Contained:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="number" name="gram" class="form-control">
                                    <span class="input-group-text px-3"> g </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name">MSDS IATA Edition No.:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" name="edition" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name">MSDS Expiry Date:</p>
                            </div>
                            <div class="col-8">
                                <input type="date" name="msds_expiry" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name">UN38.3 Expiry Date:</p>
                            </div>
                            <div class="col-8">
                                <input type="date" name="un_expiry" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name" style="font-size: 0.9rem!important;">CN Air Safety Report Expiry Date:</p>
                            </div>
                            <div class="col-8 ">
                                <input type="date" name="air_safety_expiry" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name" style="font-size: 0.9rem!important;">CN Sea Safety Report Expiry Date:</p>
                            </div>
                            <div class="col-8 ">
                                <input type="date" name="sea_safety_expiry" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name" style="font-size: 0.9rem!important;">CN Train Safety Report Expiry Date:</p>
                            </div>
                            <div class="col-8">
                                <input type="date" name="train_safety_expiry" class="form-control">
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
                                <p for="name" style="font-size: 0.9rem!important;">Validate Certificate & Testing Report:
                                    (CE,ROHS,RED,REACH,LFGB,FSC,etc.)</p>
                            </div>
                            <div class="col-8">
                                <input type="text" name="certificate" class="form-control">
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase">4. Printing Details</h3>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="name" style="font-size: 0.9rem!important;">Standart Printing Method:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" name="printing_method" class="form-control">
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase">5. Packing Details</h3>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="name" style="font-size: 0.9rem!important;">Unit Packaging (1 pc) Net Weight
                                    (not include product) -Paper:</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" name="unit_packaging_paper" class="form-control">
                                    <span class="input-group-text px-3"> g </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="name" style="font-size: 0.9rem!important;">Unit Packaging (1 pc) Net Weight
                                    (not include product) -Plastic:</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" name="unit_packaging_plastic" class="form-control">
                                    <span class="input-group-text px-3"> g </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="name" style="font-size: 0.9rem!important;">Unit Packaging (1 pc) Net Weight
                                    (not include product) -Metal:</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" name="unit_packaging_metal" class="form-control">
                                    <span class="input-group-text px-3"> g </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="name" style="font-size: 0.9rem!important;">Unit Packaging (1 pc) Net Weight
                                    (not include product) -Others:</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" name="unit_packaging_others" class="form-control">
                                    <span class="input-group-text px-3"> g </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="name">Specify Packaging Material:</p>
                            </div>
                            <div class="col-6">
                                <input type="text" name="packaging_material" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="name" style="font-size: 0.9rem!important;">Total Packaging Net Weight:</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" name="packaging_weight" class="form-control">
                                    <span class="input-group-text px-3"> g </span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="name">Standard Packaging:</p>
                            </div>
                            <div class="col-6">
                                <input type="text" name="standart_packaging" class="form-control">
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase mt-4">6. Manual, Label, Safety Sheet</h3>
                        <!-- <div class="d-flex my-2">
                            <div class="col-3 mt-3">Safety Sheet:</div>
                            <div class="col-5 mt-2">
                                <input type="text" name="safety_sheet" disabled v-model="selectedFileNames.safety_sheet" class="form-control w-full">
                            </div>
                            <div class="col-4">
                                <button type="button" class="btn-sm btn btn-light rotate-icon" @click="uploadFile('safety_sheet')"><i
                                        class="bi bi-arrow-up-right-square fs-2 text-success"></i></button>
                                <input ref="fileInput" type="file" style="display: none" @change="handleFileChange">
                                <button type="button" class="btn-sm btn btn-light "><i
                                        class="bi bi-arrow-up-right-square fs-2 text-primary"></i></button>
                            </div>
                        </div> -->
                        <fileinput label="Safety Sheet:" inputName="safety_sheet" @file-uploaded="handleFileUploaded">
                        </fileinput>
                        <fileinput label="Manual:" inputName="manual" @file-uploaded="handleFileUploaded"></fileinput>

                    </div>
                </div>
            </div>
        </form>
    </section>
</template>

<script>
import ImageSelector from './product/imageselector.vue';
import fileinput from './product/file-input.vue';
import './index';




export default {
    components: {
        ImageSelector,
        fileinput
    },
    data() {
        return {
            // selectedFileNames: {
            //     safety_sheet: '',
            //     another_input: '',
            //     // Add other input names here
            // },
            selectedImages: [],
            updateuser: {
                // id: this.$route.params.id,
                name: '',
                email: '',
                status: '',
                buyer_id: '',
                roles: '',
            },

        };
    },
    mounted() {

    },
    created() {
        // this.fetchUsers();
    },
    methods: {
        // uploadFile(inputName) {
        //     if (inputName === 'safety_sheet') {
        //         this.$refs.fileInput.click();
        //     }
        // },
        // handleFileChange() {
        //     const fileInput = this.$refs.fileInput;
        //     console.log(fileInput);
        //     this.selectedFileNames[fileInput.name] = fileInput.files.length > 0 ? fileInput.files[0].name : '';
        // },
        handleFileUploaded(inputName, fileName) {
            console.log(`File uploaded for input ${inputName}: ${fileName}`);
        },
        handleImagesSelected(images) {
            // Update selectedImages in parent component
            console.log(images);
            this.selectedImages = images;
        },

        submitForm() {
            console.log("Form submitted with images:", this.selectedImages);
            // const formData = {
            //     staticsitems: this.staticsitems,
            //     adminitems: this.adminitems,
            //     operationitems: this.operationitems,
            //     financeitems: this.financeitems,
            // };

            // Send formData to your API
            // console.log('Form Data:', formData);
            // try {
            //     const response = await axios.put(`/api/updateusers/${id}`, [this.updateuser, formData]);

            //     if (response.status === 200) {
            //         toastr.success('User updated successfully');
            //         this.$router.push({ name: 'user' });
            //     }
            // } catch (error) {
            //     if (error.response.status === 422) {
            //         toastr.error('Please fix the validation errors and try again');
            //     } else {
            //         toastr.error('An error occurred while updating the user');
            //     }
            // }
        },


    },
};
</script>

<style scoped>
@import url('./style.css');

.rotate-icon {
    transform: rotate(180deg);
}
</style>
