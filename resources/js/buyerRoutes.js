import DefaultAdmin from "./pages/buyer/default.vue";

// Product
import product from "./pages/buyer/product/product.vue";
import productEdit from "./pages/buyer/product/product-edit.vue";

const buyerRoutes = [
    {
        path: "dashboard",
        name: "buyer",
        component: DefaultAdmin,
        // meta: { requiresAdmin: true },
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
];

export default buyerRoutes;
