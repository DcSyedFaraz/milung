import DefaultAdmin from "./pages/admin/default.vue";
import supplier_order_price_inquiry from "./pages/supplier/order/order_price_inquiry.vue";
import packinglist from "./pages/supplier/shipment/packinglist.vue";

const supplierRoutes = [
    {
        path: "dashboard",
        name: "supplierdash",
        component: DefaultAdmin,
        // meta: { requiresSupplier: true },
    },
    {
        path: "order_price_inquiry",
        name: "supplier_order_price_inquiry",
        component: supplier_order_price_inquiry,
        // meta: { requiresSupplier: true },
    },
    {
        path: "packinglist",
        name: "packinglist",
        component: packinglist,
        // meta: { requiresSupplier: true },
    },
];

export default supplierRoutes;
