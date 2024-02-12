<template>
    <section class="section">
        <form @submit.prevent="submitForm" enctype="multipart/form-data">

            <div class="container">

                <div class="row my-5">
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
                                <!-- <input type="text" v-model="name" class="form-control"> -->
                                <select class=" form-control" v-model="group">
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
                                    <input class="form-check-input " type="checkbox" value="urgent" v-model="urgent">
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
            inquiry_number: '', article: '', group: '', name: '', description: '', cargo: '', cargo_place: [], incoterm: '', urgent: false, method: '', color: '', packaging: '', requirements: '', status: '', file: '', imageLoaded: false,
        };
    },
    methods: {
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
        onSubmit() {
            // Handle form submission
        }
    },
    mounted() {
        this.$refs.fileInput.addEventListener('change', this.loadImage);
    },
    beforeUnmount() {
        this.$refs.fileInput.removeEventListener('change', this.loadImage);
    }
}
</script>
