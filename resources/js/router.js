import { createRouter, createWebHistory } from "vue-router";

import login from "./pages/login.vue";
import passChange from "./pages/passChange.vue";

import Dashbboard from "./pages/dashboard.vue";
import supplier from "./pages/supplier/dashboard.vue";
import buyer from "./pages/buyer/dashboard.vue";
import store from "./store";

// User Routes
import adminRoutes from "./adminRoutes";
import buyerRoutes from "./buyerRoutes";
import supplierRoutes from "./supplierRoutes";

// Notifications
import allnotifications from "./pages/notifications/allnotifications.vue";


const routes = [
    {
        path: "/",
        name: "login",
        component: login,
    },
    {
        path: "/change-password",
        name: "passChange",
        component: passChange,
    },
    {
        path: "/allnotifications",
        name: "allnotifications",
        component: allnotifications,
    },
    {
        path: "/admin",
        name: "admin",
        component: Dashbboard,
        meta: { requiresAuth: false, requiresAdmin: false },
        // meta: { requiresAdmin: true },
        children: adminRoutes,
        redirect: "admin/dashboard",
    },
    {
        path: "/buyer",
        name: "buyer",
        component: buyer,
        meta: { requiresAuth: true, requiresBuyer: true },
        // meta: { requiresBuyer: true },
        children: buyerRoutes,
        redirect: "/buyer/dashboard",
    },
    {
        path: "/supplier",
        name: "supplier",
        component: supplier,
        meta: { requiresAuth: true, requiresSupplier: true },
        // meta: { requiresSupplier: true },
        children: supplierRoutes,
        redirect: "/supplier/dashboard",
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});


router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters.isAuthenticated) {
            next({ name: 'login' });
        } else {
            toastr.error("Unauthorized access to route");
            next();
        }
    } else {
        next();
    }
});
// Import the Toastr library

router.beforeEach((to, from, next) => {
    if (to.meta.requiresSupplier) {
        if (store.state.userRole === "Supplier") {
            next(); // Allow access to the user route
        } else {
            toastr.error("Unauthorized access to Supplier route");
            next({ path: from.path, query: { unauthorized: true } });
        }
    } else if (to.meta.requiresAdmin) {
        if (store.state.userRole === "Admin") {
            next(); // Allow access to the admin route
        } else {
            toastr.error("Unauthorized access to admin route");
            next({ path: from.path, query: { unauthorized: true } });
        }
    } else if (to.meta.requiresBuyer) {
        if (store.state.userRole === "Buyer") {
            next(); // Allow access to the Buyer route
        } else {
            toastr.error("Unauthorized access to Buyer route");
            next({ path: from.path, query: { unauthorized: true } });
        }
    } else {
        next();
    }
});

export default router;
