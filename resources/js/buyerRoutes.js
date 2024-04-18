import DefaultAdmin from "./pages/buyer/default.vue";

// Product
import product from "./pages/buyer/product/product.vue";
import productEdit from "./pages/buyer/product/product-edit.vue";

// Price Inquiry
import price_inquiry from "./pages/buyer/price_inquiry/price_inquiry.vue";
import price_inquiry_entry from "./pages/buyer/price_inquiry/price_inquiry_entry.vue";

const buyerRoutes = [
    {
        path: "dashboard",
        name: "buyer",
        component: DefaultAdmin,
    },
    {
        path: "product",
        name: "buyer_product",
        component: product,
    },
    {
        path: "productEdit/:id",
        name: "buyer_productEdit",
        component: productEdit,
    },
    {
        path: "price_inquiry",
        name: "buyer_price_inquiry",
        component: price_inquiry,
    },
    {
        path: "price_inquiry_entry",
        name: "buyer_price_inquiry_entry",
        component: price_inquiry_entry,
    },
    {
        path: "price_inquiry_entry/:id",
        name: "buyer_price_inquiry_edit",
        component: price_inquiry_entry,
        props: {
            mode: "edit",
        },
    },
];

export default buyerRoutes;
