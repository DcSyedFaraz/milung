<template>
    <section class="section">
        <div class="container">
            <div class="row my-5">
                <h3 class="text-milung mb-4 fw-bold text-uppercase">Price Inquiry</h3>
                <div class="col-md-6">
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Buyer ID:</p>
                        </div>
                        <div class="col-8">
                            <p>{{ inquiry.buyer }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Inquiry Number:</p>
                        </div>
                        <div class="col-8">
                            <p>{{ inquiry.inquiry_number }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Article Number:</p>
                        </div>
                        <div class="col-8">
                            <p>{{ inquiry.article }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Product Group:</p>
                        </div>
                        <div class="col-8">
                            <p>{{ inquiry.group_name }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Product Name:</p>
                        </div>
                        <div class="col-8">
                            <p>{{ inquiry.name }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Product Description/ Specification:</p>
                        </div>
                        <div class="col-8">
                            <p>{{ inquiry.description }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Cargo Classification:</p>
                        </div>
                        <div class="col-8">
                            <p>{{ inquiry.cargo }}</p>
                            <p v-if="cargo_place.includes('hongkong')">Hong Kong</p>
                            <p v-if="cargo_place.includes('china')">Mainland China</p>
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Incoterm:</p>
                        </div>
                        <div class="col-8">
                            <p>{{ inquiry.incoterm }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Inquiry Quantity:</p>
                        </div>
                        <div class="col-8">
                            <p v-for="(material, index) in materials" :key="index">{{ material.quantity }} Pcs</p>
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Product Capacity:</p>
                        </div>
                        <div class="col-8">
                            <p v-for="(caps, index) in capacity" :key="index">{{ caps.quantity }} {{ caps.unit }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Printing Method:</p>
                        </div>
                        <div class="col-8">
                            <p>{{ inquiry.method }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Printing Color:</p>
                        </div>
                        <div class="col-8">
                            <p>{{ inquiry.color }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Standard Packaging:</p>
                        </div>
                        <div class="col-8">
                            <p>{{ inquiry.packaging }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Special Requirement:</p>
                        </div>
                        <div class="col-8">
                            <p>{{ inquiry.requirements }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Status:</p>
                        </div>
                        <div class="col-8">
                            <p>{{ inquiry.status }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Notice:</p>
                        </div>
                        <div class="col-8">
                            <p>{{ inquiry.urgent ? 'Urgent' : 'Not Urgent' }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Buyer Product Photo/3D Artwork:</p>
                        </div>
                        <div class="col-8">
                            <canvas ref="canvas" width="322" height="300" class="border border-2"></canvas>
                        </div>
                    </div>
                    <div class="d-flex col-11 my-2">
                        <div class="col-4">
                            <p>Supplier Product Photo/3D Artwork:</p>
                        </div>
                        <div class="col-8">
                            <canvas ref="canvas1" width="322" height="300" class="border border-2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-for="(rows, index) in supplierData" :key="index"
                v-if="supplierData && Object.keys(supplierData).length > 0">
                <h3 class="text-milung mb-4 fw-bold text-uppercase">{{ index }} Inquiry Quote</h3>
                <table class="table table-striped table-hover">
                    <thead style="color: #009de1" class="text-center">
                        <tr>
                            <th class="text-nowrap">Product Capacity</th>
                            <th class="text-nowrap">Quantity</th>
                            <th class="text-nowrap">Currency</th>
                            <th class="text-nowrap">EXW Price</th>
                            <th class="text-nowrap">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr v-for="(row, indexs) in rows" :key="indexs">
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
                            <td v-show="indexs === 0" :rowspan="totalRows">
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
        </div>
    </section>
</template>

<script>
export default {
    props: {
        inquiry: {
            type: Object,
            required: true
        },
        cargo_place: {
            type: Array,
            required: true
        },
        materials: {
            type: Array,
            required: true
        },
        capacity: {
            type: Array,
            required: true
        },
        supplierData: {
            type: Object,
            required: true
        }
    },
    mounted() {
        this.loadImageFromPath(this.inquiry.file, this.$refs.canvas);
        this.loadImageFromPath(this.inquiry.file1, this.$refs.canvas1);
    },
    computed: {
        totalRows() {
            return this.inquiry.capacity.length * this.inquiry.pcs.length;
        },
    },
    methods: {
        loadImageFromPath(imageFileName, canvas) {
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas context

            const imageUrl = `/storage/files/${imageFileName}`;

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
            img.src = imageUrl;
        }
    }
}
</script>
