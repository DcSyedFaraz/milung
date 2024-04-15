import { createRouter, createWebHistory } from "vue-router";
import login from "./pages/login.vue";
import Dashbboard from "./pages/dashboard.vue";
import supplier from "./pages/supplier/dashboard.vue";
import buyer from "./pages/buyer/dashboard.vue";
import store from "./store";

// User Routes
import adminRoutes from "./adminRoutes";
import buyerRoutes from "./buyerRoutes";
import supplierRoutes from "./supplierRoutes";

const routes = [
    {
        path: "/",
        name: "login",
        component: login,
    },
    {
        path: "/admin",
        name: "admin",
        component: Dashbboard,
        // meta: { requiresAdmin: true },
        children: adminRoutes,
        redirect: "admin/dashboard",
    },
    {
        path: "/buyer",
        name: "buyer",
        component: buyer,
        // meta: { requiresBuyer: true },
        children: buyerRoutes,
        redirect: "/buyer/dashboard",
    },
    {
        path: "/supplier",
        name: "supplier",
        component: supplier,
        // meta: { requiresSupplier: true },
        children: supplierRoutes,
        redirect: "/supplier/dashboard",
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
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
