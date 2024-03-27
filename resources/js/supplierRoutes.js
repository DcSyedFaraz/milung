import DefaultAdmin from "./pages/admin/default.vue";
import supplier_order_price_inquiry from "./pages/supplier/order/order_price_inquiry.vue";
import packinglist from "./pages/supplier/shipment/packinglist.vue";

import price_inquiry from "./pages/supplier/price_inquiry/price_inquiry.vue";
import price_inquiry_entry from "./pages/supplier/price_inquiry/price_inquiry_entry.vue";

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
    {
        path: "price_inquiry",
        name: "supplier_price_inquiry",
        component: price_inquiry,
        // meta: { requiresAdmin: true },
    },
    {
        path: "price_inquiry_entry",
        name: "supplier_price_inquiry_entry",
        component: price_inquiry_entry,
        // meta: { requiresAdmin: true },
    },
];

export default supplierRoutes;
