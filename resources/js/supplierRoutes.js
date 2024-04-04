import DefaultAdmin from "./pages/admin/default.vue";

// Order
import order_list from "./pages/supplier/order/order_list.vue";
import order_entry from "./pages/supplier/order/order_entry.vue";
import supplier_order_price_inquiry from "./pages/supplier/order/order_price_inquiry.vue";

// Price Inquiry
import price_inquiry from "./pages/supplier/price_inquiry/price_inquiry.vue";
import price_inquiry_entry from "./pages/supplier/price_inquiry/price_inquiry_entry.vue";

// Shipment
import packinglist from "./pages/supplier/shipment/packinglist.vue";
import shipment_overview from "./pages/supplier/shipment/shipment_overview.vue";

const supplierRoutes = [
    {
        path: "dashboard",
        name: "supplierdash",
        component: DefaultAdmin,
    },
    {
        path: "order_price_inquiry",
        name: "supplier_order_price_inquiry",
        component: supplier_order_price_inquiry,
    },
    {
        path: "packinglist",
        name: "packinglist",
        component: packinglist,
    },
    {
        path: "shipment_overview",
        name: "supplier_shipment_overview",
        component: shipment_overview,
    },
    {
        path: "order_list",
        name: "supplier_order_list",
        component: order_list,
    },
    {
        path: "edit-order/:id",
        name: "supplier_order_edit",
        component: order_entry,
        // meta: { requiresAdmin: true },
        props: {
            isEditing: true,
        },
    },
    {
        path: "price_inquiry",
        name: "supplier_price_inquiry",
        component: price_inquiry,
    },
    {
        path: "price_inquiry_entry/:id",
        name: "supplier_price_inquiry_entry",
        component: price_inquiry_entry,
    },
];

export default supplierRoutes;
