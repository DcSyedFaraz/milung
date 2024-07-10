<template>
    <section class="bg-halfwhite">
        <div class="row">
            <div class="col-4 border-right-5 ">
                <p class="text-milung fw-bold">PRINTVIEW</p>
                <p class="text-milung fw-bold">
                    Buyer Product Photo/Printview:
                </p>
                <canvas ref="canvas" width="353" height="300" class="border border-2"></canvas>
            </div>
            <div class="col-4">
                <p class="text-milung fw-bold text-uppercase">Supplier</p>

                <span class="d-flex justify-content-between">
                    <p class="text-milung fw-bold">Product:</p>

                </span>

                <canvas ref="productCanvas" width="353" height="300" class="border border-2"></canvas>
            </div>

            <div class="col-4">
                <div class="row" style="margin-top: 2.5rem !important">
                    <div class="col-12">
                        <span class="d-flex justify-content-between">
                            <p class="text-milung fw-bold">Packaging:</p>

                        </span>

                        <canvas ref="packagingCanvas" width="353" height="124" class="border border-2"></canvas>
                    </div>
                    <div class="col-12">
                        <span class="d-flex justify-content-between">
                            <p class="text-milung fw-bold">Accessories:</p>

                        </span>

                        <canvas ref="accessoriesCanvas" width="353" height="124" class="border border-2"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 justify-content-between">
            <div class="col-4">
                <label for="price" class="form-label text-milung fw-bold">Reason For Reject:</label><br />
                <textarea v-model="reason" cols="30" rows="6" class="form-control"></textarea>
            </div>
            <div class="col-6 my-auto mx-auto">
                <div class="">
                    <button class="btn btn-success px-3" value="approve" @click="sendApiRequest('approve')">
                        Approve
                    </button>
                    <button class="btn btn-danger mx-2 px-3" value="reject" @click="sendApiRequest('reject')">
                        Reject
                    </button>

                    <button v-if="data && data.product && data.packaging && data.accessories" class="btn btn-milung"
                        @click="downloadImages"> Download Images
                    </button>

                </div>
            </div>
        </div>
    </section>
    <hr>
    <section class="bg-halfwhite my-5" v-if="can('massCargoPhotoApproval')">
        <div class="row">
            <div class="col-4">
                <p class="text-milung fw-bold text-uppercase">
                    Mass Cargo Photo
                </p>
                <span class="d-flex justify-content-between">
                    <p class="text-milung fw-bold">Product:</p>
                    <input type="file" accept="image/*" ref="cargo_productInput" style="display: none"
                        @change="handleUpload('cargo_product', $event)" />
                    <button class="btn btn-primary btn-sm mb-2" @click="triggerUpload('cargo_productInput')">
                        Upload
                    </button>
                </span>
                <canvas ref="cargo_productCanvas" width="353" height="300" class="border border-2"></canvas>
            </div>

            <div class="col-4">
                <div class="row" style="margin-top: 2.5rem !important">
                    <div class="col-12">
                        <span class="d-flex justify-content-between">
                            <p class="text-milung fw-bold">Packaging:</p>
                            <input type="file" accept="image/*" ref="cargo_packagingInput" style="display: none"
                                @change="
                    handleUpload('cargo_packaging', $event)
                    " />
                            <button class="btn btn-primary btn-sm mb-2" @click="triggerUpload('cargo_packagingInput')">
                                Upload
                            </button>
                        </span>

                        <canvas ref="cargo_packagingCanvas" width="353" height="124" class="border border-2"></canvas>
                    </div>
                    <div class="col-12">
                        <span class="d-flex justify-content-between">
                            <p class="text-milung fw-bold">Accessories:</p>
                            <input type="file" accept="image/*" ref="cargo_accessoriesInput" style="display: none"
                                @change="
                    handleUpload('cargo_accessories', $event)
                    " />
                            <button class="btn btn-primary btn-sm mb-2"
                                @click="triggerUpload('cargo_accessoriesInput')">
                                Upload
                            </button>
                        </span>

                        <canvas ref="cargo_accessoriesCanvas" width="353" height="124" class="border border-2"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 justify-content-between">
            <div class="col-4">
                <label for="price" class="form-label text-milung fw-bold">Reason For Reject:</label><br />
                <textarea v-model="cargo_reason" cols="30" rows="6" class="form-control"></textarea>
            </div>
            <div class="col-4 my-auto mx-auto">
                <div class="">
                    <button class="btn btn-success px-5" @click="CargoApiRequest">
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
        id: { type: Number, },
        image: { type: Array },
    },
    data() {
        return {
            reason: "",
            cargo_reason: "",
            data: null,
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
        async sendApiRequest(action) {
            NProgress.start();
            try {

                if (action === 'reject') {
                    if (!this.reason) {
                        toastr.error('Please provide a reason for rejection');
                        NProgress.done();
                        return;
                    }
                    this.formData.append("reason", this.reason);
                }

                this.formData.append("action", action);

                console.log(action);

                const response = await axios.post(
                    "/api/printview/" + this.id,
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
        downloadImages() {
            // Define an array containing the URLs of the images to download
            const imageUrls = [
                `/storage/${this.data.product}`,
                `/storage/${this.data.packaging}`,
                `/storage/${this.data.accessories}`
            ];

            // Loop through the array and initiate downloads for each image
            imageUrls.forEach(url => {
                this.downloadImage(url);
            });
        },
        downloadImage(url) {
            console.log(url);
            // Create an anchor element dynamically
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', ''); // Add the 'download' attribute to force download
            document.body.appendChild(link);

            // Trigger a click event on the anchor element to initiate the download
            link.click();

            // Remove the anchor element from the DOM
            document.body.removeChild(link);
        },
        fetchprintview() {
            NProgress.start();
            const orderId = this.$route.params.id;
            axios
                .get(`/api/printview/${orderId}`)
                .then((response) => {
                    this.data = response.data;
                    // console.log(data);

                    this.reason = this.data.reason;
                    this.loadImageFromPath(
                        this.data.product,
                        this.$refs.productCanvas
                    );

                    this.loadImageFromPath(
                        this.data.packaging,
                        this.$refs.packagingCanvas
                    );
                    this.loadImageFromPath(
                        this.data.accessories,
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
                if (this.$refs.cargo_productInput.files[0]) {
                    this.cargoData.append(
                        "cargo_product",
                        this.$refs.cargo_productInput.files[0]
                    );
                }

                if (this.$refs.cargo_packagingInput.files[0]) {
                    this.cargoData.append(
                        "cargo_packaging",
                        this.$refs.cargo_packagingInput.files[0]
                    );
                }

                if (this.$refs.cargo_accessoriesInput.files[0]) {
                    this.cargoData.append(
                        "cargo_accessories",
                        this.$refs.cargo_accessoriesInput.files[0]
                    );
                }
                if (this.cargo_reason) {
                    this.cargoData.append("cargo_reason", this.cargo_reason);
                }

                console.log(this.cargoData);

                const response = await axios.post(
                    "/api/masscargo/" + this.id,
                    this.cargoData
                );
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
            console.log(imageUrl, ctx);

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

        setTimeout(() => {
            // console.log('hi', this.image);
            if (this.image && this.image.length > 0) {
                this.loadImageFromPath(this.image[0].filepath, this.$refs.canvas);
            }
        }, 1000);

    },
};
</script>
<style scoped>
.vl {
    border-left: 6px solid green;
    height: 500px;

}
.border-right-5 {
    border-right: 5px solid #dee2e6;
  }
</style>
