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
                                <select class=" form-control" v-model="group">
                                    <option value="">Select a product group</option>
                                    <option v-for="group in groups" :key="group.id" :value="group.group_name">
                                      {{ group.group_name }}
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
                                    <option value="Active">Active</option>
                                    <option value="InActive">In-Active</option>
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

                                <button type="button" class="btn btn-sm  fw-bold btn-milung m-2 col-3">Send To Supplier</button>

                                <button type="button" class="btn btn-sm  fw-bold btn-warning m-2 col-3 text-white">Follow Up</button>

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
        </form>
    </section>
</template>

<script>
export default {
    data() {
        return {
            materials: [{ quantity: '' }],
            capacity: [{ quantity: '' }],
            buyer: '',
            inquiry_number: '',
            article: '',
            groups: [],
            group: '',
            name: '',
            description: '',
            cargo: '',
            cargo_place: [],
            incoterm: '',
            urgent: false,
            method: '',
            color: '',
            packaging: '',
            requirements: '',
            status: '',
            file: '',
            file1: '',
            imageLoaded: false,
        };
    },
    methods: {
        fetchProductGroups() {
            axios.get('/api/product_group_get') // Replace '/api/product-groups' with your API endpoint
                .then(response => {
                    this.groups = response.data;
                    console.log(response);
                })
                .catch(error => {
                    console.error(error);
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
            }
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
                // formData.append('cargo_place', JSON.stringify(this.cargo_place));
                formData.append('incoterm', this.incoterm);
                formData.append('urgent', this.urgent ? 'true' : 'false');
                formData.append('method', this.method);
                formData.append('color', this.color);
                formData.append('packaging', this.packaging);
                formData.append('requirements', this.requirements);
                formData.append('status', this.status);
                formData.append('file', this.$refs.fileInput.files[0]);
                formData.append('file1', this.$refs.fileInput1.files[0]);

                for (let i = 0; i < this.materials.length; i++) {
                    formData.append(`pcs[${i}]`, this.materials[i].quantity);
                }

                // const formattedCapacity = this.formattedCapacity.join(',');
                // formData.append('capacity', formattedCapacity);
                // Append each quantity and unit from capacity array
                this.capacity.forEach((caps, index) => {
                    const capacityString = `${caps.quantity}${caps.unit}`;
                    formData.append(`capacity[${index}]`, capacityString);
                });

                console.log(formData, this.capacity);
                const response = await axios.post('/api/price_inquiry', formData);

                console.log(response);
                if (response.ok) {

                    // Assuming you want to show a success toastr notification
                    toastr.success(response.data.message);
                    this.$router.push({ name: 'price_inquiry' });
                } else {
                    toastr.error('Something is not correct');
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    const validationErrors = error.response.data.errors;
                    this.handleValidationErrors(validationErrors);
                } else {
                    // Non-validation error, log the error
                    console.error(error);

                    // Show a toastr error notification
                    toastr.error('An error occurred while adding the user');
                }
            }
        }
    }, computed: {
        formattedCapacity() {
            return this.capacity.map(caps => `${caps.quantity}${caps.unit}`);
        }
    }
    ,
    mounted() {
        this.fetchProductGroups();
        this.$refs.fileInput.addEventListener('change', this.loadImage);
        this.$refs.fileInput1.addEventListener('change', this.loadImage1);
    },
    beforeUnmount() {
        this.$refs.fileInput.removeEventListener('change', this.loadImage);
        this.$refs.fileInput1.removeEventListener('change', this.loadImage1);
    }
}
</script>
