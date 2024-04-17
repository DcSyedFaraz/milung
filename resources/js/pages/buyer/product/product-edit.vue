<template>
    <section class="section">

        <div class="container">

            <div class="row my-5">
                <div class="col-md-6">
                    <h3 class="text-milung fw-bold text-uppercase">1. Product Information</h3>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">Article Number:</p>
                        </div>
                        <div class="col-8">
                            {{ product.article }}</div>
                    </div>

                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">Product Name:</p>
                        </div>
                        <div class="col-8">
                            {{ product.name }}
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">Product Description:</p>
                        </div>
                        <div class="col-8">
                            {{ product.description }}
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">Product Group:</p>
                        </div>
                        <div class="col-8">
                            {{ product.product_group?.group_name }}
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">Cargo Classification:</p>
                        </div>
                        <div class="col-8">
                            <div class="d-flex">
                                <span v-if="product.cargo == 'general'" class="badge bg-primary">General Cargo</span>
                                <span v-else-if="product.cargo == 'danger'" class="badge bg-primary">Danger Goods</span>

                            </div>
                            <div class="d-flex my-2" v-if="product.cargo_place">
                                <span v-if="product.cargo_place.split(',').includes('china')"
                                    class="badge bg-success me-2">Mainland China</span>
                                <span v-if="product.cargo_place.split(',').includes('hongkong')"
                                    class="badge bg-success">Hong Kong</span>
                            </div>


                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">Product Color:</p>
                        </div>
                        <div class="col-8">
                            {{ product.color }}
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4 ">
                            <p for="v-model" class="">Product Material:</p>
                        </div>
                        <div class="col-5">
                            {{ product.material }} mm
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4 ">
                            <p for="v-model" class="">Product Size (L*W*H)/(L*Dia):</p>
                        </div>
                        <div class="col-5">
                            {{ product.size }} mm
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
                            {{ product.weight }} g
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">Product Specifications:</p>
                        </div>
                        <div class="col-8">
                            {{ product.specification }}
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model" style="font-size: 0.9rem!important;">Product Memory Storage (if
                                applicable):
                            </p>
                        </div>
                        <div class="col-8">
                            {{ product.memory }}
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">Product Features:</p>
                        </div>
                        <div class="col-8">
                            {{ product.feature }}
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model" style="font-size: 0.9rem!important;">Specify Accrssories (i.e
                                Cable,Manual,etc):
                            </p>
                        </div>
                        <div class="col-8">
                            {{ product.accessory }}
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model" style="font-size: 0.9rem!important;">Accessories Total Net Weight
                                (Accessories
                                Only per pc):</p>
                        </div>
                        <div class="col-4">
                            {{ product.accessory_weight }} g
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4 ">
                            <p for="v-model" class=" fs-7">HS Code:</p>
                        </div>
                        <div class="col-8">
                            {{ product.product_group?.hs_de }}
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4 ">
                            <p for="v-model" class=" fs-7">HS-CN Code:</p>
                        </div>
                        <div class="col-8">
                            {{ product.product_group?.hs_cn }}
                        </div>
                    </div>
                    <h3 class="text-milung fw-bold text-uppercase">3. Battery Details</h3>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">Battey Type:</p>
                        </div>
                        <div class="col-8">{{ product.battery_type }}</div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">Battey Rated Capacity:</p>
                        </div>
                        <div class="col-8">
                            <div class="d-flex">
                                {{ product.rated }}
                                {{ product.capacity }} mAh/Wh
                            </div>
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">Battey Nominal Voltage:</p>
                        </div>
                        <div class="col-8">{{ product.voltage }}</div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">No. of Battey Contained:</p>
                        </div>
                        <div class="col-8">
                            {{ product.pcs }} pcs
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">No. of Battey Contained:</p>
                        </div>
                        <div class="col-8">
                            {{ product.mAh }} mAh
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">No. of Battey Contained:</p>
                        </div>
                        <div class="col-8">
                            {{ product.mm }} mm
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">No. of Battey Contained:</p>
                        </div>
                        <div class="col-8">
                            {{ product.gram }} g
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">MSDS IATA Edition No.:</p>
                        </div>
                        <div class="col-8">
                            {{ product.edition }}
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">MSDS Expiry Date:</p>
                        </div>
                        <div class="col-8">
                            {{ product.msds_expiry }}
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model">UN38.3 Expiry Date:</p>
                        </div>
                        <div class="col-8">
                            {{ product.un_expiry }}
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model" style="font-size: 0.9rem!important;">CN Air Safety Report Expiry Date:
                            </p>
                        </div>
                        <div class="col-8 ">
                            {{ product.air_safety_expiry }}
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model" style="font-size: 0.9rem!important;">CN Sea Safety Report Expiry Date:
                            </p>
                        </div>
                        <div class="col-8 ">
                            {{ product.sea_safety_expiry }}
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model" style="font-size: 0.9rem!important;">CN Train Safety Report Expiry
                                Date:
                            </p>
                        </div>
                        <div class="col-8">
                            {{ product.train_safety_expiry }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3 class="text-milung fw-bold text-uppercase">2. Product Photo</h3>
                    <div class="d-flex col-11 my-2">
                        <div class="col-12">
                            <div v-if="product.images !== null && product.images?.length > 0"
                                class="carousel-container">

                                <!-- Bootstrap Carousel -->
                                <div id="imageCarousel" class="carousel carousel-dark slide" data-bs-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li v-for="(image, index) in product.images" :key="index"
                                            :data-bs-target="'#imageCarousel'" :data-bs-slide-to="index"
                                            :class="{ 'active': index === 0 }"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <div v-for="(image, index) in product.images" :key="index"
                                            :class="{ 'carousel-item': true, 'active': index === 0 }">
                                            <img :src="'/storage/' + image.path" class="d-block w-100"
                                                style="height: 300px; object-fit: cover;" alt="Image">
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button v-if="product.images !== null && product.images?.length > 0" @click="downloadAllImages"
                        class="btn btn-primary">Download All Images</button>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model" style="font-size: 0.9rem!important;">Validate Certificate & Testing
                                Report:
                                (CE,ROHS,RED,REACH,LFGB,FSC,etc.)</p>
                        </div>
                        <div class="col-8">
                            {{ product.certificate }}
                        </div>
                    </div>
                    <h3 class="text-milung fw-bold text-uppercase">4. Printing Details</h3>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p for="v-model" style="font-size: 0.9rem!important;">Standart Printing Method:</p>
                        </div>
                        <div class="col-8">
                            {{ product.printing_method }}
                        </div>
                    </div>
                    <h3 class="text-milung fw-bold text-uppercase">5. Packing Details</h3>
                    <div class="d-flex col-11 my-2">
                        <div class="col-6">
                            <p for="v-model" style="font-size: 0.9rem!important;">Unit Packaging (1 pc) Net Weight <br>
                                (not include product) -Paper:</p>
                        </div>
                        <div class="col-6">
                            {{ product.unit_packaging_paper }} g
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-6">
                            <p for="v-model" style="font-size: 0.9rem!important;">Unit Packaging (1 pc) Net Weight <br>
                                (not include product) -Plastic:</p>
                        </div>
                        <div class="col-6">
                            {{ product.unit_packaging_plastic }} g
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-6">
                            <p for="v-model" style="font-size: 0.9rem!important;">Unit Packaging (1 pc) Net Weight <br>
                                (not include product) -Metal:</p>
                        </div>
                        <div class="col-6">
                            {{ product.unit_packaging_metal }} g
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-6">
                            <p for="v-model" style="font-size: 0.9rem!important;">Unit Packaging (1 pc) Net Weight <br>
                                (not include product) -Others:</p>
                        </div>
                        <div class="col-6">
                            {{ product.unit_packaging_others }} g
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-6">
                            <p for="v-model">Specify Packaging Material:</p>
                        </div>
                        <div class="col-6">
                            {{ product.packaging_material }}
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-6">
                            <p for="v-model" style="font-size: 0.9rem!important;">Total Packaging Net Weight:</p>
                        </div>
                        <div class="col-6">
                            {{ product.packaging_weight }} g
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-6">
                            <p for="v-model">Standard Packaging:</p>
                        </div>
                        <div class="col-6">
                            {{ product.standart_packaging }}
                        </div>
                    </div>

                    <h3 class="text-milung fw-bold text-uppercase mt-4">6. Manual, Label, Safety Sheet</h3>
                    <div class="d-flex my-2">
                        <div class="col-3 mt-3">Safety Sheet:</div>
                        <div class="col-5 mt-2" v-if="product">
                            <input type="text" :value="parsefileName(product.safety_sheet)" disabled
                                class="form-control w-full">
                        </div>
                        <div class="col-4" v-if="parsefileName(product.safety_sheet) !== null">
                            <a :href="parsefilePath(product.safety_sheet)"
                                :download="parsefileName(product.safety_sheet)"
                                class="btn-sm btn btn-light rotate-icon"><i
                                    class="bi bi-arrow-up-right-square fs-2 text-success"></i></a>
                        </div>
                    </div>
                    <div class="d-flex my-2">
                        <div class="col-3 mt-3">Manual:</div>
                        <div class="col-5 mt-2" v-if="product">
                            <input type="text" :value="parsefileName(product.manual)" disabled
                                class="form-control w-full">
                        </div>
                        <div class="col-4" v-if="parsefileName(product.manual) !== null">
                            <a :href="parsefilePath(product.manual)" :download="parsefileName(product.manual)"
                                class="btn-sm btn btn-light rotate-icon"><i
                                    class="bi bi-arrow-up-right-square fs-2 text-success"></i></a>
                        </div>
                    </div>
                    <div class="d-flex my-2">
                        <div class="col-3 mt-3">Product Label:</div>
                        <div class="col-5 mt-2" v-if="product">
                            <input type="text" :value="parsefileName(product.product_label)" disabled
                                class="form-control w-full">
                        </div>
                        <div class="col-4" v-if="parsefileName(product.product_label) !== null">
                            <a :href="parsefilePath(product.product_label)"
                                :download="parsefileName(product.product_label)"
                                class="btn-sm btn btn-light rotate-icon"><i
                                    class="bi bi-arrow-up-right-square fs-2 text-success"></i></a>
                        </div>
                    </div>
                    <div class="d-flex my-2">
                        <div class="col-3 mt-3">Packaging Label:</div>
                        <div class="col-5 mt-2" v-if="product">
                            <input type="text" :value="parsefileName(product.packaging_label)" disabled
                                class="form-control w-full">
                        </div>
                        <div class="col-4" v-if="parsefileName(product.packaging_label) !== null">
                            <a :href="parsefilePath(product.packaging_label)"
                                :download="parsefileName(product.packaging_label)"
                                class="btn-sm btn btn-light rotate-icon"><i
                                    class="bi bi-arrow-up-right-square fs-2 text-success"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="container d-flex p-4" style="background-color: #14245c;">
            <div class="text-uppercase text-white col-3 fw-bolder my-auto">8. Quote Expire Date:</div>
            <div class="col-6 d-flex ">
                <p class="my-auto text-white">{{ product.quoteExpiredDate }}</p>
            </div>
        </div>
    </section>
</template>

<script>
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

import NProgress from 'nprogress';
import 'nprogress/nprogress.css';




export default {
    components: {
        VueDatePicker,
    },
    data() {
        return {
            product: {},
        };
    },
    // mounted() {
    //     this.fetchProduct();
    // },
    created() {
        this.fetchProduct();
    },
    methods: {
        downloadAllImages() {
            const images = this.product.images;
            if (images && images.length > 0) {
                images.forEach(image => {
                    const link = document.createElement('a');
                    link.href = '/storage/' + image.path;
                    link.download = image.name;
                    link.click();
                });
            }
        },
        parsefileName(fileData) {
            if (typeof fileData !== 'string' || fileData[0] !== '{') {
                return '';
            }

            try {
                const file = JSON.parse(fileData);
                return file ? file.name : '';
            } catch (error) {
                console.error(error);
                return '';
            }
        },
        parsefilePath(fileData) {
            if (typeof fileData !== 'string' || fileData[0] !== '{') {
                return '';
            }

            try {
                const file = JSON.parse(fileData);
                return file ? '/storage/' + file.path : '';
            } catch (error) {
                console.error(error);
                return '';
            }

        },
        async fetchProduct() {
            NProgress.start();
            try {
                const productId = this.$route.params.id;
                const response = await axios.get(`/api/buyer/product/${productId}`);
                this.product = response.data;
                console.log(this.product);

                NProgress.done();
            } catch (error) {

                console.error(error);
                NProgress.done();
            }
        },




    },
};
</script>

<style scoped>
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
