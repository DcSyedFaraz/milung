import DefaultAdmin from "./pages/admin/default.vue";
import User from "./pages/admin/user.vue";

const buyerRoutes = [
    {
        path: "dashboard",
        name: "admins1",
        component: DefaultAdmin,
        // meta: { requiresAdmin: true },
    },
    {
        path: "dashboard/1",
        name: "admins11",
        component: User,
        // meta: { requiresAdmin: true },
    },
];

export default buyerRoutes;
