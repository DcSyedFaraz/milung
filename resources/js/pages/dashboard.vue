<template>
    <!-- <div>
        <h1>Admin</h1>
        <button >Logout</button>
    </div> -->

    <body>
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top d-flex align-items-center">
            <div class="d-flex align-items-center justify-content-between">
                <a href="" class="logo d-flex align-items-center">
                    <img src="" alt="" />
                </a>
            </div>
            <!-- End Logo -->
            <div class="heading-name">
                <h2>Milung User Dashboard</h2>
                <!-- <p>Welcome Back, Lets get back to Win</p> -->
                <!-- <button type="button" @click="remountComponent">click</button> -->
            </div>

            <div class="search-bar">
                <i class="bi bi-search"></i>
                <form class="search-form d-flex align-items-center" method="POST" action="#">
                    <input type="text" name="query" placeholder="Live Search" title="Enter search keyword" />
                    <button type="submit" title="Search">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </form>
            </div>
            <!-- End Search Bar -->

            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">
                    <li class="nav-item d-block d-lg-none">
                        <a class="nav-link nav-icon search-bar-toggle" href="#">
                            <i class="bi bi-search"></i>
                        </a>
                    </li>
                    <!-- End Search Icon-->

                    <li class="nav-item  ">
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#">
                            <!-- <img src="./../../assets/img/profile-img.jpg" alt="Profile" class="rounded-circle" /> -->
                            <span class="d-none d-md-block  ps-2"><span class="fs-8" style="font-size: 10px;">User
                                    ID: {{ userDetails.userid }}</span> <br> {{ userDetails.name }}</span>
                        </a>

                    </li>
                    <!-- End Profile Nav -->

                    <notifications />
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-bell"></i>
                            <span class="badge badge-number">4</span> </a>

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications"
                           >
                            <li class="dropdown-header">
                                You have 4 new notifications
                                <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li class="notification-item">
                                <i class="bi bi-exclamation-circle text-warning"></i>
                                <div>
                                    <h4>Lorem Ipsum</h4>
                                    <p>Quae dolorem earum veritatis oditseno</p>
                                    <p>30 min. ago</p>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>


                            <li class="dropdown-footer">
                                <a href="#">Show all notifications</a>
                            </li>
                        </ul>
                    </li> -->
                    <!-- End Notification Dropdown Items -->
                    <!-- End Notification Nav -->

                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-chat-left-text"></i>
                            <span class="badge badge-number">3</span> </a>

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages"
                           >
                            <li class="dropdown-header">
                                You have 3 new messages
                                <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li class="message-item">
                                <a href="#">
                                    <img src="./../../assets/img/messages-1.jpg" alt="" class="rounded-circle" />
                                    <div>
                                        <h4>Maria Hudson</h4>
                                        <p>
                                            Velit asperiores et ducimus soluta repudiandae labore
                                            officia est ut...
                                        </p>
                                        <p>4 hrs. ago</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li class="message-item">
                                <a href="#">
                                    <img src="./../../assets/img/messages-2.jpg" alt="" class="rounded-circle" />
                                    <div>
                                        <h4>Anna Nelson</h4>
                                        <p>
                                            Velit asperiores et ducimus soluta repudiandae labore
                                            officia est ut...
                                        </p>
                                        <p>6 hrs. ago</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li class="message-item">
                                <a href="#">
                                    <img src="./../../assets/img/messages-3.jpg" alt="" class="rounded-circle" />
                                    <div>
                                        <h4>David Muldon</h4>
                                        <p>
                                            Velit asperiores et ducimus soluta repudiandae labore
                                            officia est ut...
                                        </p>
                                        <p>8 hrs. ago</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li class="dropdown-footer">
                                <a href="#">Show all messages</a>
                            </li>
                        </ul>
                    </li> -->
                    <!-- End Messages Nav -->
                    <li class="nav-item">
                        <router-link class="nav-link nav-icon me-0 pe-0" :to="{ name: 'adminprofile' }">
                            <i class="bi bi-gear"></i>
                            <!-- <i class="bi bi-door-open text-warning"></i> -->
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-icon" href="#" @click="logout">
                            <i class="bi bi-door-open text-warning"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- End Icons Navigation -->
        </header>
        <!-- End Header -->

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar" :key="componentsKey">
            <div class="logo-img"><img src="../../../public/imgs/logo-1.png" /></div>
            <ul class="sidebar-nav" id="sidebar-nav">

                <li class="nav-item" v-if="is('Admin')">
                    <router-link class="nav-link" :to="{ name: 'admins' }" active-class="active">
                        <i class="bi bi-pie-chart"></i>
                        <span>Dashboard</span>
                    </router-link>
                </li>
                <!-- End Dashboard Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" :class="{ 'active': isAnyChildRouteActive() }"
                        v-if="can('issueNewLoginIdPassword | setAccessAuthority | userManagement')"
                        data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-person-gear"></i><span>Admin</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav"
                        :class="{ 'show': isAnyChildRouteActive() }">
                        <li>
                            <router-link :to="{ name: 'user' }" active-class="active">
                                <i class="bi bi-circle"></i><span>User</span>
                            </router-link>
                        </li>
                        <!-- <li>
                            <router-link :to="{ name: 'admins1' }" active-class="active">
                                <i class="bi bi-circle"></i><span>Modal1</span>
                            </router-link>
                        </li> -->

                    </ul>
                </li>
                <!-- End Components Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" :class="{ 'active': isAnyDataRouteActive() }"
                        data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-database"></i><span>Database</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="forms-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav"
                        :class="{ 'show': isAnyDataRouteActive() }">
                        <li>
                            <router-link :to="{ name: 'Datasupplier' }"
                                v-if="can('addNewSupplierEntry | editSupplierEntry | setEditSupplierIDCode')"
                                :class="{ active: this.$route.name === 'supplerEntry' || this.$route.name === 'editsupplier' }"
                                active-class="active">
                                <i class="bi bi-circle"></i><span>Supplier</span>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'Databuyer' }" v-if="can('editBuyerEntry | addNewBuyerEntry')"
                                :class="{ active: this.$route.name === 'buyerEntry' || this.$route.name === 'editbuyer' }"
                                active-class="active">
                                <i class="bi bi-circle"></i><span>Buyer</span>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'product' }"
                                v-if="can('addProductEntry | editProductEntry | accessImportExportCertificateTestingReport')"
                                :class="{ active: this.$route.name === 'productEntry' || this.$route.name === 'adminproductEdit' }"
                                active-class="active">
                                <i class="bi bi-circle"></i><span>Product</span>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'product_group' }" v-if="can('createProductGroup')"
                                :class="{ active: this.$route.name === 'product_group_update' || this.$route.name === 'product_group_entry' }"
                                active-class="active">
                                <i class="bi bi-circle"></i><span>Product Group</span>
                            </router-link>
                        </li>

                    </ul>
                </li>
                <!-- End Forms Nav -->

                <li class="nav-item">
                    <router-link class="nav-link" :to="{ name: 'price_inquiry' }" v-if="can('createPriceInquiry')"
                        :class="{ active: this.$route.name === 'price_inquiry_entry' || this.$route.name === 'price_inquiry_edit' }"
                        active-class="active">
                        <i class="bi bi-currency-exchange"></i><span>Price Inquiry</span>
                    </router-link>
                </li>
                <!-- End Tables Nav -->

                <li class="nav-item">

                    <a class="nav-link collapsed" :class="{ 'active': isAnyOrderRouteActive() }"
                        data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-bag"></i><span>Order</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="charts-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav"
                        :class="{ 'show': isAnyOrderRouteActive() }">
                        <li>
                            <router-link class="nav-link" :to="{ name: 'order_list' }"
                                v-if="can('orderGeneralSinglePage')"
                                :class="{ active: $route.name === 'order_entry' || $route.name === 'order_edit' }"
                                active-class="active">
                                <i class="bi bi-bag"></i><span>Order</span>
                            </router-link>
                            <router-link class="nav-link" :to="{ name: 'order_price_inquiry' }"
                                v-if="can('miLungOrderPriceEnquiry')"
                                :class="{ active: $route.name === 'order_price_inquiry' }" active-class="active">
                                <i class="bi bi-bag"></i><span>Order Price Inquiry</span>
                            </router-link>
                        </li>

                    </ul>
                </li>
                <!-- Shipment -->

                <li class="nav-item" v-if="can('shipmentOverview')">
                    <a class="nav-link collapsed" :class="{ 'active': isAnyShipmentRouteActive() }"
                        data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-box2"></i><span>Shipment</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="icons-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav"
                        :class="{ 'show': isAnyShipmentRouteActive() }">
                        <li>
                            <router-link class="nav-link" :to="{ name: 'shipment_overview' }"
                                :class="{ active: $route.name === 'information' || $route.name === 'create_so' }"
                                active-class="active">
                                <i class="bi bi-bag"></i><span>Shipment Overview</span>
                            </router-link>
                        </li>

                    </ul>
                </li>
                <!-- End Icons Nav -->
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#Finance" data-bs-toggle="collapse" href="#"
                        :class="{ active: this.$route.name === 'Transaction' || this.$route.name === 'receivable' || this.$route.name === 'payable' || this.$route.name === 'invoice_admin' }">
                        <i class="bi bi-cash-coin"></i>
                        <span>Finance</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="Finance" class="nav-content collapse" data-bs-parent="#sidebar-nav"
                        :class="{ show: this.$route.name === 'Transaction' || this.$route.name === 'receivable' || this.$route.name === 'payable' || this.$route.name === 'invoice_admin' }">
                        <li>
                            <router-link :to="{ name: 'Transaction' }" active-class="active"
                                v-if="can('transactionOverview')">
                                <i class="bi bi-circle"></i><span>Transaction</span>
                            </router-link>
                            <router-link :to="{ name: 'receivable' }" active-class="active"
                                v-if="can('accountReceivable')">
                                <i class="bi bi-circle"></i><span>Accounts Receivable</span>
                            </router-link>
                            <router-link :to="{ name: 'payable' }" active-class="active" v-if="can('accountPayable')"
                                :class="{ active: this.$route.name === 'invoice_admin' }">
                                <i class="bi bi-circle"></i><span>Accounts Payable</span>
                            </router-link>
                        </li>

                    </ul>
                </li>
                <!-- End Profile Page Nav -->

                <li class="nav-item" v-if="can('orderGeneralSinglePage')">
                    <router-link :to="{ name: 'statistics' }" active-class="active" class="nav-link collapsed">
                        <i class="bi bi-bar-chart-line"></i><span>Statistics</span>
                    </router-link>

                </li>

                <!-- End Login Page Nav -->
            </ul>
        </aside>
        <!-- End Sidebar-->

        <main id="main" class="main" style="min-height: 100vh; ">
            <!-- End Page Title -->

            <router-view @profile-updated="userDetail"></router-view>
        </main>
        <!-- End #main -->

        <!-- ======= Footer ======= -->
        <footer id="footer" class="footer">
            <div class="copyright">
                &copy; Copyright <strong><span>OrderFlow</span></strong>. All Rights Reserved
            </div>
        </footer>
        <!-- End Footer -->

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

    </body>
</template>

<script>
// import '';
import './admin/index';

export default {
    data() {
        return {
            componentsKey: 0,
            userDetails: {},
        }
    },
    mounted() {
        this.remountComponent();
        this.userDetail();

    },
    methods: {

        isAnyChildRouteActive() {
            const activeRoutes = [
                '/admin/user',
                '/admin/add-user',
            ];

            return this.$route.matched.some(route => activeRoutes.includes(route.path));

        },
        remountComponent() {
            axios.get('/api/get-permissions', {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`
                }
            }).then(response => {
                window.Laravel.jsPermissions = response.data;
                console.log(response.data);
            }).catch(error => {
                console.error('Error fetching permissions:', error);
            });
            setTimeout(() => {
                this.$nextTick(() => {
                    // console.log('load');
                    this.componentsKey++;
                });
            }, 2000);
        },
        userDetail() {
            axios.get('/api/userDetails').then(response => {
                this.userDetails = response.data;
                console.log('det ', this.userDetails);
            }).catch(error => {
                console.error('Error fetching permissions:', error);
            });
            setTimeout(() => {
                this.$nextTick(() => {
                    // console.log('load');
                    this.componentsKey++;
                });
            }, 2000);
        },
        isAnyOrderRouteActive() {
            const activeRoutes = [
                '/admin/order_list',
                '/admin/order_entry',
                '/admin/edit-order/:id',
                '/admin/order_price_inquiry',
            ];

            return this.$route.matched.some(route => activeRoutes.includes(route.path));

        },
        isAnyShipmentRouteActive() {
            const activeRoutes = [
                '/admin/create_so',
                '/admin/shipment_overview',
                '/admin/information/:id/:so_number',
                '/admin/documents/cibd/:id/:so_number',
                '/admin/documents/ci/:id/:so_number',

            ];

            return this.$route.matched.some(route => activeRoutes.includes(route.path));

        },
        isAnyDataRouteActive() {
            const activeRoutes = [
                '/admin/Datasupplier',
                '/admin/Databuyer',
                '/admin/buyerEntry',
                '/admin/supplerEntry',
                '/admin/product',
                '/admin/productEntry',
                '/admin/product_group',
                '/admin/product_group_entry',
                '/admin/product-group-edit/:id',
                '/admin/Databuyer/:id',
                '/admin/Datasupplier/:id',
                '/admin/productEdit/:id',
                '/edit-user/:id',
            ];

            return this.$route.matched.some(route => activeRoutes.includes(route.path));

        },
        logout() {
            // Dispatch the logout action from Vuex store
            this.$store.dispatch('logout');

            // Redirect the user to the login page or another route
            this.$router.push({ name: 'login' });
        },
    },
};
</script>

<style scoped>
@import './admin/style.css';

/* Add component-specific styles here */
</style>
