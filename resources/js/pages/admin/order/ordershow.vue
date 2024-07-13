<template>
    <section class="section">
        <div class="container">
            <div class="row my-5">
                <h3 class="text-milung mb-4 fw-bold text-uppercase">Order Overview</h3>
                <div class="col-md-4">
                    <h4 class="text-milung mb-4 fw-bold ">I. Order Information</h4>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto ">Status:</p>
                        </div>
                        <div class="col-8">
                            <p class="fw-bold my-auto">{{ orders.status }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Milung Order No:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.milungorder }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Order Date:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.orderdate }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Buyer Order No:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.buyerorder }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Previous Order Reference:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.reference }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Related inquiry No:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.inquiry }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Buyer ID:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.buyerid?.buyer_id }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Buyer Email:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.buyeremail }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Supplier ID:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.supplierid?.supplier_id ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Fty item No:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.ftyitem }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4">
                            <p class="my-auto fs-7">Order Remarks:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.orderremarks }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4">
                            <p class="my-auto fs-7">QC Remarks:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.qcremarks }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="d-flex col-12 my-2 ">
                        <div class="col-8 my-auto">
                            <p for="v-model my-auto">Buyer Product Photo/Print View:</p>
                        </div>

                    </div>
                    <div class="d-flex col-12 my-2 ">
                        <div class="col-8 my-auto">
                            <canvas ref="canvas" width="353" height="300" class="border border-2"></canvas>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-3 my-auto">
                            <p class="my-auto fs-7">Quantity:</p>
                        </div>
                        <div class="col-9">
                            <p class="my-auto">{{ orders.quantity }} {{ orders.unit }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Article Number:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.article }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Product Group:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.product_group?.group_name }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Product Name:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.productname }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Product Color: (Pantone if applicable)</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.productcolor }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 mt-2">
                            <p class="fs-7">Product Capacity:</p>
                        </div>
                        <div class="col-8">
                            <div class="input-group my-2">
                                <p class="my-auto">
                                    {{ orders.capacity[0] }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Accessories:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.accessories }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Product Printing Method:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.printingmethod }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Logo Pantone Color:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.logocolor }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Packaging:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.packaging }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Packaging Printing: <br> (if applicable)</p>
                        </div>
                        <div class="col-8">
                            <p v-for="(printing, index) in orders.packagingprinting" :key="index">
                                {{ printing }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4 class="text-milung mb-4 fw-bold ">II. Price:</h4>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Buying Price:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.buyingprice }} USD</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Selling Price:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.sellingprice }} USD</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Total Order Value:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.totalvalue }} USD</p>
                        </div>
                    </div>
                    <h5 class="text-milung mb-4 fw-bold mt-3">III. Delivery/Shipping Information:</h5>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4">
                            <p class="fs-7">HS Code:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.product_group?.hs_de }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4">
                            <p class="fs-7">HS-CN Code:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.product_group?.hs_cn }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Latest SendOut Date:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.sendoutdate }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">Notice:</p>
                        </div>
                        <div class="col-8">
                            <p  class="my-auto" v-for="(notice, index) in orders.notice" :key="index">{{ notice }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">SO#:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.shipmentOrders?.so_number }}</p>
                        </div>
                    </div>
                    <div class="d-flex col-12 my-2">
                        <div class="col-4 my-auto">
                            <p class="my-auto fs-7">ATC#:</p>
                        </div>
                        <div class="col-8">
                            <p class="my-auto">{{ orders.atc_number }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';

export default {
    props: {
        orders: {
            type: Object,
            required: true,
        },
    },
    // computed: {
    //     selectedGroup() {
    //         return this.groups.find(group => group.id === this.orders.group);
    //     },
    //     selectedProductGroupCode() {
    //         const selectedGroup = this.selectedGroup;
    //         if (!selectedGroup) {
    //             return '';
    //         }
    //         return selectedGroup;
    //     },
    // },
    mounted() {
        if (this.orders.files?.[0]?.filepath) {
            this.loadImageFromPath(this.orders.files[0].filepath, this.$refs.canvas);
        }
        NProgress.configure({ showSpinner: false });
    },
    methods: {
        loadImageFromPath(imageFileName, canvas) {
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            const imageUrl = `/storage/${imageFileName}`;
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
        },
    },
}
</script>

<style>
@import url('./../style.css');

#main {
    padding: 20px 0px !important;
}

.multiselect {
    border: 1px solid #ced4da;
    border-radius: 0.25rem
}

.fs-7 {
    font-size: 14px !important;
}
</style>
