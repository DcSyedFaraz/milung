<template>
    <section class="section">
        <form @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="container">

                <div class="row my-5">
                    <h3 class="text-milung mb-4 fw-bold text-uppercase">Price Inquiry</h3>
                    <div class="col-md-6">
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Buyer ID:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="buyer" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Inquiry Number:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="inquiry_number" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Article Number:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="article" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Group:</p>
                            </div>
                            <div class="col-8">
                                <select class=" form-control" v-model="group" @change="fetchSupplierProfiles(group)">
                                    <option selected disabled>Select a product group</option>
                                    <option v-for="group1 in groups" :key="group1.id" :value="group1.id">
                                        {{ group1.group_name }}
                                    </option>
                                </select>
                                <!-- <input type="text" v-model="name" class="form-control"> -->
                                <!-- <select class=" form-control" v-model="group">
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
                                </select> -->
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Name:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="name" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Description/ Specification:</p>
                            </div>
                            <div class="col-8">
                                <textarea v-model="description" class="form-control" cols="36" rows="10"></textarea>
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
                                <p for="v-model">Incoterm:</p>
                            </div>
                            <div class="col-8">
                                <input type="text" v-model="incoterm" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Inquiry Quantity:</p>
                            </div>
                            <div class="col-8">
                                <div class="input-group my-2" v-for="(material, index) in materials" :="index">
                                    <input type="number" class="form-control" v-model="material.quantity" />
                                    <span class="input-group-text mx-2 fw-bold" style="color: #41b400;">Pcs</span>
                                    <div class="input-buttons">
                                        <button class="btn btn-warning btn ms-1" type="button" @click="addMaterial(index)"
                                            v-if="index === 0">+</button>
                                        <button class="btn btn-danger  ms-2" type="button" @click="removeMaterial(index)"
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
                                <div class="input-group my-2" v-for="(caps, indexs) in capacity" :="indexs">
                                    <input type="number" class="form-control" v-model="caps.quantity">
                                    <select style="color: #41b400;" class="fw-bold form-control mx-2" v-model="caps.unit">
                                        <option value="GB">GB</option>
                                        <option value="mAh">mAh</option>
                                    </select>
                                    <div class="input-buttons">
                                        <button class="btn btn-warning btn ms-1" type="button" @click="addcapacity(indexs)"
                                            v-if="indexs === 0">+</button>
                                        <button class="btn btn-danger  ms-2" type="button" @click="removecapacity(indexs)"
                                            v-if="indexs !== 0 && capacity.length > 1">-</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Printing Method:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="method" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Printing Color:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="color" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Standard Packaging:</p>
                            </div>
                            <div class="col-8"><input type="text" v-model="packaging" class="form-control"></div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Special Requirement:</p>
                            </div>
                            <div class="col-8">
                                <textarea v-model="requirements" class="form-control" cols="36" rows="10"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" class="my-1">Status:</p>
                            </div>
                            <div class="col-8"><select class="fw-bold form-control" v-model="status">
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
                                    <input class="form-check-input " type="checkbox" v-model="urgent">
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
                                <button type="button" class="btn px-4 btn-primary my-2">
                                    Export
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
                                <button @click="importImage1" type="button" class="btn px-4 btn-milung">
                                    Import
                                </button>
                                <button type="button" class="btn px-4 btn-primary my-2">
                                    Export
                                </button>
                            </div>
                            <div class="col-8">
                                <input ref="fileInput1" type="file" class="form-control d-none" accept=".jpg,.png">
                                <canvas ref="canvas1" width="322" height="300" class="border border-2"></canvas>
                            </div>
                        </div>
                        <div class="col-12 my-2">
                            <div class="row ms-2">

                                <button type="button" class="btn btn-sm  fw-bold btn-milung m-2 col-3"
                                    data-bs-toggle="modal" data-bs-target="#supplierModal">Send To Supplier</button>

                                <button type="button" class="btn btn-sm  fw-bold btn-warning m-2 col-3 text-white">Follow
                                    Up</button>

                                <button type="button" style="background-color: aqua !important; "
                                    class="btn btn-sm  fw-bold btn-milung m-2 col-3">Quote Buyer</button>

                                <button style="background-color: #bc7803 !important;"
                                    class="btn btn-sm  fw-bold btn-milung m-2 col-3">Create Order</button>

                                <button type="button" style="background-color: #41b400 !important;"
                                    class="btn btn-sm  fw-bold btn-milung m-2 col-3">Supplier To Buyer</button>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Select Supplier</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-check" v-for="(supplier, index) in supplier_profiles" :key="index">
                                <input class="form-check-input" type="checkbox" :value="supplier.id"
                                    v-model="supplier.checked">
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ supplier.name }}
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>

<script>
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';

export default {
    props: {
        mode: String, // "create" or "edit"
        user: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            materials: this.mode === 'create' ? [{ quantity: '' }] : this.user && this.user.pcs ? this.user.pcs.map(quantity => ({ quantity })) : [{ quantity: '' }],
            capacity: this.mode === 'create' ? [{ quantity: '', unit: '' }] : this.user && this.user.capacity ? this.user.capacity.map(capacity => {
                const [quantity, unit] = capacity.match(/(\d+)([a-zA-Z]+)/).slice(1); // Extract quantity and unit from combined value
                return { quantity: parseInt(quantity), unit }; // Parse quantity to integer and keep unit as extracted
            }) : [{ quantity: '' }],
            buyer: this.mode === 'create' ? '' : this.user ? this.user.buyer : '',
            inquiry_number: this.mode === 'create' ? '' : this.user ? this.user.inquiry_number : '',
            article: this.mode === 'create' ? '' : this.user ? this.user.article : '',
            groups: [],
            group: this.mode === 'create' ? null : this.user ? this.user.group : null,
            name: this.mode === 'create' ? '' : this.user ? this.user.name : '',
            description: this.mode === 'create' ? '' : this.user ? this.user.description : '',
            cargo: this.mode === 'create' ? '' : this.user ? this.user.cargo : '',
            cargo_place: this.mode === 'create' ? [] : this.user ? this.user.cargo_place : [],
            incoterm: this.mode === 'create' ? '' : this.user ? this.user.incoterm : '',
            urgent: this.mode === 'create' ? false : this.user ? this.user.urgent : false,
            method: this.mode === 'create' ? '' : this.user ? this.user.method : '',
            color: this.mode === 'create' ? '' : this.user ? this.user.color : '',
            packaging: this.mode === 'create' ? '' : this.user ? this.user.packaging : '',
            requirements: this.mode === 'create' ? '' : this.user ? this.user.requirements : '',
            status: this.mode === 'create' ? '' : this.user ? this.user.status : '',
            file: this.mode === 'create' ? '' : this.user ? this.user.file : '',
            file1: this.mode === 'create' ? '' : this.user ? this.user.file1 : '',
            imageLoaded: false,
            supplier_profiles: [],
        };
    },
    methods: {
        fetchSupplierProfiles(groupId) {
            NProgress.start();
            console.log(groupId);
            axios.get(`/api/supplier_profiles/${groupId}`) // Replace '/api/supplier_profiles/' with your API endpoint
                .then(response => {
                    this.supplier_profiles = response.data;
                    console.log(response);
                    NProgress.done();
                })
                .catch(error => {
                    console.error(error);
                    NProgress.done();
                });
        },
        fetchProductGroups() {
            NProgress.start();
            axios.get('/api/product_group_get') // Replace '/api/product-groups' with your API endpoint
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

        importImage1() {
            this.$refs.fileInput1.click();
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
                formData.append('buyer', this.buyer);
                formData.append('inquiry_number', this.inquiry_number);
                formData.append('article', this.article);
                formData.append('group', this.group);
                formData.append('name', this.name);
                formData.append('description', this.description);
                formData.append('cargo', this.cargo);
                this.cargo_place.forEach(place => {
                    formData.append('cargo_place[]', place);
                });
                formData.append('incoterm', this.incoterm);
                formData.append('urgent', this.urgent ? 'true' : 'false');
                formData.append('method', this.method);
                formData.append('color', this.color);
                formData.append('packaging', this.packaging);
                formData.append('requirements', this.requirements);
                formData.append('status', this.status);
                formData.append('file', this.$refs.fileInput.files[0]);
                formData.append('file1', this.$refs.fileInput1.files[0]);

                this.selectedSupplierIds.forEach(id => {
                    formData.append('supplier_ids[]', id);
                });

                for (let i = 0; i < this.materials.length; i++) {
                    formData.append(`pcs[${i}]`, this.materials[i].quantity);
                }

                this.capacity.forEach((caps, index) => {
                    const capacityString = `${caps.quantity}${caps.unit}`;
                    formData.append(`capacity[${index}]`, capacityString);
                });
                console.log(formData);
                const url = this.mode === 'edit' ? `/api/update_price_inquiry/${this.user.id}` : '/api/price_inquiry';
                // const method = this.mode === 'edit' ? 'put' : 'post';
                const method = 'post';
                const response = await axios[method](url, formData);

                if (response.status === 201 || response.status === 200) {
                    NProgress.done();
                    toastr.success(response.data.message);
                    this.$router.push({ name: 'price_inquiry' });
                    if (this.mode === 'edit'){
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
                    toastr.error('An error occurred while adding the user');
                }
            }
        }

    }, computed: {
        formattedCapacity() {
            return this.capacity.map(caps => `${caps.quantity}${caps.unit}`);
        },
        selectedSupplierIds() {
            return this.supplier_profiles
                .filter(supplier => supplier.checked)
                .map(supplier => supplier.id);
        },
    }
    ,
    mounted() {
        NProgress.configure({ showSpinner: false });
        this.fetchProductGroups();
        this.$refs.fileInput.addEventListener('change', this.loadImage);
        this.$refs.fileInput1.addEventListener('change', this.loadImage1);

        // Trigger loadImage method if in edit mode and there's an existing image
        if (this.mode === 'edit' && this.file) {
            this.loadImageFromPath(this.file, this.$refs.canvas);
        }
        if (this.mode === 'edit' && this.file1) {
            this.loadImageFromPath(this.file1, this.$refs.canvas1);
        }
    },
    beforeUnmount() {
        this.$refs.fileInput.removeEventListener('change', this.loadImage);
        this.$refs.fileInput1.removeEventListener('change', this.loadImage1);
    }
}
</script>
