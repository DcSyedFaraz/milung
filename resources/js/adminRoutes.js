import DefaultAdmin from "./pages/admin/default.vue";

import User from "./pages/admin/user.vue";
import EditUser from "./pages/admin/user-edit.vue";
import AddUser from "./pages/admin/users/add-user.vue";
import Datasupplier from "./pages/admin/supplier.vue";
import Databuyer from "./pages/admin/buyer.vue";
import buyerEntry from "./pages/admin/buyer-entry.vue";
import supplerEntry from "./pages/admin/supplier-entry.vue";
import product from "./pages/admin/product.vue";
import productEntry from "./pages/admin/product-entry.vue";

import Transaction from "./pages/admin/transaction/transaction.vue";

import product_group from "./pages/admin/product_group/product_group.vue";
import product_group_entry from "./pages/admin/product_group/product_group_entry.vue";

import price_inquiry from "./pages/admin/price_inquiry/price_inquiry.vue";
import price_inquiry_entry from "./pages/admin/price_inquiry/price_inquiry_entry.vue";

import order_list from "./pages/admin/order/order_list.vue";
import order_entry from "./pages/admin/order/order_entry.vue";
import order_price_inquiry from "./pages/admin/order/order_price_inquiry.vue";

import shipment_overview from "./pages/admin/shipment/shipment_overview.vue";
import create_so from "./pages/admin/shipment/create_so.vue";
import information from "./pages/admin/shipment/documents/information.vue";
import cibd from "./pages/admin/shipment/documents/cibd.vue";
import ci from "./pages/admin/shipment/documents/ci.vue";

// Accounts
import payable from "./pages/admin/account/payable.vue";
import receivable from "./pages/admin/account/receivable.vue";

// Statistics
import statistics from "./pages/admin/statistics/statistics.vue";

// Notifications
import allnotifications from "./pages/notifications/allnotifications.vue";

const adminRoutes = [
    {
        path: "dashboard",
        name: "admins",
        component: DefaultAdmin,
    },
    {
        path: "allnotifications",
        name: "adminAllNotifications",
        component: allnotifications,
    },
    {
        path: "user",
        name: "user",
        component: User,
    },
    {
        path: "/edit-user/:id",
        name: "edit-user",
        component: EditUser,
    },
    {
        path: "add-user",
        name: "add-user",
        component: AddUser,
    },
    {
        path: "Datasupplier",
        name: "Datasupplier",
        component: Datasupplier,
    },
    {
        path: "Databuyer",
        name: "Databuyer",
        component: Databuyer,
    },
    {
        path: "buyerEntry",
        name: "buyerEntry",
        component: buyerEntry,
    },
    {
        path: "supplerEntry",
        name: "supplerEntry",
        component: supplerEntry,
    },
    {
        path: "product",
        name: "product",
        component: product,
    },
    {
        path: "productEntry",
        name: "productEntry",
        component: productEntry,
    },
    {
        path: "Transaction",
        name: "Transaction",
        component: Transaction,
    },
    {
        path: "product_group",
        name: "product_group",
        component: product_group,
    },
    {
        path: "product_group_entry",
        name: "product_group_entry",
        component: product_group_entry,
    },
    {
        path: "price_inquiry",
        name: "price_inquiry",
        component: price_inquiry,
    },
    {
        path: "price_inquiry_entry",
        name: "price_inquiry_entry",
        component: price_inquiry_entry,
    },
    {
        path: "price_inquiry_entry/:id",
        name: "price_inquiry_edit",
        component: price_inquiry_entry,
        props: {
            mode: "edit",
        },
    },
    {
        path: "order_list",
        name: "order_list",
        component: order_list,
    },
    {
        path: "/edit-order/:id",
        name: "order_edit",
        component: order_entry,
        props: {
            isEditing: true,
        },
    },
    {
        path: "order_entry",
        name: "order_entry",
        component: order_entry,
    },
    {
        path: "order_price_inquiry",
        name: "order_price_inquiry",
        component: order_price_inquiry,
    },
    {
        path: "shipment_overview",
        name: "shipment_overview",
        component: shipment_overview,
    },
    {
        path: "create_so",
        name: "create_so",
        component: create_so,
    },
    {
        path: "information/:id/:so_number",
        name: "information",
        component: information,
    },
    {
        path: "documents/cibd/:id/:so_number",
        name: "cibd",
        component: cibd,
    },
    {
        path: "documents/ci/:id/:so_number",
        name: "ci",
        component: ci,
    },
    {
        path: "accounts/payable",
        name: "payable",
        component: payable,
    },
    {
        path: "accounts/receivable",
        name: "receivable",
        component: receivable,
    },
    {
        path: "statistics",
        name: "statistics",
        component: statistics,
    },
];

export default adminRoutes;
