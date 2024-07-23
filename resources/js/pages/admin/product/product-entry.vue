<template>
    <section class="section">
        <form @submit.prevent="submitForm" enctype="multipart/form-data">
            <div class="container">
                <div class="row">
                    <div class="col-6"></div>
                    <div class="col-md-6 gap-2">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-milung mx-2 px-2" type="submit">Save</button>
                            <button class="btn btn-warning px-4" type="reset">Clear</button>
                        </div>
                    </div>
                </div>
                <div class="row my-5">
                    <div class="col-md-6">
                        <h3 class="text-milung fw-bold text-uppercase">1. Product Information</h3>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Article Number: <span class="text-danger">*</span></p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="product.article" class="form-control" :class="{ 'is-invalid': validationErrors.article }">
                                <div v-if="validationErrors.article" class="invalid-feedback">
                                    {{ validationErrors.article[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Status: <span class="text-danger">*</span></p>
                            </div>
                            <div class="col-8">
                                <select v-model="product.status" class="form-select" :class="{ 'is-invalid': validationErrors.status }">
                                    <option value="active">Active</option>
                                    <option value="inactive">InActive</option>
                                </select>
                                <div v-if="validationErrors.status" class="invalid-feedback">
                                    {{ validationErrors.status[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Name: <span class="text-danger">*</span></p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="product.name" class="form-control" :class="{ 'is-invalid': validationErrors.name }">
                                <div v-if="validationErrors.name" class="invalid-feedback">
                                    {{ validationErrors.name[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Description:</p>
                            </div>
                            <div class="col-8">
                                <textarea v-model="product.description" class="form-control" cols="36" rows="10" :class="{ 'is-invalid': validationErrors.description }"></textarea>
                                <div v-if="validationErrors.description" class="invalid-feedback">
                                    {{ validationErrors.description[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Group: <span class="text-danger">*</span></p>
                            </div>
                            <div class="col-8">
                                <multiselect v-model="group" :options="productOptions" label="group_name" track-by="id" :class="{ 'is-invalid': validationErrors.group }"></multiselect>
                                <div v-if="validationErrors.group" class="invalid-feedback">
                                    {{ validationErrors.group[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Cargo Classification:</p>
                            </div>
                            <div class="col-8">
                                <div class="d-flex">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="general" v-model="product.cargo" :class="{ 'is-invalid': validationErrors.cargo }">
                                        <label class="form-check-label" for="flexRadioDefault1">General Cargo</label>
                                    </div>
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="radio" value="danger" v-model="product.cargo" :class="{ 'is-invalid': validationErrors.cargo }">
                                        <label class="form-check-label" for="flexRadioDefault1">Danger Goods</label>
                                    </div>
                                </div>
                                <div v-if="validationErrors.cargo" class="invalid-feedback">
                                    {{ validationErrors.cargo[0] }}
                                </div>
                                <div class="d-flex my-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" v-model="product.cargo_place" value="hongkong" :class="{ 'is-invalid': validationErrors.cargo_place }">
                                        <label class="form-check-label" for="flexCheckDefault1">Hong Kong</label>
                                    </div>
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="checkbox" v-model="product.cargo_place" value="china" :class="{ 'is-invalid': validationErrors.cargo_place }">
                                        <label class="form-check-label" for="flexCheckDefault2">Mainland China</label>
                                    </div>
                                </div>
                                <div v-if="validationErrors.cargo_place" class="invalid-feedback">
                                    {{ validationErrors.cargo_place[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11">
                            <div class="col-4 my-auto">
                                <label for="chips-input">Product Colors: <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-8">
                                <Chips v-model="product.color" :class="{ 'is-invalid': validationErrors.color }" />
                                <div v-if="validationErrors.color" class="invalid-feedback">
                                    {{ validationErrors.color[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Material: <span class="text-danger">*</span></p>
                            </div>
                            <div class="col-7">
                                <div class="input-group">
                                    <Chips v-model="product.material" :class="{ 'is-invalid': validationErrors.material }" />
                                    <div v-if="validationErrors.material" class="invalid-feedback">
                                        {{ validationErrors.material[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Size (L*W*H)/(L*Dia):</p>
                            </div>
                            <div class="col-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="product.size" :class="{ 'is-invalid': validationErrors.size }" />
                                    <span class="input-group-text">mm</span>
                                    <div v-if="validationErrors.size" class="invalid-feedback">
                                        {{ validationErrors.size[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">Product Net Weight (Product Only per pcs):</p>
                            </div>
                            <div class="col-5">
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="product.weight" :class="{ 'is-invalid': validationErrors.weight }" />
                                    <span class="input-group-text">g</span>
                                    <div v-if="validationErrors.weight" class="invalid-feedback">
                                        {{ validationErrors.weight[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Specifications:</p>
                            </div>
                            <div class="col-8">
                                <textarea v-model="product.specification" class="form-control" cols="36" rows="10" :class="{ 'is-invalid': validationErrors.specification }"></textarea>
                                <div v-if="validationErrors.specification" class="invalid-feedback">
                                    {{ validationErrors.specification[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">Product Memory Storage (if applicable):</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="product.memory" class="form-control" :class="{ 'is-invalid': validationErrors.memory }">
                                <div v-if="validationErrors.memory" class="invalid-feedback">
                                    {{ validationErrors.memory[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Features:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="product.feature" class="form-control" :class="{ 'is-invalid': validationErrors.feature }">
                                <div v-if="validationErrors.feature" class="invalid-feedback">
                                    {{ validationErrors.feature[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">Specify Accessories (i.e Cable, Manual, etc): <span class="text-danger">*</span></p>
                            </div>
                            <div class="col-8">
                                <Chips v-model="product.accessory" :class="{ 'is-invalid': validationErrors.accessory }" />
                                <div v-if="validationErrors.accessory" class="invalid-feedback">
                                    {{ validationErrors.accessory[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">Accessories Total Net Weight (Accessories Only per pc):</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="product.accessory_weight" :class="{ 'is-invalid': validationErrors.accessory_weight }" />
                                    <span class="input-group-text">g</span>
                                    <div v-if="validationErrors.accessory_weight" class="invalid-feedback">
                                        {{ validationErrors.accessory_weight[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">HS-DE Code:</p>
                            </div>
                            <div class="col-8">
                                <p>{{ group.hs_de }}</p>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">HS-CN Code:</p>
                            </div>
                            <div class="col-8">
                                <p>{{ group.hs_cn }}</p>
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase">7. Battery Details</h3>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Battery Type:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="product.battery_type" class="form-control" :class="{ 'is-invalid': validationErrors.battery_type }">
                                <div v-if="validationErrors.battery_type" class="invalid-feedback">
                                    {{ validationErrors.battery_type[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Battery Rated Capacity:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="text" v-model="product.rated" class="form-control" :class="{ 'is-invalid': validationErrors.rated }">
                                    <input type="text" v-model="product.capacity" class="form-control" :class="{ 'is-invalid': validationErrors.capacity }">
                                    <span class="input-group-text px-3">mAh/Wh</span>
                                    <div v-if="validationErrors.rated" class="invalid-feedback">
                                        {{ validationErrors.rated[0] }}
                                    </div>
                                    <div v-if="validationErrors.capacity" class="invalid-feedback">
                                        {{ validationErrors.capacity[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Battery Nominal Voltage:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="product.voltage" class="form-control" :class="{ 'is-invalid': validationErrors.voltage }">
                                <div v-if="validationErrors.voltage" class="invalid-feedback">
                                    {{ validationErrors.voltage[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">No. of Battery Contained:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="number" v-model="product.pcs" class="form-control" :class="{ 'is-invalid': validationErrors.pcs }">
                                    <span class="input-group-text px-3">pcs</span>
                                    <div v-if="validationErrors.pcs" class="invalid-feedback">
                                        {{ validationErrors.pcs[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Battery Capacity:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="number" v-model="product.mAh" class="form-control" :class="{ 'is-invalid': validationErrors.mAh }">
                                    <span class="input-group-text px-3">mAh</span>
                                    <div v-if="validationErrors.mAh" class="invalid-feedback">
                                        {{ validationErrors.mAh[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Battery Size (LxWxH):</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="number" v-model="product.mm" class="form-control" :class="{ 'is-invalid': validationErrors.mm }">
                                    <span class="input-group-text px-3">mm</span>
                                    <div v-if="validationErrors.mm" class="invalid-feedback">
                                        {{ validationErrors.mm[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Battery Net Weight (per pc):</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="number" v-model="product.gram" class="form-control" :class="{ 'is-invalid': validationErrors.gram }">
                                    <span class="input-group-text px-3">g</span>
                                    <div v-if="validationErrors.gram" class="invalid-feedback">
                                        {{ validationErrors.gram[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">MSDS IATA Edition No.:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="product.edition" class="form-control" :class="{ 'is-invalid': validationErrors.edition }">
                                <div v-if="validationErrors.edition" class="invalid-feedback">
                                    {{ validationErrors.edition[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">MSDS Expiry Date:</p>
                            </div>
                            <div class="col-8">
                                <input type="date" v-model="product.msds_expiry" class="form-control" :class="{ 'is-invalid': validationErrors.msds_expiry }">
                                <div v-if="validationErrors.msds_expiry" class="invalid-feedback">
                                    {{ validationErrors.msds_expiry[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">UN38.3 Expiry Date:</p>
                            </div>
                            <div class="col-8">
                                <input type="date" v-model="product.un_expiry" class="form-control" :class="{ 'is-invalid': validationErrors.un_expiry }">
                                <div v-if="validationErrors.un_expiry" class="invalid-feedback">
                                    {{ validationErrors.un_expiry[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">CN Air Safety Report Expiry Date:</p>
                            </div>
                            <div class="col-8">
                                <input type="date" v-model="product.air_safety_expiry" class="form-control" :class="{ 'is-invalid': validationErrors.air_safety_expiry }">
                                <div v-if="validationErrors.air_safety_expiry" class="invalid-feedback">
                                    {{ validationErrors.air_safety_expiry[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">CN Sea Safety Report Expiry Date:</p>
                            </div>
                            <div class="col-8">
                                <input type="date" v-model="product.sea_safety_expiry" class="form-control" :class="{ 'is-invalid': validationErrors.sea_safety_expiry }">
                                <div v-if="validationErrors.sea_safety_expiry" class="invalid-feedback">
                                    {{ validationErrors.sea_safety_expiry[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" style="font-size: 0.9rem!important;">CN Train Safety Report Expiry Date:</p>
                            </div>
                            <div class="col-8">
                                <input type="date" v-model="product.train_safety_expiry" class="form-control" :class="{ 'is-invalid': validationErrors.train_safety_expiry }">
                                <div v-if="validationErrors.train_safety_expiry" class="invalid-feedback">
                                    {{ validationErrors.train_safety_expiry[0] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-milung fw-bold text-uppercase">2. Product Photo</h3>
                        <div class="d-flex col-11 my-2">
                            <ImageSelector @imagesSelected="handleImagesSelected" :class="{ 'is-invalid': validationErrors.images }" />
                            <div v-if="validationErrors.images" class="invalid-feedback">
                                {{ validationErrors.images[0] }}
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase">3. Certificates & Test Reports</h3>
                        <certificates-input @update-certificates="updateCertificates" :class="{ 'is-invalid': validationErrors.certificates }"></certificates-input>
                        <div v-if="validationErrors.certificates" class="invalid-feedback">
                            {{ validationErrors.certificates[0] }}
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase">4. Printing Details</h3>
                        <div class="col-11 my-2">
                            <div v-for="(printArea, index) in product.print_areas" :key="index" class="row mb-3">
                                <div class="col-4">
                                    <label :for="'position-' + index" style="font-size: 0.9rem!important;">Print Area Position:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" v-model="printArea.position" :id="'position-' + index" class="form-control" :class="{ 'is-invalid': validationErrors.print_areas?.[index]?.position }">
                                    <div v-if="validationErrors.print_areas?.[index]?.position" class="invalid-feedback">
                                        {{ validationErrors.print_areas[index].position[0] }}
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label :for="'size-' + index" style="font-size: 0.9rem!important;">Max. Print Area Size (mm):</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" v-model="printArea.size" :id="'size-' + index" class="form-control" :class="{ 'is-invalid': validationErrors.print_areas?.[index]?.size }">
                                    <div v-if="validationErrors.print_areas?.[index]?.size" class="invalid-feedback">
                                        {{ validationErrors.print_areas[index].size[0] }}
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label :for="'method-' + index" style="font-size: 0.9rem!important;">Standard Printing Method:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" v-model="printArea.method" :id="'method-' + index" class="form-control" :class="{ 'is-invalid': validationErrors.print_areas?.[index]?.method }">
                                    <div v-if="validationErrors.print_areas?.[index]?.method" class="invalid-feedback">
                                        {{ validationErrors.print_areas[index].method[0] }}
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <button @click="removePrintArea(index)" class="btn btn-danger btn-sm">Remove</button>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" @click="addPrintArea" class="btn btn-primary">Add Print Area</button>
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase">5. Packing Details</h3>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="v-model" style="font-size: 0.9rem!important;">Unit Packaging (1 pc) Net Weight (not include product) - Paper:</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" v-model="product.unit_packaging_paper" class="form-control" :class="{ 'is-invalid': validationErrors.unit_packaging_paper }">
                                    <span class="input-group-text px-3">g</span>
                                    <div v-if="validationErrors.unit_packaging_paper" class="invalid-feedback">
                                        {{ validationErrors.unit_packaging_paper[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="v-model" style="font-size: 0.9rem!important;">Unit Packaging (1 pc) Net Weight (not include product) - Plastic:</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" v-model="product.unit_packaging_plastic" class="form-control" :class="{ 'is-invalid': validationErrors.unit_packaging_plastic }">
                                    <span class="input-group-text px-3">g</span>
                                    <div v-if="validationErrors.unit_packaging_plastic" class="invalid-feedback">
                                        {{ validationErrors.unit_packaging_plastic[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="v-model" style="font-size: 0.9rem!important;">Unit Packaging (1 pc) Net Weight (not include product) - Metal:</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" v-model="product.unit_packaging_metal" class="form-control" :class="{ 'is-invalid': validationErrors.unit_packaging_metal }">
                                    <span class="input-group-text px-3">g</span>
                                    <div v-if="validationErrors.unit_packaging_metal" class="invalid-feedback">
                                        {{ validationErrors.unit_packaging_metal[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="v-model" style="font-size: 0.9rem!important;">Unit Packaging (1 pc) Net Weight (not include product) - Others:</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" v-model="product.unit_packaging_others" class="form-control" :class="{ 'is-invalid': validationErrors.unit_packaging_others }">
                                    <span class="input-group-text px-3">g</span>
                                    <div v-if="validationErrors.unit_packaging_others" class="invalid-feedback">
                                        {{ validationErrors.unit_packaging_others[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="v-model">Specify Packaging Material:</p>
                            </div>
                            <div class="col-6">
                                <input type="text" v-model="product.packaging_material" class="form-control" :class="{ 'is-invalid': validationErrors.packaging_material }">
                                <div v-if="validationErrors.packaging_material" class="invalid-feedback">
                                    {{ validationErrors.packaging_material[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="v-model" style="font-size: 0.9rem!important;">Total Packaging Net Weight:</p>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="number" v-model="product.packaging_weight" class="form-control" :class="{ 'is-invalid': validationErrors.packaging_weight }">
                                    <span class="input-group-text px-3">g</span>
                                    <div v-if="validationErrors.packaging_weight" class="invalid-feedback">
                                        {{ validationErrors.packaging_weight[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <p for="v-model">Standard Packaging: <span class="text-danger">*</span></p>
                            </div>
                            <div class="col-6">
                                <input type="text" v-model="product.standart_packaging" class="form-control" :class="{ 'is-invalid': validationErrors.standart_packaging }">
                                <div v-if="validationErrors.standart_packaging" class="invalid-feedback">
                                    {{ validationErrors.standart_packaging[0] }}
                                </div>
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase mt-4">6. Manual, Label, Safety Sheet</h3>
                        <fileinput label="Safety Sheet:" inputName="safety_sheet" @file-uploaded="handleFileUploaded" :class="{ 'is-invalid': validationErrors.safety_sheet }"></fileinput>
                        <div v-if="validationErrors.safety_sheet" class="invalid-feedback">
                            {{ validationErrors.safety_sheet[0] }}
                        </div>
                        <fileinput label="Manual:" inputName="manual" @file-uploaded="handleFileUploaded" :class="{ 'is-invalid': validationErrors.manual }"></fileinput>
                        <div v-if="validationErrors.manual" class="invalid-feedback">
                            {{ validationErrors.manual[0] }}
                        </div>
                        <fileinput label="Product Label:" inputName="product_label" @file-uploaded="handleFileUploaded" :class="{ 'is-invalid': validationErrors.product_label }"></fileinput>
                        <div v-if="validationErrors.product_label" class="invalid-feedback">
                            {{ validationErrors.product_label[0] }}
                        </div>
                        <fileinput label="Packaging Label:" inputName="packaging_label" @file-uploaded="handleFileUploaded" :class="{ 'is-invalid': validationErrors.packaging_label }"></fileinput>
                        <div v-if="validationErrors.packaging_label" class="invalid-feedback">
                            {{ validationErrors.packaging_label[0] }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="container d-flex p-4" style="background-color: #14245c;">
                <div class="text-uppercase text-white col-4 fw-bolder my-auto">8. Quote Expire Date:</div>
                <div class="col-6 d-flex">
                    <VueDatePicker calendar-cell-class-name="dp-custom-cell" class="dp__new" v-model="Dates" mode='single' format="dd-MM-yyyy" @input="sendDateOnly" :class="{ 'is-invalid': validationErrors.quoteExpiredDate }"></VueDatePicker>
                    <div v-if="validationErrors.quoteExpiredDate" class="invalid-feedback">
                        {{ validationErrors.quoteExpiredDate[0] }}
                    </div>
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
import certificatesInput from './CertificatesInput.vue';




export default {
    emits: ['profileUpdated'],
    components: {
        ImageSelector,
        fileinput,
        VueDatePicker,
        certificatesInput,
    },
    data() {
        return {
            loader: false,
            group: '',
            Dates: '',
            certificates: [],
            productOptions: [],
            selectedImages: [],
            selectedFiles: [],
            uploadedFiles: {},
            validationErrors: {},
            product: {
                cargo_place: [],
                color: [],
                material: [],
                accessory: [],
                safety_sheet: null,
                manual: null,
                product_label: null,
                packaging_label: null,
                print_areas: [
                    { position: '', size: '', method: '' }
                ]
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
        updateCertificates(certificates) {
            this.certificates = certificates;
        },
        addPrintArea() {
            this.product.print_areas.push({ position: '', size: '', method: '' });
        },
        removePrintArea(index) {
            this.product.print_areas.splice(index, 1);
        },
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
                if (key === 'print_areas') {
                    formData.append(key, JSON.stringify(this.product[key]));
                } else {
                    formData.append(key, this.product[key]);
                }
            });
            for (const image of this.selectedImages) {
                formData.append('images[]', image);
            }

            console.log(formData);
            // Append file inputs to the FormData object
            Object.entries(this.uploadedFiles).forEach(([inputName, fileName]) => {
                formData.append(inputName, this.uploadedFiles[inputName]);
            });

            this.certificates.forEach((certificate, index) => {
                formData.append(`certificates[${index}][label]`, certificate.label);
                formData.append(`certificates[${index}][file]`, certificate.file);
            });

            try {
                console.log(this.certificates);
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
                    this.validationErrors = validationErrors;
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
