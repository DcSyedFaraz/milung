<template>
    <section class="bg-halfwhite">
        <div class="row">
            <div class="col-4">
                <p class="text-milung fw-bold">PRINTVIEW</p>
                <p class="text-milung fw-bold">
                    Buyer Product Photo/Printview:
                </p>
                <canvas
                    ref="canvas"
                    width="353"
                    height="300"
                    class="border border-2"
                ></canvas>
            </div>

            <div class="col-4">
                <p class="text-milung fw-bold text-uppercase">Supplier</p>

                <span class="d-flex justify-content-between">
                    <p class="text-milung fw-bold">Product:</p>
                    <input
                        type="file"
                        accept="image/*"
                        ref="productInput"
                        style="display: none"
                        @change="handleUpload('product', $event)"
                    />
                    <button
                        class="btn btn-primary btn-sm mb-2"
                        @click="triggerUpload('productInput')"
                    >
                        Upload
                    </button>
                </span>

                <canvas
                    ref="productCanvas"
                    width="353"
                    height="300"
                    class="border border-2"
                ></canvas>
            </div>

            <div class="col-4">
                <div class="row" style="margin-top: 2.5rem !important">
                    <div class="col-12">
                        <span class="d-flex justify-content-between">
                            <p class="text-milung fw-bold">Packaging:</p>
                            <input
                                type="file"
                                accept="image/*"
                                ref="packagingInput"
                                style="display: none"
                                @change="handleUpload('packaging', $event)"
                            />
                            <button
                                class="btn btn-primary btn-sm mb-2"
                                @click="triggerUpload('packagingInput')"
                            >
                                Upload
                            </button>
                        </span>

                        <canvas
                            ref="packagingCanvas"
                            width="353"
                            height="124"
                            class="border border-2"
                        ></canvas>
                    </div>
                    <div class="col-12">
                        <span class="d-flex justify-content-between">
                            <p class="text-milung fw-bold">Accessories:</p>
                            <input
                                type="file"
                                accept="image/*"
                                ref="accessoriesInput"
                                style="display: none"
                                @change="handleUpload('accessories', $event)"
                            />
                            <button
                                class="btn btn-primary btn-sm mb-2"
                                @click="triggerUpload('accessoriesInput')"
                            >
                                Upload
                            </button>
                        </span>

                        <canvas
                            ref="accessoriesCanvas"
                            width="353"
                            height="124"
                            class="border border-2"
                        ></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 justify-content-between">
            <div class="col-4">
                <label for="price" class="form-label text-milung fw-bold"
                    >Reason For Reject:</label
                ><br />
                <textarea
                    v-model="reason"
                    cols="30"
                    rows="6"
                    class="form-control"
                ></textarea>
            </div>
            <div class="col-4 my-auto mx-auto">
                <div class="">
                    <button
                        class="btn btn-success px-5"
                        @click="sendApiRequest"
                    >
                        Send
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-halfwhite my-5">
        <div class="row">
            <div class="col-4">
                <p class="text-milung fw-bold text-uppercase">
                    Mass Cargo Photo
                </p>
                <span class="d-flex justify-content-between">
                    <p class="text-milung fw-bold">Product:</p>
                    <input
                        type="file"
                        accept="image/*"
                        ref="cargo_productInput"
                        style="display: none"
                        @change="handleUpload('cargo_product', $event)"
                    />
                    <button
                        class="btn btn-primary btn-sm mb-2"
                        @click="triggerUpload('cargo_productInput')"
                    >
                        Upload
                    </button>
                </span>
                <canvas
                    ref="cargo_productCanvas"
                    width="353"
                    height="300"
                    class="border border-2"
                ></canvas>
            </div>

            <div class="col-4">
                <div class="row" style="margin-top: 2.5rem !important">
                    <div class="col-12">
                        <span class="d-flex justify-content-between">
                            <p class="text-milung fw-bold">Packaging:</p>
                            <input
                                type="file"
                                accept="image/*"
                                ref="cargo_packagingInput"
                                style="display: none"
                                @change="
                                    handleUpload('cargo_packaging', $event)
                                "
                            />
                            <button
                                class="btn btn-primary btn-sm mb-2"
                                @click="triggerUpload('cargo_packagingInput')"
                            >
                                Upload
                            </button>
                        </span>

                        <canvas
                            ref="cargo_packagingCanvas"
                            width="353"
                            height="124"
                            class="border border-2"
                        ></canvas>
                    </div>
                    <div class="col-12">
                        <span class="d-flex justify-content-between">
                            <p class="text-milung fw-bold">Accessories:</p>
                            <input
                                type="file"
                                accept="image/*"
                                ref="cargo_accessoriesInput"
                                style="display: none"
                                @change="
                                    handleUpload('cargo_accessories', $event)
                                "
                            />
                            <button
                                class="btn btn-primary btn-sm mb-2"
                                @click="triggerUpload('cargo_accessoriesInput')"
                            >
                                Upload
                            </button>
                        </span>

                        <canvas
                            ref="cargo_accessoriesCanvas"
                            width="353"
                            height="124"
                            class="border border-2"
                        ></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 justify-content-between">
            <div class="col-4">
                <label for="price" class="form-label text-milung fw-bold"
                    >Reason For Reject:</label
                ><br />
                <textarea
                    v-model="cargo_reason"
                    cols="30"
                    rows="6"
                    class="form-control"
                ></textarea>
            </div>
            <div class="col-4 my-auto mx-auto">
                <div class="">
                    <button
                        class="btn btn-success px-5"
                        @click="CargoApiRequest"
                    >
                        Send
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import NProgress from "nprogress";
import "nprogress/nprogress.css";
export default {
    props: {
        id: { type: Number, required: true },
    },
    data() {
        return {
            reason: "",
            cargo_reason: "",
            formData: new FormData(),
            cargoData: new FormData(),
        };
    },
    methods: {
        handleValidationErrors(validationErrors) {
            console.log(validationErrors);
            // Assuming you have a function to display toastr error messages
            // validationErrors.forEach((message) => {
            //     toastr.error(message);
            // });
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
        async sendApiRequest() {
            NProgress.start();
            try {
                if (this.$refs.productInput.files[0]) {
                    this.formData.append(
                        "product",
                        this.$refs.productInput.files[0]
                    );
                }

                if (this.$refs.packagingInput.files[0]) {
                    this.formData.append(
                        "packaging",
                        this.$refs.packagingInput.files[0]
                    );
                }

                if (this.$refs.accessoriesInput.files[0]) {
                    this.formData.append(
                        "accessories",
                        this.$refs.accessoriesInput.files[0]
                    );
                }

                this.formData.append("reason", this.reason);
                console.log(this.formData);

                const response = await axios.post(
                    "/api/supplier/printview/" + this.id,
                    this.formData
                );
                NProgress.done();
                console.log(response);
                toastr.success(response.data.message);
            } catch (error) {
                NProgress.done();
                console.error(error);

                if (error.response && error.response.status === 422) {
                    toastr.error(error.response.data.errors);
                }
                if (error.response && error.response.status === 400) {
                    const validationErrors = error.response.data.errors;
                    this.handleValidationErrors(validationErrors);
                } else {
                    console.error(error);
                    toastr.error("An error occurred while updating the order");
                }
            }
        },
        fetchprintview() {
            NProgress.start();
            const orderId = this.$route.params.id;
            axios
                .get(`/api/supplier/printview/${orderId}`)
                .then((response) => {
                    const data = response.data;
                    // console.log(data);

                    this.reason = data.reason;
                    this.loadImageFromPath(
                        data.product,
                        this.$refs.productCanvas
                    );
                    this.loadImageFromPath(
                        data.packaging,
                        this.$refs.packagingCanvas
                    );
                    this.loadImageFromPath(
                        data.accessories,
                        this.$refs.accessoriesCanvas
                    );
                    NProgress.done();
                })
                .catch((error) => {
                    console.error(error);
                    NProgress.done();
                });
        },
        async CargoApiRequest() {
            try {
                if (this.$refs.productInput.files[0]) {
                    this.cargoData.append(
                        "cargo_product",
                        this.$refs.productInput.files[0]
                    );
                }

                if (this.$refs.packagingInput.files[0]) {
                    this.cargoData.append(
                        "cargo_packaging",
                        this.$refs.packagingInput.files[0]
                    );
                }

                if (this.$refs.accessoriesInput.files[0]) {
                    this.cargoData.append(
                        "cargo_accessories",
                        this.$refs.accessoriesInput.files[0]
                    );
                }

                this.cargoData.append("cargo_reason", this.cargo_reason);
                console.log(this.cargoData);

                const response = await axios.post(
                    "/api/supplier/masscargo/" + this.id,
                    this.cargoData
                );
                console.log(response);
            } catch (error) {
                console.error(error);
            }
        },

        handleUpload(refName, event) {
            const file = event.target.files[0];
            const canvas = this.$refs[refName + "Canvas"];
            const ctx = canvas.getContext("2d");
            ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas context

            const reader = new FileReader();
            reader.onload = (event) => {
                const img = new Image();
                img.onload = () => {
                    const aspectRatio = img.width / img.height;
                    let newWidth, newHeight;

                    if (aspectRatio > 1) {
                        newWidth = canvas.width;
                        newHeight = newWidth / aspectRatio;
                    } else {
                        newHeight = canvas.height;
                        newWidth = newHeight * aspectRatio;
                    }

                    const offsetX = (canvas.width - newWidth) / 2;
                    const offsetY = (canvas.height - newHeight) / 2;

                    ctx.drawImage(img, offsetX, offsetY, newWidth, newHeight);
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
            this.formData.append(refName, file);
            console.log(refName, file);
        },
        triggerUpload(refName) {
            this.$refs[refName].click();
        },
        loadImageFromPath(imageFileName, canvas) {
            const ctx = canvas.getContext("2d");
            ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas context

            // Construct the URL to the file in the storage folder
            const imageUrl = `/storage/${imageFileName}`;
            // console.log(imageUrl, ctx);

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
                // console.log(
                //     "Image loaded and drawn onto the canvas successfully."
                // );
            };
            img.src = imageUrl;
        },
    },
    mounted() {
        this.fetchprintview();
    },
};
</script>
<style scoped></style>
