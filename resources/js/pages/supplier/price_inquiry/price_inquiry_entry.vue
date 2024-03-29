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
                            <div class="row me-5 justify-content-end">
                                <button
                                    type="submit"
                                    style="background-color: #009de1 !important"
                                    class="btn btn-sm fw-bold btn-milung m-2 col-3"
                                >
                                    Quote ML
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h3 class="text-milung mb-4 fw-bold text-uppercase">
                        Supplier Inquiry Quote
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
                            <tr
                                v-for="(row, index) in supplieData"
                                :key="index"
                            >
                                <td class="text-nowrap">
                                    {{ row.capacity }}
                                </td>
                                <td class="text-nowrap">
                                    {{ row.quantity }}
                                </td>
                                <td class="text-nowrap">USD</td>
                                <td
                                    class="text-nowrap"
                                    style="width: 13% !important"
                                >
                                    <input
                                        type="number"
                                        min="1"
                                        class="form-control"
                                        v-model="row.exw"
                                        placeholder="EXW"
                                    />
                                </td>
                                <td v-show="index === 0" :rowspan="totalRows">
                                    <textarea
                                        cols="30"
                                        class="form-control"
                                        :rows="totalRows"
                                        v-model="data.remarks"
                                        placeholder="Enter your comments or suggestions here..."
                                        style="
                                            font-size: 14px;
                                            padding: 5px;
                                            color: #333;
                                        "
                                    ></textarea>
                                </td>
                            </tr>
                            <!-- <template
                                v-for="(row, index) in exwData"
                                :key="index"
                            >
                                <tr>
                                    <td class="text-nowrap">
                                        {{ row.capacity }}
                                    </td>
                                    <td class="text-nowrap">
                                        {{ row.quantity }}
                                    </td>
                                    <td class="text-nowrap">USD</td>
                                    <td
                                        class="text-nowrap"
                                        style="width: 13% !important"
                                    >
                                        <input
                                            type="number"
                                            min="1"
                                            class="form-control"
                                            v-model="row.exw"
                                            placeholder="EXW"
                                        />
                                    </td>
                                    <td
                                        v-show="index === 0"
                                        :rowspan="totalRows"
                                    >
                                        <textarea
                                            cols="30"
                                            class="form-control"
                                            :rows="totalRows"
                                            v-model="data.remarks"
                                            placeholder="Enter your comments or suggestions here..."
                                            style="
                                                font-size: 14px;
                                                padding: 5px;
                                                color: #333;
                                            "
                                        ></textarea>
                                    </td>
                                </tr>
                            </template> -->
                        </tbody>
                    </table>
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
            groups: [],
            user: {},
            imageLoaded: false,
            supplier_profiles: [],
            data: {
                exw: [],
            },
            supplieData: {},
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
                    this.supplieData = response.data.inquirysuppliers;
                    this.loadImageFromPath(this.user.file, this.$refs.canvas);

                    if (this.user.file1 != null) {
                        this.loadImageFromPath(
                            this.user.file1,
                            this.$refs.canvas1
                        );
                    }
                    if (this.user.remarks != null) {
                        this.data.remarks = this.user.remarks.remarks
                    }

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
                const hasEmptyExw = this.supplieData.some((row) => {
                    // Trim whitespace from exw price
                    return row.exw.toString().trim() === "";
                });
                if (hasEmptyExw) {
                    // If any exw field is empty, show validation error
                    toastr.error("Please fill all EXW fields.");
                    NProgress.done();
                    return;
                }
                const formData = new FormData();

                // Append image file
                // console.log(this.$refs.fileInput1.files[0]);
                if (this.$refs.fileInput1.files[0] !== undefined) {
                    formData.append("image", this.$refs.fileInput1.files[0]);
                }
                // Append other form data
                formData.append("remarks", this.data.remarks);
                this.supplieData.forEach((item, index) => {
                    for (let key in item) {
                        formData.append(`price[${index}][${key}]`, item[key]);
                    }
                });

                console.log(formData);
                const inquiryid = this.$route.params.id;
                const responce = await axios.post(
                    "/api/supplier/update_price_inquiry/" + inquiryid,
                    formData
                );
                console.log(responce.data);

                if (responce.status === 201) {
                    toastr.success(responce.data.message);

                    this.$router.push({ name: "supplier_price_inquiry" });
                } else {
                    // Handle other status codes or unexpected responses
                    toastr.error("Unexpected response from the server");
                }
                NProgress.done();
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
    computed: {
        totalRows() {
            return this.user.capacity.length * this.user.pcs.length;
        },
    },
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
