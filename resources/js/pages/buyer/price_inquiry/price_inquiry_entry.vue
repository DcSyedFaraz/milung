<template>
    <section class="section">
        <form @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="container">

                <div class="row my-5">
                    <h3 class="text-milung mb-4 fw-bold text-uppercase">Price Inquiry {{ mode }}</h3>
                    <div class="col-md-6">
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Inquiry Number:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="inquiry.inquiry_number" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Article Number:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="inquiry.article" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Group:</p>
                            </div>
                            <div class="col-8">
                                <select class=" form-select" v-model="inquiry.group">
                                    <option selected disabled>Select a product group</option>
                                    <option v-for="group1 in groups" :key="group1.id" :value="group1.id">
                                        {{ group1.group_name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Name:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="inquiry.name" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Description/ Specification:</p>
                            </div>
                            <div class="col-8">
                                <textarea v-model="inquiry.description" class="form-control" cols="36"
                                    rows="10"></textarea>
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
                                            v-model="inquiry.cargo">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            General Cargo
                                        </label>
                                    </div>
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="radio" value="danger"
                                            v-model="inquiry.cargo">
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
                                        <input class="form-check-input" type="checkbox" v-model="cargo_place"
                                            value="china">
                                        <label class="form-check-label" for="flexCheckDefault2">
                                            Mainland China
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Incoterm:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="inquiry.incoterm" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Inquiry Quantity:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group my-2" v-for="(material, index) in materials" :key="index">
                                    <input type="number" class="form-control" v-model="materials[index].quantity"
                                        @input="updateInquiryMaterials" />
                                    <span class="input-group-text mx-2 fw-bold" style="color: #41b400;">Pcs</span>
                                    <div class="input-buttons">
                                        <button class="btn btn-warning btn ms-1" type="button"
                                            @click="addMaterial(index)" v-if="index === 0">+</button>
                                        <button class="btn btn-danger  ms-2" type="button"
                                            @click="removeMaterial(index)"
                                            v-if="index !== 0 && materials.length > 1">-</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Capacity:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group my-2" v-for="(caps, indexs) in capacity" :key="indexs">
                                    <input type="number" class="form-control" v-model="capacity[indexs].quantity"
                                        @input="updateInquiryCapacity">
                                    <select style="color: #41b400;" class="fw-bold form-select mx-2"
                                        v-model="capacity[indexs].unit">
                                        <option value="GB">GB</option>
                                        <option value="mAh">mAh</option>
                                    </select>
                                    <div class="input-buttons">
                                        <button class="btn btn-warning btn ms-1" type="button"
                                            @click="addcapacity(indexs)" v-if="indexs === 0">+</button>
                                        <button class="btn btn-danger  ms-2" type="button"
                                            @click="removecapacity(indexs)"
                                            v-if="indexs !== 0 && capacity.length > 1">-</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Printing Method:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="inquiry.method" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Printing Color:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="inquiry.color" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Standard Packaging:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="inquiry.packaging" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Special Requirement:</p>
                            </div>
                            <div class="col-8">
                                <textarea v-model="inquiry.requirements" class="form-control" cols="36"
                                    rows="10"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" class="my-1">Status:</p>
                            </div>
                            <div class="col-8"><select class="fw-bold form-select" v-model="inquiry.status">
                                    <option value="ML Checking">ML Checking</option>
                                    <option value="ML Replied">ML Replied</option>
                                    <option value="ML Follow Up">ML Follow Up</option>
                                    <option value="Customer Follow Up">Customer Follow Up</option>
                                    <option value="Cutomer Quoted">Cutomer Quoted</option>
                                </select></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Notice
                                </label>
                            </div>
                            <div class="col-8">
                                <div class="form-check">
                                    <input class="form-check-input " type="checkbox" v-model="inquiry.urgent">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Urgent
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Buyer Product Photo/3D Artwork:</p>
                                <button @click="importImage" type="button" class="btn px-4 btn-milung">
                                    Import
                                </button>
                            </div>
                            <div class="col-8">
                                <input ref="fileInput" type="file" class="form-control d-none" accept=".jpg,.png">
                                <canvas ref="canvas" width="322" height="300" class="border border-2"></canvas>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Supplier Product Photo/3D Artwork:</p>

                                <a v-if="inquiry.file1" :href="'/storage/files/' + inquiry.file1" download
                                    class="btn px-4 btn-primary my-2">
                                    Export</a>
                            </div>
                            <div class="col-8">
                                <canvas ref="canvas1" width="322" height="300" class="border border-2"></canvas>
                            </div>
                        </div>
                        <div class="col-12 my-2">
                            <div class="row justify-content-end me-5">

                                <button type="button" style="background-color: #41b400 !important;"
                                    class="btn btn-sm  fw-bold btn-milung m-2 col-3" @click="onSubmit">Send ML</button>

                                <button type="button" v-show="follow_up" @click="followup"
                                    class="btn btn-sm  fw-bold btn-warning m-2 col-3 text-white">Follow
                                    Up</button>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
        <div class="row" v-if="supplierData && Object.keys(supplierData).length > 0">
            <h3 class="text-milung mb-4 fw-bold text-uppercase">

                MiLung Inquiry Quote
            </h3>
            <table class="table table-striped table-hover">
                <thead style="color: #009de1" class="text-center">
                    <tr style="">
                        <th class="text-nowrap">Product Capacity</th>
                        <th class="text-nowrap">Quantity</th>
                        <th class="text-nowrap">Currency</th>
                        <th class="text-nowrap">EXW Price</th>
                        <th class="text-nowrap">Remarks</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="(row, index) in supplierData" :key="index">
                        <td class="text-nowrap">
                            {{ row.capacity }}
                        </td>
                        <td class="text-nowrap">
                            {{ row.quantity }}
                        </td>
                        <td class="text-nowrap">USD</td>
                        <td class="text-nowrap" style="width: 13% !important">

                            <span v-if="row.exw">
                                {{ row.exw }}
                            </span>

                            <span v-else class="fst-italic text-muted">
                                Not Provided
                            </span>
                        </td>
                        <td v-show="index === 0" :rowspan="totalRows">

                            <span v-if="row.supplierremarks?.remarks">
                                {{ row.supplierremarks?.remarks }}
                            </span>

                            <span v-else class="fst-italic text-muted">
                                Not Provided
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>

<script>
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';

export default {
    emits: ['profileUpdated'],
    props: {
        mode: String, // "create" or "edit"
    },
    data() {
        return {
            supplierData: {},
            selectedBuyerId: [],
            cargo_place: [],
            inquiry: {
                materials: [{ quantity: '' }], // Initialize with default values
                capacity: [{ quantity: '', unit: '' }],
            },
            materials: [{ quantity: '' }], // Initialize with default values
            capacity: [{ quantity: '', unit: '' }],
            buyers: [],
            follow_up: false,
            groups: [],
            imageLoaded: false,

        };
    },
    methods: {
        followup() {
            NProgress.start();
            const inquiryid = this.$route.params.id;
            console.log(inquiryid);
            axios.get(`/api/buyer/inquiry_followup/${inquiryid}`) // Replace '/api/supplier_profiles/' with your API endpoint
                .then(response => {

                    console.log(response);
                    toastr.success(response.data.message)
                    NProgress.done();
                })
                .catch(error => {
                    console.error(error);
                    NProgress.done();
                });
        },
        updateInquiryMaterials() {
            this.inquiry.materials = this.materials.map(material => ({ quantity: material.quantity }));
        },
        updateInquiryCapacity() {
            // console.log(this.capacity);
            this.inquiry.capacity = this.capacity.map(capacity => ({ quantity: capacity.quantity, unit: capacity.unit }));
        },
        fetchInquiry() {
            const inquiryid = this.$route.params.id;
            axios.get('/api/buyer/price_inquiry/' + inquiryid)
                .then(response => {
                    this.inquiry = response.data.inquiry;
                    this.supplierData = response.data.supplierData;
                    console.log(this.inquiry, this.supplierData);

                    if (inquiryid) {
                        this.follow_up = true;
                    }

                    if (this.inquiry != null) {
                        this.cargo_place = this.inquiry.cargo_place || [];
                        this.loadImageFromPath(this.inquiry.file, this.$refs.canvas);

                        if (this.inquiry.file1 != null) {
                            this.loadImageFromPath(
                                this.inquiry.file1,
                                this.$refs.canvas1
                            );
                        }

                        this.materials = this.inquiry && this.inquiry.pcs ? this.inquiry.pcs.map(quantity => ({ quantity })) : [{ quantity: '' }];
                        this.capacity = this.inquiry && this.inquiry.capacity ? this.inquiry.capacity.map(capacity => {
                            const [quantity, unit] = capacity.match(/(\d+)([a-zA-Z]+)/).slice(1); // Extract quantity and unit from combined value
                            return { quantity: parseInt(quantity), unit }; // Parse quantity to integer and keep unit as extracted
                        }) : [{ quantity: '', unit: '' }];
                    }

                    if (this.inquiry.remarks != null) {
                        this.data.remarks = this.inquiry.remarks.remarks
                    }
                    this.updateInquiryMaterials();
                    this.updateInquiryCapacity();

                })
                .catch(error => {
                    console.error(error);
                });
        },
        fetchProductGroups() {
            NProgress.start();
            axios.get('/api/buyer/product_group_get') // Replace '/api/product-groups' with your API endpoint
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
        addMaterial() {
            this.materials.push({ quantity: '' });
        },
        removeMaterial(index) {
            this.materials.splice(index, 1);
        },
        addcapacity() {
            this.capacity.push({ quantity: '' });
        },
        removecapacity(index) {
            this.capacity.splice(index, 1);
        },
        importImage() {
            this.$refs.fileInput.click();
        },
        loadImage(event) {
            const file = event.target.files[0];
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
        loadImageFromPath(imageFileName, canvas) {
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas context

            // Construct the URL to the file in the storage folder
            const imageUrl = `/storage/files/${imageFileName}`;
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

        loadImage1(event) {
            const file = event.target.files[0];
            if (file) {
                const canvas = this.$refs.canvas1;
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
            }
        },
        handleValidationErrors(validationErrors) {
            // Assuming you have a function to display toastr error messages
            for (const key in validationErrors) {
                if (validationErrors.hasOwnProperty(key)) {
                    const messages = validationErrors[key];
                    // Display each validation error message
                    messages.forEach(message => {
                        toastr.error(message);
                    });
                }
            }
        },
        async onSubmit() {
            NProgress.start();
            try {
                const formData = new FormData();
                formData.append('inquiry_number', this.inquiry.inquiry_number);
                formData.append('article', this.inquiry.article);
                formData.append('group', this.inquiry.group);
                formData.append('name', this.inquiry.name);
                formData.append('description', this.inquiry.description);
                formData.append('cargo', this.inquiry.cargo);
                this.cargo_place.forEach(place => {
                    formData.append('cargo_place[]', place);
                });
                formData.append('incoterm', this.inquiry.incoterm);
                formData.append('urgent', this.inquiry.urgent ? 'true' : 'false');
                formData.append('method', this.inquiry.method);
                formData.append('color', this.inquiry.color);
                formData.append('packaging', this.inquiry.packaging);
                formData.append('requirements', this.inquiry.requirements);
                formData.append('status', this.inquiry.status);
                formData.append('file', this.$refs.fileInput.files[0]);

                for (let i = 0; i < this.inquiry.materials?.length; i++) {
                    formData.append(`pcs[${i}]`, this.inquiry.materials[i].quantity);
                }
                // console.log('bf',this.inquiry.capacity);

                this.capacity.forEach((caps, index) => {

                    const capacityString = `${caps.quantity}${caps.unit}`;
                    // console.log('af', caps.quantity,caps.unit,capacityString);
                    formData.append(`capacity[${index}]`, capacityString);
                });
                console.log(this.inquiry, formData);
                const url = this.mode === 'edit' ? `/api/buyer/price_inquiry/${this.inquiry.id}` : '/api/buyer/price_inquiry';
                const method = this.mode === 'edit' ? 'post' : 'post';
                const response = await axios[method](url, formData);

                if (response.status === 201 || response.status === 200) {
                    NProgress.done();
                    toastr.success(response.data.message);
                    this.$router.push({ name: 'buyer_price_inquiry' });
                    if (this.mode === 'edit') {
                        this.$emit('record-updated');
                    }
                } else {
                    NProgress.done();
                    toastr.error('Something is not correct');
                }
            } catch (error) {
                NProgress.done();
                if (error.response && error.response.status === 422) {
                    const validationErrors = error.response.data.errors;
                    this.handleValidationErrors(validationErrors);
                } else {
                    console.error(error);
                    toastr.error('An error occurred while adding the inquiry');
                }
            }
        }

    },
    computed: {
        totalRows() {
            return this.inquiry.capacity.length * this.inquiry.pcs.length;
        },
        formattedCapacity() {
            return this.capacity.map(caps => `${caps.quantity}${caps.unit}`);
        },
        selectedSupplierIds() {
            return this.supplier_profiles
                .filter(supplier => supplier.checked)
                .map(supplier => supplier.id);
        },
    },
    watch: {
        selectedBuyerId(newValue) {
            // console.log(newValue);
            this.buyer = newValue.id;
        },
    },
    mounted() {
        NProgress.configure({ showSpinner: false });
        this.fetchProductGroups();
        this.fetchInquiry();
        this.$refs.fileInput.addEventListener('change', this.loadImage);

    },
    beforeUnmount() {
        this.$refs.fileInput.removeEventListener('change', this.loadImage);
    }
}
</script>
