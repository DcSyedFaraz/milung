<template>
    <section class="section">
        <form @submit.prevent="submitForm" enctype="multipart/form-data">
            <div class="container">
                <div class="row">
                    <div class="col-6">

                        <InputGroup class=" mb-3 col-8">
                            <InputGroupAddon style=" background-color: #00a6e6; color: white;">
                                <label class="-text" for="inputGroupFile01">Import</label>
                            </InputGroupAddon>
                            <InputText placeholder="Keyword" :value="filename" disabled />
                            <Select v-model="selectedSupplier" :options="suppliers" optionLabel="supplier_id"
                                optionValue="id">
                            </Select>
                            <Button class="p-button " type="button" @click="triggerFileInput" label="Browse"></Button>
                        </InputGroup>
                        <input type="file" ref="filenameInput" class="file-input" @change="updateFilename">
                    </div>
                    <div class="col-md-6 gap-2">
                        <div class="d-flex justify-content-end">
                            <Button class="p-button mx-2" type="submit" severity="success" label="Save"></Button>
                            <Button class="p-button-warning" type="reset" severity="info" label="Clear"></Button>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <h3 class="text-milung fw-bold text-uppercase">1. Product Information</h3>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="my-2">Article Number: <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-8">
                                <InputText class="w-100 " v-model="product.article"
                                    :class="{ 'p-invalid': validationErrors.article }" />
                                <Message class="my-2" v-if="validationErrors.article" severity="error">{{
                                    validationErrors.article[0]
                                    }}</Message>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="my-2">Status: <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-8">
                                <Select v-model="product.status" optionLabel="label" optionValue="value"
                                    placeholder="Select status" class="w-100" :options="statusOptions"
                                    :class="{ 'p-invalid': validationErrors.status }" />
                                <Message class="my-2" v-if="validationErrors.status" severity="error">{{
                                    validationErrors.status[0]
                                    }}</Message>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="my-2">Product Name: <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-8">
                                <InputText class="w-100 " v-model="product.name"
                                    :class="{ 'p-invalid': validationErrors.name }" />
                                <Message class="my-2" v-if="validationErrors.name" severity="error">{{
                                    validationErrors.name[0] }}
                                </Message>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="my-2">Product Description:</label>
                            </div>
                            <div class="col-8">
                                <Textarea v-model="product.description"
                                    :class="{ 'p-invalid': validationErrors.description }" rows="4" cols="36" />
                                <Message class="my-2" v-if="validationErrors.description" severity="error">{{
                                    validationErrors.description[0] }}</Message>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="my-2">Product Group: <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-8">
                                <Select class="w-100" v-model="group" :options="productOptions"
                                    placeholder="Select Product Group" optionLabel="group_name"
                                    :class="{ 'p-invalid': validationErrors.group }" />
                                <Message class="my-2" v-if="validationErrors.group" severity="error">{{
                                    validationErrors.group[0] }}
                                </Message>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="my-2">Cargo Classification:</label>
                            </div>
                            <div class="col-8">
                                <div class="d-flex">
                                    <div class="form-check">
                                        <RadioButton v-model="product.cargo" inputId="general" value="general"
                                            :class="{ 'p-invalid': validationErrors.cargo }" />
                                        <label class="ms-2" for="general">General Cargo</label>
                                    </div>
                                    <div class="form-check mx-2">
                                        <RadioButton v-model="product.cargo" inputId="danger" value="danger"
                                            :class="{ 'p-invalid': validationErrors.cargo }" />
                                        <label class="ms-2" for="danger">Danger Goods</label>
                                    </div>
                                </div>
                                <Message class="my-2" v-if="validationErrors.cargo" severity="error">{{
                                    validationErrors.cargo[0] }}
                                </Message>
                                <div class="d-flex my-2">
                                    <div class="form-check">
                                        <Checkbox v-model="product.cargo_place" inputId="hongkong" value="hongkong"
                                            :class="{ 'p-invalid': validationErrors.cargo_place }" />
                                        <label class="ms-2" for="hongkong">Hong Kong</label>
                                    </div>
                                    <div class="form-check mx-2">
                                        <Checkbox v-model="product.cargo_place" inputId="china" value="china"
                                            :class="{ 'p-invalid': validationErrors.cargo_place }" />
                                        <label class="ms-2" for="china">Mainland China</label>
                                    </div>
                                </div>
                                <Message class="my-2" v-if="validationErrors.cargo_place" severity="error">{{
                                    validationErrors.cargo_place[0] }}</Message>
                            </div>
                        </div>
                        <div class="d-flex col-11">
                            <div class="col-4 my-auto">
                                <label class="my-2" for="chips-input">Product Colors: <span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-8">
                                <Chips class="w-100" v-model="product.color"
                                    :class="{ 'p-invalid': validationErrors.color }" />
                                <Message class="my-2" v-if="validationErrors.color" severity="error">{{
                                    validationErrors.color[0] }}
                                </Message>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="my-2">Product Material: <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-8">
                                <InputGroup>
                                    <Chips class="w-100" v-model="product.material"
                                        :class="{ 'p-invalid': validationErrors.material }" />
                                </InputGroup>
                                <Message class="my-2" v-if="validationErrors.material" severity="error">{{
                                    validationErrors.material[0] }}</Message>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="my-2">Product Size (L*W*H)/(L*Dia):</label>
                            </div>
                            <div class="col-8">
                                <InputGroup lass="w-100 ">
                                    <InputText class="w-100 " v-model="product.size"
                                        :class="{ 'p-invalid': validationErrors.size }" />
                                    <InputGroupAddon addonType="append">mm</InputGroupAddon>
                                </InputGroup>

                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="my-2">Product Net Weight (Product Only per pcs):</label>
                            </div>
                            <div class="col-8">
                                <InputGroup>
                                    <InputText class="w-100 " v-model="product.weight"
                                        :class="{ 'p-invalid': validationErrors.weight }" />
                                    <InputGroupAddon addonType="append">g</InputGroupAddon>
                                    <Message class="my-2" v-if="validationErrors.weight" severity="error">{{
                                        validationErrors.weight[0] }}</Message>
                                </InputGroup>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="my-2">Product Specifications:</label>
                            </div>
                            <div class="col-8">
                                <Textarea v-model="product.specification"
                                    :class="{ 'p-invalid': validationErrors.specification }" rows="4" cols="37" />
                                <Message class="my-2" v-if="validationErrors.specification" severity="error">{{
                                    validationErrors.specification[0] }}
                                </Message>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="my-2">Product Memory Storage (if applicable):</label>
                            </div>
                            <div class="col-8">
                                <InputText class="w-100 " v-model="product.memory"
                                    :class="{ 'p-invalid': validationErrors.memory }" />
                                <Message class="my-2" v-if="validationErrors.memory" severity="error">{{
                                    validationErrors.memory[0]
                                    }}</Message>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="my-2">Product Features:</label>
                            </div>
                            <div class="col-8">
                                <InputText class="w-100 " v-model="product.feature"
                                    :class="{ 'p-invalid': validationErrors.feature }" />
                                <Message class="my-2" v-if="validationErrors.feature" severity="error">{{
                                    validationErrors.feature[0]
                                    }}</Message>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="my-2">Specify Accessories (i.e Cable, Manual, etc): <span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-8">
                                <Chips class="w-100" v-model="product.accessory"
                                    :class="{ 'p-invalid': validationErrors.accessory }" />
                                <Message class="my-2" v-if="validationErrors.accessory" severity="error">{{
                                    validationErrors.accessory[0] }}
                                </Message>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="my-2">Accessories Total Net Weight (Accessories Only per pc):</label>
                            </div>
                            <div class="col-8">
                                <InputGroup>
                                    <InputText class="w-100 " v-model="product.accessory_weight"
                                        :class="{ 'p-invalid': validationErrors.accessory_weight }" />
                                    <InputGroupAddon>g</InputGroupAddon>
                                    <Message class="my-2" v-if="validationErrors.accessory_weight" severity="error">{{
                                        validationErrors.accessory_weight[0] }}</Message>
                                </InputGroup>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="my-2">HS-DE Code:</label>
                            </div>
                            <div class="col-8">
                                <p>{{ group.hs_de }}</p>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="my-2">HS-CN Code:</label>
                            </div>
                            <div class="col-8">
                                <p>{{ group.hs_cn }}</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <h3 class="text-milung fw-bold text-uppercase">2. Product Photo</h3>
                        <div class="d-flex col-11 my-2">
                            <ImageSelector @imagesSelected="handleImagesSelected"
                                :class="{ 'p-invalid': validationErrors.images }" />
                            <Message class="my-2" v-if="validationErrors.images" severity="error">{{
                                validationErrors.images[0] }}
                            </Message>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase">3. Certificates & Test Reports</h3>
                        <CertificatesInput @update-certificates="updateCertificates"
                            :class="{ 'p-invalid': validationErrors.certificates }" />
                        <Message class="my-2" v-if="validationErrors.certificates" severity="error">{{
                            validationErrors.certificates[0] }}
                        </Message>
                        <h3 class="text-milung fw-bold text-uppercase">4. Printing Details</h3>
                        <div class="col-11 my-2">
                            <div v-for="(printArea, index) in product.print_areas" :key="index" class="row mb-3">
                                <div class="col-4">
                                    <label class="my-2" :for="'position-' + index">Print Area Position:</label>
                                </div>
                                <div class="col-8">
                                    <InputText class="w-100 " v-model="printArea.position" :id="'position-' + index"
                                        :class="{ 'p-invalid': validationErrors.print_areas?.[index]?.position }" />
                                    <Message class="my-2" v-if="validationErrors.print_areas?.[index]?.position"
                                        severity="error" text="it{{ validationErrors.print_areas[index].posion[0] }}">
                                    </Message>
                                </div>
                                <div class="col-4">
                                    <label class="my-2" :for="'size-' + index">Max. Print Area Size (mm):</label>
                                </div>
                                <div class="col-8">
                                    <InputText class="w-100 my-2" v-model="printArea.size" :id="'size-' + index"
                                        :class="{ 'p-invalid': validationErrors.print_areas?.[index]?.size }" />
                                    <Message class="my-2" v-if="validationErrors.print_areas?.[index]?.size"
                                        severity="error" text="e[{{ validationErrors.print_areas[index].siz0] }}">
                                    </Message>
                                </div>
                                <div class="col-4">
                                    <label class="my-2" :for="'method-' + index">Standard Printing Method:</label>
                                </div>
                                <div class="col-8">
                                    <InputText class="w-100 " v-model="printArea.method" :id="'method-' + index"
                                        :class="{ 'p-invalid': validationErrors.print_areas?.[index]?.method }" />
                                    <Message class="my-2" v-if="validationErrors.print_areas?.[index]?.method"
                                        severity="error" text="ho{{ validationErrors.print_areas[index].metd[0] }}">
                                    </Message>
                                </div>
                                <div class="col-12 text-end">
                                    <Button @click="removePrintArea(index)" class="p-button-danger p-button-sm"
                                        label="Remove"></Button>
                                </div>
                            </div>
                            <div class="text-end">
                                <Button type="button" @click="addPrintArea" class="p-button"
                                    label="Add Print Area"></Button>
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase">5. Packing Details</h3>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <label class="my-2">Unit Packaging (1 pc) Net Weight (not include product) -
                                    Paper:</label>
                            </div>
                            <div class="col-6 flex-col">
                                <InputGroup>
                                    <InputNumber v-model="product.unit_packaging_paper"
                                        :class="{ 'p-invalid': validationErrors.unit_packaging_paper }" />
                                    <InputGroupAddon>g</InputGroupAddon>
                                </InputGroup>
                                <Message class="my-2" v-if="validationErrors.unit_packaging_paper" severity="error">
                                    {{
                                        validationErrors.unit_packaging_paper[0] }}</Message>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <label class="my-2">Unit Packaging (1 pc) Net Weight (not include product) -
                                    Plastic:</label>
                            </div>
                            <div class="col-6 flex-col">
                                <InputGroup>
                                    <InputNumber v-model="product.unit_packaging_plastic"
                                        :class="{ 'p-invalid': validationErrors.unit_packaging_plastic }" />
                                    <InputGroupAddon>g</InputGroupAddon>
                                </InputGroup>
                                <Message class="my-2" v-if="validationErrors.unit_packaging_plastic" severity="error">{{
                                    validationErrors.unit_packaging_plastic[0] }}</Message>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <label class="my-2">Unit Packaging (1 pc) Net Weight (not include product) -
                                    Metal:</label>
                            </div>
                            <div class="col-6 flex-col">
                                <InputGroup>
                                    <InputNumber v-model="product.unit_packaging_metal"
                                        :class="{ 'p-invalid': validationErrors.unit_packaging_metal }" />
                                    <InputGroupAddon>g</InputGroupAddon>
                                </InputGroup>
                                <Message class="my-2" v-if="validationErrors.unit_packaging_metal" severity="error">
                                    {{
                                        validationErrors.unit_packaging_metal[0] }}</Message>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <label class="my-2">Unit Packaging (1 pc) Net Weight (not include product) -
                                    Others:</label>
                            </div>
                            <div class="col-6 flex-col">
                                <InputGroup>
                                    <InputNumber v-model="product.unit_packaging_others"
                                        :class="{ 'p-invalid': validationErrors.unit_packaging_others }" />
                                    <InputGroupAddon>g</InputGroupAddon>
                                </InputGroup>
                                <Message class="my-2" v-if="validationErrors.unit_packaging_others" severity="error">{{
                                    validationErrors.unit_packaging_others[0] }}</Message>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <label class="my-2">Specify Packaging Material:</label>
                            </div>
                            <div class="col-6 flex-col">
                                <InputText class="w-100 " v-model="product.packaging_material"
                                    :class="{ 'p-invalid': validationErrors.packaging_material }" />
                            </div>
                            <Message class="my-2" v-if="validationErrors.packaging_material" severity="error">{{
                                validationErrors.packaging_material[0] }}</Message>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <label class="my-2">Total Packaging Net Weight:</label>
                            </div>
                            <div class="col-6 flex-col">
                                <InputGroup>
                                    <InputNumber v-model="product.packaging_weight"
                                        :class="{ 'p-invalid': validationErrors.packaging_weight }" />
                                    <InputGroupAddon>g</InputGroupAddon>
                                </InputGroup>
                                <Message class="my-2" v-if="validationErrors.packaging_weight" severity="error">{{
                                    validationErrors.packaging_weight[0] }}</Message>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-6">
                                <label class="my-2">Standard Packaging: <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-6 flex-col">
                                <InputText class="w-100 " v-model="product.standart_packaging"
                                    :class="{ 'p-invalid': validationErrors.standart_packaging }" />
                                <Message class="my-2" v-if="validationErrors.standart_packaging" severity="error">{{
                                    validationErrors.standart_packaging[0] }}</Message>
                            </div>
                        </div>
                        <h3 class="text-milung fw-bold text-uppercase mt-4">6. Manual, Label, Safety Sheet</h3>
                        <fileinput label="Safety Sheet:" inputName="safety_sheet" @upload="handleFileUploaded"
                            :class="{ 'p-invalid': validationErrors.safety_sheet }" />
                        <Message class="my-2" v-if="validationErrors.safety_sheet" severity="error">{{
                            validationErrors.safety_sheet[0] }}
                        </Message>
                        <fileinput label="Manual:" inputName="manual" @upload="handleFileUploaded"
                            :class="{ 'p-invalid': validationErrors.manual }" />
                        <Message class="my-2" v-if="validationErrors.manual" severity="error">{{
                            validationErrors.manual[0] }}
                        </Message>
                        <fileinput label="Product Label:" inputName="product_label" @upload="handleFileUploaded"
                            :class="{ 'p-invalid': validationErrors.product_label }" />
                        <Message class="my-2" v-if="validationErrors.product_label" severity="error">{{
                            validationErrors.product_label[0] }}
                        </Message>
                        <fileinput label="Packaging Label:" inputName="packaging_label" @upload="handleFileUploaded"
                            :class="{ 'p-invalid': validationErrors.packaging_label }" />
                        <Message class="my-2" v-if="validationErrors.packaging_label" severity="error">{{
                            validationErrors.packaging_label[0] }}
                        </Message>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-milung fw-bold text-uppercase">7. Battery Details</h3>
                        <div class="row">

                            <div class="col-6">

                                <div class="d-flex col-12 my-2">
                                    <div class="col-4">
                                        <label class="my-2">Battery Type:</label>
                                    </div>
                                    <div class="col-8">
                                        <InputText class="w-100 " v-model="product.battery_type"
                                            :class="{ 'p-invalid': validationErrors.battery_type }" />
                                        <Message class="my-2" v-if="validationErrors.battery_type" severity="error">{{
                                            validationErrors.battery_type[0] }}
                                        </Message>
                                    </div>
                                </div>
                                <div class="d-flex col-12 my-2">
                                    <div class="col-4">
                                        <label class="my-2">Battery Rated Capacity:</label>
                                    </div>
                                    <div class="col-8">
                                        <InputGroup>
                                            <InputText v-model="product.rated"
                                                :class="{ 'p-invalid': validationErrors.rated }" />
                                            <InputText v-model="product.capacity"
                                                :class="{ 'p-invalid': validationErrors.capacity }" />
                                            <InputGroupAddon>mAh/Wh</InputGroupAddon>
                                            <Message class="my-2" v-if="validationErrors.rated" severity="error">{{
                                                validationErrors.rated[0]
                                                }}</Message>
                                            <Message class="my-2" v-if="validationErrors.capacity" severity="error">{{
                                                validationErrors.capacity[0] }}
                                            </Message>
                                        </InputGroup>
                                    </div>
                                </div>
                                <div class="d-flex col-12 my-2">
                                    <div class="col-4">
                                        <label class="my-2">Battery Nominal Voltage:</label>
                                    </div>
                                    <div class="col-8">
                                        <InputText class="w-100 " v-model="product.voltage"
                                            :class="{ 'p-invalid': validationErrors.voltage }" />
                                        <Message class="my-2" v-if="validationErrors.voltage" severity="error">{{
                                            validationErrors.voltage[0]
                                            }}</Message>
                                    </div>
                                </div>
                                <div class="d-flex col-12 my-2">
                                    <div class="col-4">
                                        <label class="my-2">No. of Battery Contained:</label>
                                    </div>
                                    <div class="col-8">
                                        <InputGroup>
                                            <InputNumber v-model="product.pcs"
                                                :class="{ 'p-invalid': validationErrors.pcs }" />
                                            <InputGroupAddon>pcs</InputGroupAddon>
                                        </InputGroup>
                                        <Message class="my-2" v-if="validationErrors.pcs" severity="error">{{
                                            validationErrors.pcs[0] }}
                                        </Message>
                                    </div>
                                </div>
                                <div class="d-flex col-12 my-2">
                                    <div class="col-4">
                                        <label class="my-2">Product Battery Capacity:</label>
                                    </div>
                                    <div class="col-8">
                                        <InputGroup>
                                            <InputNumber v-model="product.mAh"
                                                :class="{ 'p-invalid': validationErrors.mAh }" />
                                            <InputGroupAddon>mAh</InputGroupAddon>
                                            <Message class="my-2" v-if="validationErrors.mAh" severity="error">{{
                                                validationErrors.mAh[0] }}
                                            </Message>
                                        </InputGroup>
                                    </div>
                                </div>
                                <div class="d-flex col-12 my-2">
                                    <div class="col-4">
                                        <label class="my-2">Battery Size (LxWxH):</label>
                                    </div>
                                    <div class="col-8">
                                        <InputGroup>
                                            <InputNumber v-model="product.mm"
                                                :class="{ 'p-invalid': validationErrors.mm }" />
                                            <InputGroupAddon>mm</InputGroupAddon>
                                            <Message class="my-2" v-if="validationErrors.mm" severity="error">{{
                                                validationErrors.mm[0] }}
                                            </Message>
                                        </InputGroup>
                                    </div>
                                </div>
                                <div class="d-flex col-12 my-2">
                                    <div class="col-4">
                                        <label class="my-2">Battery Net Weight (per pc):</label>
                                    </div>
                                    <div class="col-8">
                                        <InputGroup>
                                            <InputNumber v-model="product.gram"
                                                :class="{ 'p-invalid': validationErrors.gram }" />
                                            <InputGroupAddon>g</InputGroupAddon>
                                            <Message class="my-2" v-if="validationErrors.gram" severity="error">{{
                                                validationErrors.gram[0]
                                                }}</Message>
                                        </InputGroup>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex col-12 my-2">
                                    <div class="col-4">
                                        <label class="my-2">MSDS IATA Edition No.:</label>
                                    </div>
                                    <div class="col-8">
                                        <InputText class="w-100 " v-model="product.edition"
                                            :class="{ 'p-invalid': validationErrors.edition }" />
                                        <Message class="my-2" v-if="validationErrors.edition" severity="error">{{
                                            validationErrors.edition[0] }}
                                        </Message>
                                    </div>
                                </div>

                                <div class="d-flex col-12 my-2">
                                    <div class="col-4">
                                        <label class="my-2">MSDS Expiry Date:</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="date" class="form-control" v-model="product.msds_expiry"
                                            dateFormat="yy-mm-dd"
                                            :class="{ 'p-invalid': validationErrors.msds_expiry }" />
                                        <Message class="my-2" v-if="validationErrors.msds_expiry" severity="error">{{
                                            validationErrors.msds_expiry[0] }}
                                        </Message>
                                    </div>
                                </div>

                                <div class="d-flex col-12 my-2">
                                    <div class="col-4">
                                        <label class="my-2">UN38.3 Expiry Date:</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="date" class="form-control" v-model="product.un_expiry"
                                            dateFormat="yy-mm-dd"
                                            :class="{ 'p-invalid': validationErrors.un_expiry }" />
                                        <Message class="my-2" v-if="validationErrors.un_expiry" severity="error">{{
                                            validationErrors.un_expiry[0] }}
                                        </Message>
                                    </div>
                                </div>
                                <div class="d-flex col-12 my-2">
                                    <div class="col-4">
                                        <label class="my-2">CN Air Safety Report Expiry Date:</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="date" class="form-control" v-model="product.air_safety_expiry"
                                            dateFormat="yy-mm-dd"
                                            :class="{ 'p-invalid': validationErrors.air_safety_expiry }" />
                                        <Message class="my-2" v-if="validationErrors.air_safety_expiry"
                                            severity="error">{{
                                                validationErrors.air_safety_expiry[0] }}</Message>
                                    </div>
                                </div>
                                <div class="d-flex col-12 my-2">
                                    <div class="col-4">
                                        <label class="my-2">CN Sea Safety Report Expiry Date:</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="date" class="form-control" v-model="product.sea_safety_expiry"
                                            dateFormat="yy-mm-dd"
                                            :class="{ 'p-invalid': validationErrors.sea_safety_expiry }" />
                                        <Message class="my-2" v-if="validationErrors.sea_safety_expiry"
                                            severity="error">{{
                                                validationErrors.sea_safety_expiry[0] }}</Message>
                                    </div>
                                </div>
                                <div class="d-flex col-12 my-2">
                                    <div class="col-4">
                                        <label class="my-2">CN Train Safety Report Expiry Date:</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="date" class="form-control" v-model="product.train_safety_expiry"
                                            dateFormat="yy-mm-dd"
                                            :class="{ 'p-invalid': validationErrors.train_safety_expiry }" />
                                        <Message class="my-2" v-if="validationErrors.train_safety_expiry"
                                            severity="error">{{
                                                validationErrors.train_safety_expiry[0] }}</Message>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container d-flex p-4" style="background-color: #14245c;">
                <div class="text-uppercase text-white col-4 fw-bolder my-auto">8. Quote Expire Date:</div>
                <div class="col-6 d-flex">
                    <VueDatePicker calendar-cell-class-name="dp-custom-cell" class="dp__new" v-model="Dates"
                        mode='single' format="dd-MM-yyyy" @input="sendDateOnly"
                        :class="{ 'is-invalid': validationErrors.quoteExpiredDate }">
                    </VueDatePicker>
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
import CertificatesInput from './CertificatesInput.vue';




export default {
    emits: ['profileUpdated'],
    components: {
        ImageSelector,
        fileinput,
        VueDatePicker,
        CertificatesInput,
    },
    data() {
        return {
            suppliers: [],
            selectedSupplier: null,
            loader: false,
            group: '',
            Dates: '',
            statusOptions: [
                { label: 'Active', value: 'active' },
                { label: 'Inactive', value: 'inactive' }
            ],
            certificates: [],
            productOptions: [],
            selectedImages: [],
            selectedFiles: [],
            uploadedFiles: {},
            filename: 'No file chosen',
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
        this.fetchSuppliers();
    },
    watch: {
        Dates: function (newDate, oldDate) {
            this.sendDateOnly();
        }
    },
    methods: {
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
            if (!this.Dates) {
                this.product.quoteExpiredDate = null;
            } else {
                const selectedDate = new Date(this.Dates);
                const formattedDate = `${selectedDate.getFullYear()}-${selectedDate.getMonth() + 1}-${selectedDate.getDate()}`;
                this.product.quoteExpiredDate = formattedDate;
            }
            console.log('Selected Date:', this.product.quoteExpiredDate);
        },
        async submitForm() {
            this.loader = true;
            const fileInput = this.$refs.filenameInput;
            const file = fileInput.files[0];
            this.product.color = Array.isArray(this.product.color) ? this.product.color : [this.product.color];
            this.product.material = Array.isArray(this.product.material) ? this.product.material : [this.product.material];
            this.product.accessory = Array.isArray(this.product.accessory) ? this.product.accessory : [this.product.accessory];
            // Create a new FormData object
            const formData = new FormData();
            if (file) {
                formData.append('quotefile', file);
                formData.append('supplier_id', this.selectedSupplier);
            }

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

.p-inputchips-chip.p-chip {
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
