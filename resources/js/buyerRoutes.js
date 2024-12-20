import DefaultAdmin from "./pages/admin/default.vue";

// Product
import product from "./pages/buyer/product/product.vue";
import productEdit from "./pages/buyer/product/product-edit.vue";

// Price Inquiry
import price_inquiry from "./pages/buyer/price_inquiry/price_inquiry.vue";
import price_inquiry_entry from "./pages/buyer/price_inquiry/price_inquiry_entry.vue";

// Order
import order_list from "./pages/buyer/order/order_list.vue";
import order_entry from "./pages/buyer/order/order_entry.vue";
import order_create from "./pages/buyer/order/order_create.vue";

// Shipment
import shipment_overview from "./pages/buyer/shipment/shipment_overview.vue";
import information from "./pages/buyer/shipment/documents/information.vue";
import cibd from "./pages/buyer/shipment/documents/cibd.vue";
import ci from "./pages/buyer/shipment/documents/ci.vue";

// Accounts
import payable from "./pages/buyer/account/payable.vue";

// Notifications
import allnotifications from "./pages/notifications/allnotifications.vue";

// Profile
import profile from "./pages/profile.vue";

const buyerRoutes = [
    {
        path: "dashboard",
        name: "buyer",
        component: DefaultAdmin,
    },
    {
        path: "profile",
        name: "buyerprofile",
        component: profile,
    },
    {
        path: "allnotifications",
        name: "buyerAllNotifications",
        component: allnotifications,
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
    {
        path: "order_list",
        name: "buyer_order_list",
        component: order_list,
    },
    {
        path: "order_create",
        name: "buyer_order_create",
        component: order_create,
    },
    {
        path: "order_entry/:id",
        name: "buyer_order_entry",
        component: order_entry,
        props: {
            isEditing: true,
        },
    },
    {
        path: "shipment_overview",
        name: "buyer_shipment_overview",
        component: shipment_overview,
    },
    {
        path: "information/:id/:so_number",
        name: "buyer_information",
        component: information,
    },
    {
        path: "documents/cibd/:id/:so_number",
        name: "buyer_cibd",
        component: cibd,
    },
    {
        path: "documents/ci/:id/:so_number",
        name: "buyer_ci",
        component: ci,
    },
    {
        path: "accounts/payable",
        name: "buyer_payable",
        component: payable,
    },
];

export default buyerRoutes;
