<template>
    <section class="section">
        <form @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="container">
                <div class="row my-5">
                    <h3 class="text-milung mb-4 fw-bold text-uppercase">
                        Price Inquiry
                    </h3>
                    <div class="col-md-6">
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Article Number:</p>
                            </div>
                            <div class="col-8">
                                {{ user.article }}
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Group:</p>
                            </div>
                            <div class="col-8">
                                {{ user.product_group?.group_name }}
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Name:</p>
                            </div>
                            <div class="col-8">
                                {{ user.name }}
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Incoterm:</p>
                            </div>
                            <div class="col-8">
                                {{ user.incoterm }}
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Inquiry Quantity:</p>
                            </div>
                            <div class="col-8">
                                <span
                                    v-for="item in user.pcs"
                                    class="fw-bold text-danger"
                                    >{{ item }} pcs <br
                                /></span>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Product Capacity:</p>
                            </div>
                            <div class="col-8">
                                <span
                                    v-for="item in user.capacity"
                                    class="fw-bold text-success"
                                    >{{ item }} <br
                                /></span>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Printing Method:</p>
                            </div>
                            <div class="col-8">
                                {{ user.method }}
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Printing Color:</p>
                            </div>
                            <div class="col-8">
                                {{ user.color }}
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Standard Packaging:</p>
                            </div>
                            <div class="col-8">
                                {{ user.packaging }}
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">Special Requirement:</p>
                            </div>
                            <div class="col-8">
                                {{ user.requirements }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model" class="my-1">Status:</p>
                            </div>
                            <div class="col-8">
                                {{ user.status }}
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <label
                                    class="form-check-label"
                                    for="flexCheckDefault"
                                >
                                    Notice
                                </label>
                            </div>
                            <div class="col-8">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        v-model="user.urgent"
                                    />
                                    <label
                                        class="form-check-label"
                                        for="flexCheckDefault"
                                    >
                                        Urgent
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">
                                    Buyer Product Photo/3D Artwork:
                                </p>
                                <a
                                    :href="'/storage/files/' + user.file"
                                    download
                                    class="btn px-4 btn-primary my-2"
                                >
                                    Export</a
                                >
                            </div>
                            <div class="col-8">
                                <canvas
                                    ref="canvas"
                                    width="322"
                                    height="300"
                                    class="border border-2"
                                ></canvas>
                            </div>
                        </div>
                        <div class="d-flex col-11 my-2">
                            <div class="col-4">
                                <p for="v-model">
                                    Supplier Product Photo/3D Artwork:
                                </p>
                                <button
                                    @click="importImage1"
                                    type="button"
                                    class="btn px-4 btn-milung"
                                >
                                    Import
                                </button>
                            </div>
                            <div class="col-8">
                                <input
                                    ref="fileInput1"
                                    type="file"
                                    class="form-control d-none"
                                    accept=".jpg,.png"
                                />
                                <canvas
                                    ref="canvas1"
                                    width="322"
                                    height="300"
                                    class="border border-2"
                                ></canvas>
                            </div>
                        </div>
                        <div class="col-12 my-2">
                            <div class="row ms-2">
                                <button
                                    type="button"
                                    style="background-color: aqua !important"
                                    class="btn btn-sm fw-bold btn-milung m-2 col-3"
                                >
                                    Quote ML
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>

<script>
import NProgress from "nprogress";
import "nprogress/nprogress.css";

export default {
    props: {
        mode: String, // "create" or "edit"
    },
    data() {
        return {
            materials:
                this.mode === "create"
                    ? [{ quantity: "" }]
                    : this.user && this.user.pcs
                    ? this.user.pcs.map((quantity) => ({ quantity }))
                    : [{ quantity: "" }],
            capacity:
                this.mode === "create"
                    ? [{ quantity: "", unit: "" }]
                    : this.user && this.user.capacity
                    ? this.user.capacity.map((capacity) => {
                          const [quantity, unit] = capacity
                              .match(/(\d+)([a-zA-Z]+)/)
                              .slice(1); // Extract quantity and unit from combined value
                          return { quantity: parseInt(quantity), unit }; // Parse quantity to integer and keep unit as extracted
                      })
                    : [{ quantity: "" }],
            groups: [],
            user: {},
            imageLoaded: false,
            supplier_profiles: [],
        };
    },
    methods: {
        fetchSupplierProfiles(groupId) {
            NProgress.start();
            console.log(groupId);
            axios
                .get(`/api/supplier_profiles/${groupId}`) // Replace '/api/supplier_profiles/' with your API endpoint
                .then((response) => {
                    this.supplier_profiles = response.data;
                    console.log(response);
                    NProgress.done();
                })
                .catch((error) => {
                    console.error(error);
                    NProgress.done();
                });
        },
        fetchInquiry() {
            NProgress.start();
            const inquiryid = this.$route.params.id;
            axios
                .get("/api/supplier/price_inquiry_get/" + inquiryid) // Replace '/api/product-groups' with your API endpoint
                .then((response) => {
                    this.user = response.data;
                    this.loadImageFromPath(this.user.file, this.$refs.canvas);

                    console.log(response.data);
                    NProgress.done();
                })
                .catch((error) => {
                    console.error(error);
                    NProgress.done();
                });
        },

        importImage() {
            this.$refs.fileInput.click();
        },
        loadImage(event) {
            const file = event.target.files[0];
            if (file) {
                const canvas = this.$refs.canvas;
                const ctx = canvas.getContext("2d");
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
                console.log("event", this.file);
                this.loadImageFromPath(this.file, this.$refs.canvas);
            }
        },
        loadImageFromPath(imageFileName, canvas) {
            const ctx = canvas.getContext("2d");
            ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas context

            // Construct the URL to the file in the storage folder
            const imageUrl = `/storage/files/${imageFileName}`;

            const img = new Image();
            console.log(imageFileName, img);
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
                console.log(
                    "Image loaded and drawn onto the canvas successfully."
                );
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
                const ctx = canvas.getContext("2d");
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
                    messages.forEach((message) => {
                        toastr.error(message);
                    });
                }
            }
        },
        async onSubmit() {
            NProgress.start();
            try {
                const formData = new FormData();
                formData.append("buyer", this.buyer);
                formData.append("inquiry_number", this.inquiry_number);
                formData.append("article", this.article);
                formData.append("group", this.group);
                formData.append("name", this.name);
                formData.append("description", this.description);
                formData.append("cargo", this.cargo);
                this.cargo_place.forEach((place) => {
                    formData.append("cargo_place[]", place);
                });
                formData.append("incoterm", this.incoterm);
                formData.append("urgent", this.urgent ? "true" : "false");
                formData.append("method", this.method);
                formData.append("color", this.color);
                formData.append("packaging", this.packaging);
                formData.append("requirements", this.requirements);
                formData.append("status", this.status);
                formData.append("file", this.$refs.fileInput.files[0]);
                formData.append("file1", this.$refs.fileInput1.files[0]);

                this.selectedSupplierIds.forEach((id) => {
                    formData.append("supplier_ids[]", id);
                });

                for (let i = 0; i < this.materials.length; i++) {
                    formData.append(`pcs[${i}]`, this.materials[i].quantity);
                }

                this.capacity.forEach((caps, index) => {
                    const capacityString = `${caps.quantity}${caps.unit}`;
                    formData.append(`capacity[${index}]`, capacityString);
                });
                console.log(formData);
                const url =
                    this.mode === "edit"
                        ? `/api/supplier/update_price_inquiry/${this.user.id}`
                        : "/api/supplier/price_inquiry";
                // const method = this.mode === 'edit' ? 'put' : 'post';
                const method = "post";
                const response = await axios[method](url, formData);

                if (response.status === 201 || response.status === 200) {
                    NProgress.done();
                    toastr.success(response.data.message);
                    this.$router.push({ name: "price_inquiry" });
                    if (this.mode === "edit") {
                        this.$emit("record-updated");
                    }
                } else {
                    NProgress.done();
                    toastr.error("Something is not correct");
                }
            } catch (error) {
                NProgress.done();
                if (error.response && error.response.status === 422) {
                    const validationErrors = error.response.data.errors;
                    this.handleValidationErrors(validationErrors);
                } else {
                    console.error(error);
                    toastr.error("An error occurred while adding the user");
                }
            }
        },
    },
    computed: {},
    mounted() {
        NProgress.configure({ showSpinner: false });
        this.fetchInquiry();
        this.$refs.fileInput1.addEventListener("change", this.loadImage1);

        // Trigger loadImage method if in edit mode and there's an existing image
    },
    beforeUnmount() {
        this.$refs.fileInput1.removeEventListener("change", this.loadImage1);
    },
};
</script>
