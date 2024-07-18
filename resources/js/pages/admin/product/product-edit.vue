<template>
    <section class="section">
        <form @submit.prevent="submitForm" enctype="multipart/form-data">

            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <div class="input-group mb-3 col-8">
                            <label class="input-group-text" for="inputGroupFile01"
                                style=" background-color: #00a6e6; color: white;">Import</label>
                            <div class="filename-display">{{ filename }}</div>
                            <select v-model="selectedSupplier" class="form-select">
                                <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">
                                    {{ supplier.supplier_id }}
                                </option>
                            </select>
                            <button class="btn btn-milung" type="button" @click="triggerFileInput">Browse</button>
                            <input type="file" ref="filenameInput" class="file-input" @change="updateFilename">
                        </div>
                        <!-- <div class="import-container col-8">
                            <button class="btn import-button" type="button" @click="triggerFileInput">Import</button>
                            <div class="filename-display">{{ filename }}</div>
                            <div class="col-4">

                                <select v-model="selectedSupplier" class="form-select">
                                    <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">
                                        {{ supplier.name }}
                                    </option>
                                </select>
                            </div>
                            <button class="btn browse-button" type="button" @click="triggerFileInput">Browse</button>
                        </div> -->
                    </div>
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
                                <p for="v-model">Product Battery Capacity:</p>
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
                                <p for="v-model">Battery Size (LxWxH):</p>
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
                                <p for="v-model">Battery Net Weight (per pc):</p>
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
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p>Uploaded Images:</p>
                            </div>
                            <div class="col-8">
                                <div v-if="product.images?.length">
                                    <div class="image-gallery">
                                        <div v-for="(image, index) in product.images" :key="index"
                                            class="uploaded-image">
                                            <img :src="`/storage/${image.path}`" alt="Product Image"
                                                class="img-thumbnail" />
                                            <button @click="removeImage(image)" type="button"
                                                class="btn btn-danger btn-sm">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="no-images">
                                    <p>No images uploaded.</p>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase">3. Certificates & Test Reports</h3>
                        <!-- <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">Validate Certificate & Testing
                                    Report:
                                    (CE,ROHS,RED,REACH,LFGB,FSC,etc.)</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="product.certificate" class="form-control">
                            </div>
                        </div> -->
                        <certificates-input :key="componentKey" :initialCertificates="product.certificates" :isEditing="true"
                            @update-certificates="updateCertificates"></certificates-input>
                        <h3 class="text-milung fw-bold text-uppercase">4. Printing Details</h3>
                        <div class=" col-11 my-2">
                            <div v-for="(printArea, index) in product.print_areas" :key="index" class="row mb-3">
                                <div class="col-4">
                                    <label :for="'position-' + index" style="font-size: 0.9rem!important;">Print Area
                                        Position:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" v-model="printArea.position" :id="'position-' + index"
                                        class="form-control">
                                </div>
                                <div class="col-4">
                                    <label :for="'size-' + index" style="font-size: 0.9rem!important;">Max. Print Area
                                        Size (mm):</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" v-model="printArea.size" :id="'size-' + index"
                                        class="form-control">
                                </div>
                                <div class="col-4">
                                    <label :for="'method-' + index" style="font-size: 0.9rem!important;">Standard
                                        Printing
                                        Method:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" v-model="printArea.method" :id="'method-' + index"
                                        class="form-control">
                                </div>
                                <div class="col-12 text-end">
                                    <button @click="removePrintArea(index)"
                                        class="btn btn-danger btn-sm">Remove</button>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" @click="addPrintArea" class="btn btn-primary">Add Print
                                    Area</button>
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

                        <fileinput :key="componentKey" label="Safety Sheet:" inputName="safety_sheet"
                            :initialFile="parseFile(product.safety_sheet)" @file-uploaded="handleFileUploaded">
                        </fileinput>
                        <fileinput :key="componentKey" label="Manual:" inputName="manual"
                            :initialFile="parseFile(product.manual)" @file-uploaded="handleFileUploaded"></fileinput>
                        <fileinput :key="componentKey" label="Product Label:" inputName="product_label"
                            :initialFile="parseFile(product.product_label)" @file-uploaded="handleFileUploaded">
                        </fileinput>
                        <fileinput :key="componentKey" label="Packaging Label:" inputName="packaging_label"
                            :initialFile="parseFile(product.packaging_label)" @file-uploaded="handleFileUploaded">
                        </fileinput>

                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header pt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col-6">
                                        <span class="mt-2 fw-bold fs-4" style="color: #14245c;">7. Supplier
                                            Quote:</span>
                                    </div>
                                    <div class="col-4">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body rounded-top">
                                <table class="table table-striped display text-center">
                                    <thead style="color: #009de1;">
                                        <tr class="rounded-top-new">
                                            <th>Supplier ID</th>
                                            <th>FTY Item No.</th>
                                            <th>MOQ</th>
                                            <th>Buying Unit Price</th>
                                            <th>Selling Unit Price</th>
                                            <th>Quote Sheet</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(quote, index) in product.quotes" :key="index"
                                            v-if="product.quotes?.length > 0">
                                            <td>
                                                <!-- <router-link :to="{ name: 'order_edit', params: { id: order.id } }"
                                                    class="text- underline">
                                                </router-link> -->
                                                {{ quote.supplier?.supplier_id }}
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td> USD</td>
                                            <td> USD</td>
                                            <td>
                                                <a :href="'/storage/' + quote.path" :download="quote.filename"
                                                    class="btn px-4 mx-2 btn-outline-primary  ">
                                                    {{ quote.filename }}
                                                </a>
                                            </td>
                                        </tr>
                                        <tr v-else>
                                            <td colspan="8" class="text-center">
                                                No quotes available
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="col-6">
                                <span class="mt-2 fw-bold fs-4" style="color: #14245c;">Order History:</span>
                            </div>
                            <div class="col-4">
                            </div>
                        </div>
                    </div>
                    <div class="card-body rounded-top">
                        <table class="table table-striped display text-center">
                            <thead style="color: #009de1;">
                                <tr class="rounded-top-new">
                                    <th>Order Number</th>
                                    <th>Supplier ID</th>
                                    <th>Quantity</th>
                                    <th>Order Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(order, index) in product.orders" :key="index"
                                    v-if="product.orders?.length > 0">
                                    <td>
                                        <router-link :to="{ name: 'order_edit', params: { id: order.id } }"
                                            class="text- underline">
                                            {{ order.id }}
                                        </router-link>
                                    </td>
                                    <td>{{ order.supplierid.supplier_id }}</td>
                                    <td>{{ order.quantity_unit }}</td>
                                    <td>{{ order.totalvalue }} USD</td>
                                </tr>
                                <tr v-else>
                                    <td colspan="8" class="text-center">
                                        No orders available
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <EventLogTable :filterValue="'Product'" />
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
import axios from 'axios';
import Swal from 'sweetalert2';
import certificatesInput from './CertificatesInput.vue';


export default {
    emits: ['profileUpdated'],
    components: {
        ImageSelector,
        fileinput,
        VueDatePicker,
        certificatesInput
    },
    data() {
        return {
            suppliers: [],
            selectedSupplier: null,
            filename: 'No file chosen',
            loader: false,
            componentKey: 0,
            group: {
                hs_de: '',
                hs_cn: '',
            },
            Dates: '',
            productOptions: [],
            orders: [],
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
                print_areas: [],
                certificates: []
            },
        };
    },
    mounted() {
        this.fetchProductDetails();
        this.fetchSuppliers();
    },
    watch: {
        Dates: function (newDate, oldDate) {
            this.sendDateOnly();
        },
    },
    methods: {
        updateCertificates(certificates) {
            this.product.certificates = certificates;
        },
        async fetchSuppliers() {
            try {
                const response = await axios.get('/api/Suppliers'); // Adjust the endpoint as needed
                this.suppliers = response.data;
            } catch (error) {
                console.error('Error fetching suppliers:', error);
            }
        },
        triggerFileInput() {
            this.$refs.filenameInput.click();
        },
        updateFilename(event) {
            const file = event.target.files[0];
            this.filename = file ? file.name : 'No file chosen';
        },
        addPrintArea() {
            this.product.print_areas.push({ position: '', size: '', method: '' });
        },
        removePrintArea(index) {
            this.product.print_areas.splice(index, 1);
        },
        parseFile(fileString) {
            try {
                const file = JSON.parse(fileString);

                return file && file.name ? file : {
                    path: null,
                    name: null
                };
            } catch (error) {
                return {
                    path: null,
                    name: null
                };
            }
        },
        async fetchProductOptions() {
            try {
                const response = await axios.get('/api/product_group_get');
                this.productOptions = response.data;
                this.group = this.productOptions.find(option => option.id == this.product.group);
                console.log(this.productOptions, this.group, this.product.group);
            } catch (error) {
                console.error(error);
            }
        },
        async fetchProductDetails() {
            const productId = this.$route.params.id;
            try {
                const response = await axios.get(`/api/product/${productId}`);
                this.product = response.data;
                this.group = this.product.group;
                console.log(response.data);
                this.product.color = response.data.color.split(',').map(item => item.trim());
                this.product.material = response.data.material.split(',').map(item => item.trim());
                this.product.accessory = response.data.accessory.split(',').map(item => item.trim());
                this.product.cargo_place = response.data.cargo_place.split(',').map(item => item.trim());
                // this.group = this.productOptions.find(option => option.id === this.product.group);
                // console.log(this.group, this.product.group, this.productOptions);

                this.Dates = new Date(this.product.quoteExpiredDate);
                this.componentKey += 1;
                this.fetchProductOptions();

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

            console.log('Form submitted with images:', this.quoteExpiredDate);

            const fileInput = this.$refs.filenameInput;
            const file = fileInput.files[0];
            // Create a new FormData object
            const formData = new FormData();

            if (file) {
                formData.append('quotefile', file);
                formData.append('supplier_id', this.selectedSupplier);
            }
            console.log(this.group.id);
            formData.append('group', this.group.id);
            // Append form fields to FormData dynamically
            Object.keys(this.product).forEach((key) => {
                if (key === 'print_areas') {
                    formData.append(key, JSON.stringify(this.product[key]));
                } else {
                    formData.append(key, this.product[key]);
                }
            });
            for (const image of this.selectedImages) {
                formData.append('newimages[]', image);
            }

            // Append file inputs to the FormData object
            Object.entries(this.uploadedFiles).forEach(([inputName, fileName]) => {
                formData.append(inputName, this.uploadedFiles[inputName]);
            });

            this.product.certificates.forEach((certificate, index) => {
                console.log(certificate);
                formData.append(`certificates[${index}][label]`, certificate.label);
                if (certificate.file) {
                    formData.append(`certificates[${index}][file]`, certificate.file);
                } else {
                    formData.append(`certificates[${index}][file_path]`, certificate.file_path);
                    formData.append(`certificates[${index}][file_name]`, certificate.file_name);
                }
            });

            try {
                const productId = this.$route.params.id;
                const updateProduct = await axios.post(`/api/updprod/${productId}`, formData);
                this.loader = false;
                if (updateProduct.status === 200) {
                    toastr.success(updateProduct.data.message);
                    // this.fetchProductDetails();
                    this.$router.push({
                        name: 'product'
                    });
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
                    toastr.error('An error occurred while updating the product');
                }
            }
        },
        handleValidationErrors(validationErrors) {
            console.log(validationErrors);
            for (const key in validationErrors) {
                if (Object.hasOwnProperty.call(validationErrors, key)) {
                    const messages = validationErrors[key];
                    messages.forEach((message) => {
                        toastr.error(message);
                    });
                }
            }
        },
        resetForm() {
            this.fetchProductDetails();
        },
        resetDate() {
            this.Dates = '';
        },
        async removeImage(image) {
            Swal.fire({
                title: 'Delete Image?',
                text: `Are you sure you want to delete this image?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const updateProduct = await axios.post(`/api/updprod/deleteimage/${image.id}`);
                        this.loader = false;
                        if (updateProduct.status === 200) {
                            toastr.success(updateProduct.data.success);
                            this.product.images = this.product.images.filter(img => img !== image);
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
                            toastr.error('An error occurred while updating the product');
                        }
                    }
                }
            });
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

.image-gallery {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.uploaded-image {
    margin: 10px;
    display: inline-block;
}

.no-images {
    text-align: center;
    padding: 20px;
    color: #999;
}

.import-container {
    display: flex;
    align-items: center;
    border-radius: 5px;
    overflow: hidden;
}

.import-button {
    background-color: #00a6e6;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px 0 0 5px;
    cursor: pointer;
}

.filename-display {
    background-color: #f0f8fc;
    padding: 10px 20px;
    border: 1px solid #d1e7f0;
    font-family: sans-serif;
    flex-grow: 1;
    text-align: center;
}

.browse-button {
    background-color: #1d3c77;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 0 5px 5px 0;
    cursor: pointer;
}

.file-input {
    display: none;
}
</style>
