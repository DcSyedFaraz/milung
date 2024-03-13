import DefaultAdmin from "./pages/admin/default.vue";
import supplier_order_price_inquiry from "./pages/supplier/order/order_price_inquiry.vue";

const supplierRoutes = [
    {
        path: "dashboard",
        name: "supplierdash",
        component: DefaultAdmin,
        meta: { requiresAdmin: true },
    },
    {
        path: "order_price_inquiry",
        name: "supplier_order_price_inquiry",
        component: supplier_order_price_inquiry,
        meta: { requiresSupplier: true },
    },
];

export default supplierRoutes;
