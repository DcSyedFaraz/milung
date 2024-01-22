import { createRouter, createWebHistory } from 'vue-router';
import login from './pages/login.vue';
import Dashbboard from './pages/dashboard.vue';
import supplier from './pages/supplier/dashboard.vue';
import buyer from './pages/buyer/dashboard.vue';
import store from './store';
// Admin
import DefaultAdmin from './pages/admin/default.vue';
import User from './pages/admin/user.vue';
import EditUser from './pages/admin/user-edit.vue';
import AddUser from './pages/admin/add-user.vue';


const routes = [

    {
        path: '/',
        name: 'login',
        component: login,
    },
    {
        path: '/admin',
        name: 'admin',
        component: Dashbboard,
        // meta: { requiresAdmin: true },
        children: [
            {
                path: 'dashboard',
                name: 'admins',
                component: DefaultAdmin,
                // meta: { requiresAdmin: true },
            },
            {
                path: 'user',
                name: 'user',
                component: User,
                // meta: { requiresAdmin: true },
            },
            {
                path: '/edit-user/:id',
                name: 'edit-user',
                component: EditUser,
                // meta: { requiresAdmin: true },
            },
            {
                path: 'add-user',
                name: 'add-user',
                component: AddUser,
                // meta: { requiresAdmin: true },
            },
        ],
        redirect: 'admin/dashboard'
    },
    {
        path: '/buyer',
        name: 'buyer',
        component: buyer,
        meta: { requiresBuyer: true },
        children: [
            {
                path: 'dashboard',
                name: 'admins1',
                component: DefaultAdmin,
                // meta: { requiresAdmin: true },
            },
            {
                path: 'dashboard/1',
                name: 'admins11',
                component: User,
                // meta: { requiresAdmin: true },
            },
        ],
        redirect: '/buyer/dashboard'
    },
    {
        path: '/supplier',
        name: 'supplier',
        component: supplier,
        meta: { requiresSupplier: true },
        children: [
            {
                path: 'dashboard',
                name: 'adminss',
                component: DefaultAdmin,
                // meta: { requiresAdmin: true },
            },
            {
                path: 'dashboard/1',
                name: 'admins1s',
                component: User,
                // meta: { requiresAdmin: true },
            },
        ],
        redirect: '/supplier/dashboard'
    },

]

const router = createRouter({
    history: createWebHistory(),
    routes
});

// Import the Toastr library


router.beforeEach((to, from, next) => {
    if (to.meta.requiresSupplier) {
        if (store.state.userRole === 'Supplier') {
            next(); // Allow access to the user route
        } else {
            toastr.error('Unauthorized access to Supplier route');
            next({ path: from.path, query: { unauthorized: true } });
        }
    }
    else if (to.meta.requiresAdmin) {
        if (store.state.userRole === 'Admin') {
            next(); // Allow access to the admin route
        } else {
            toastr.error('Unauthorized access to admin route');
            next({ path: from.path, query: { unauthorized: true } });
        }
    }
    else if (to.meta.requiresBuyer) {
        if (store.state.userRole === 'Buyer') {
            next(); // Allow access to the Buyer route
        } else {
            toastr.error('Unauthorized access to Buyer route');
            next({ path: from.path, query: { unauthorized: true } });
        }
    }
    else {
        next();
    }
});


export default router;
