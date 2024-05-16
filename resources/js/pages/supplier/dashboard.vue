<template>

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
                <p>Welcome Back, Lets get back to Win</p>
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
                            <img src="./../../../assets/img/profile-img.jpg" alt="Profile" class="rounded-circle" />
                            <span class="d-none d-md-block  ps-2"><span class="fs-8" style="font-size: 10px;">User
                                    ID: {{ userDetails.userid }}</span> <br> {{ userDetails.name }}</span>
                        </a>

                    </li>
                    <notifications />

                    <li class="nav-item">
                        <router-link class="nav-link nav-icon" :to="{ name: 'supplierprofile' }">
                            <i class="bi bi-gear"></i>
                            <!-- <i class="bi bi-door-open text-warning"></i> -->
                        </router-link>
                    </li>

                    <!-- End Profile Nav -->
                    <li class="nav-item">
                        <a class="nav-link nav-icon" href="#" @click="logout">
                            <i class="bi bi-door-open text-warning"></i>
                        </a>
                    </li>
                    <!-- End Messages Nav -->
                </ul>
            </nav>
            <!-- End Icons Navigation -->
        </header>
        <!-- End Header -->

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar" :key="componentKey">
            <div class="logo-img"><img src="../../../../public/imgs/logo-1.png" /></div>
            <ul class="sidebar-nav" id="sidebar-nav">
                <li class="nav-item">
                    <router-link class="nav-link" :to="{ name: 'supplierdash' }">
                        <i class="bi bi-pie-chart"></i>
                        <span>Summary</span>
                    </router-link>
                </li>
                <!-- End Dashboard Nav -->

                <!-- End Components Nav -->

                <!-- <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-database"></i><span>Database</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="forms-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="forms-elements.html">
                                <i class="bi bi-circle"></i><span>Form Elements</span>
                            </a>
                        </li>
                        <li>
                            <a href="forms-layouts.html">
                                <i class="bi bi-circle"></i><span>Form Layouts</span>
                            </a>
                        </li>
                        <li>
                            <a href="forms-editors.html">
                                <i class="bi bi-circle"></i><span>Form Editors</span>
                            </a>
                        </li>
                        <li>
                            <a href="forms-validation.html">
                                <i class="bi bi-circle"></i><span>Form Validation</span>
                            </a>
                        </li>
                    </ul>
                </li> -->
                <!-- End Forms Nav -->
                <li class="nav-item" v-if="can('priceInquiry')">
                    <router-link class="nav-link" :to="{ name: 'supplier_price_inquiry' }"
                        :class="{ active: this.$route.name === 'supplier_price_inquiry_entry' }" active-class="active">
                        <i class="bi bi-currency-exchange"></i><span>Price Inquiry</span>
                    </router-link>
                </li>
                <!-- End Tables Nav -->

                <li class="nav-item" v-if="can('supplierOrderPriceQuote | supplierOrderConfirmationNotification')">

                    <a class="nav-link collapsed" :class="{ 'active': isAnyOrderRouteActive() }"
                        data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-bag"></i><span>Order</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="charts-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav"
                        :class="{ 'show': isAnyOrderRouteActive() }">
                        <li>
                            <router-link class="nav-link" :to="{ name: 'supplier_order_list' }"
                                v-if="can('supplierOrderConfirmationNotification | uploadPrintview | uploadMassCargoPhoto | cargoReadyConfirmation')"
                                :class="{ active: $route.name === 'order_entry' || $route.name === 'supplier_order_edit' }"
                                active-class="active">
                                <i class="bi bi-bag"></i><span>Order</span>
                            </router-link>
                            <router-link class="nav-link" :to="{ name: 'supplier_order_price_inquiry' }"
                                v-if="can('supplierOrderPriceQuote')"
                                :class="{ active: $route.name === 'supplier_order_price_inquiry' }"
                                active-class="active">
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
                            <router-link class="nav-link" :to="{ name: 'supplier_shipment_overview' }"
                                :class="{ active: $route.name === 'packinglist' || $route.name === 'supplier_receiptnote' }"
                                active-class="active">
                                <i class="bi bi-bag"></i><span>Shipment Overview</span>
                            </router-link>
                        </li>

                    </ul>
                </li>
                <!-- End Icons Nav -->
                <li class="nav-item" v-if="can('supplierAccountsReceivable')">

                    <router-link class="nav-link" :to="{ name: 'supplier_recievables' }" active-class="active">
                        <i class="bi bi-cash-coin"></i><span>Finance</span>
                    </router-link>
                </li>
                <!-- End Profile Page Nav -->

            </ul>
        </aside>
        <!-- End Sidebar-->

        <main id="main" class="main">
            <!-- End Page Title -->

            <router-view @profile-updated="userDetail"></router-view>
        </main>
        <!-- End #main -->

        <!-- ======= Footer ======= -->
        <footer id="footer" class="footer">
            <div class="copyright">
                &copy; Copyright <strong><span>OderFlow</span></strong>. All Rights Reserved
            </div>
        </footer>
        <!-- End Footer -->

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

    </body>
</template>

<script>
import './../admin/index';
export default {
    data() {
        return {
            componentKey: 0,
            userDetails: {},
        }
    },
    mounted() {
        this.remountComponent();
        this.userDetail();
    },
    methods: {
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
                    this.componentKey++;
                });
            }, 2000);
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
                    this.componentKey++;
                });
            }, 2000);
        },
        isAnyChildRouteActive() {
            const activeRoutes = [
                '/buyer/dashboard',
                '/buyer/dashboard/1',
            ];

            return this.$route.matched.some(route => activeRoutes.includes(route.path));

        },
        isAnyShipmentRouteActive() {
            const activeRoutes = [
                '/supplier/packinglist',
                '/supplier/shipment_overview',
                '/supplier/receiptnote/:data*/:soNumbers',
            ];

            return this.$route.matched.some(route => activeRoutes.includes(route.path));

        },
        isAnyOrderRouteActive() {
            const activeRoutes = [
                '/supplier/order_list',
                '/supplier/order_entry',
                '/supplier/edit-order/:id',
                '/supplier/order_price_inquiry',
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
@import './../admin/style.css';
</style>
