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
                    <!-- End Profile Nav -->
                    <notifications />

                    <li class="nav-item">
                        <router-link class="nav-link nav-icon me-0 pe-0" :to="{ name: 'buyerprofile' }">
                            <i class="bi bi-gear"></i>
                            <!-- <i class="bi bi-door-open text-warning"></i> -->
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-icon" href="#"  @click="logout">
                            <i class="bi bi-door-open text-warning"></i>
                        </a>
                    </li>
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
                    <router-link class="nav-link" :to="{ name: 'buyer' }" :class="{ active: $route.name === 'buyer' }">
                        <i class="bi bi-pie-chart"></i>
                        <span>Summary</span>
                    </router-link>
                </li>
                <!-- End Dashboard Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" :class="{ 'active': isAnyChildRouteActive() }"
                        data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-database"></i><span>Database</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav"
                        :class="{ 'show': isAnyChildRouteActive() }">
                        <li>
                            <router-link :to="{ name: 'buyer_product' }" active-class="active">
                                <i class="bi bi-circle"></i><span>Product List</span>
                            </router-link>
                        </li>

                    </ul>
                </li>

                <li class="nav-item" v-if="can('createBuyerPriceInquiry | editBuyerPriceInquiry')">
                    <router-link class="nav-link" :to="{ name: 'buyer_price_inquiry' }"
                        :class="{ active: this.$route.name === 'buyer_price_inquiry_entry' || this.$route.name === 'buyer_price_inquiry_edit' }"
                        active-class="active">
                        <i class="bi bi-currency-exchange"></i><span>Price Inquiry</span>
                    </router-link>
                </li>
                <!-- End Tables Nav -->

                <li class="nav-item" v-if="can('editBuyerOrder | createNewBuyerOrder')">
                    <router-link class="nav-link" :to="{ name: 'buyer_order_list' }"
                        :class="{ active: this.$route.name === 'buyer_order_create' || this.$route.name === 'buyer_order_entry' }"
                        active-class="active">
                        <i class="bi bi-bag"></i><span>Order</span>
                    </router-link>
                </li>
                <!-- Shipment -->
                <li class="nav-item" v-if="can('buyerShipmentOverview')">
                    <router-link class="nav-link" :to="{ name: 'buyer_shipment_overview' }"
                        :class="{ active: this.$route.name === 'buyer_shipment_overview' || this.$route.name === 'buyer_information' || this.$route.name === 'buyer_cibd' || this.$route.name === 'buyer_ci' }"
                        active-class="active">
                        <i class="bi bi-box2"></i><span>Shipment</span>
                    </router-link>
                </li>

                <!-- End Icons Nav -->
                <li class="nav-item" v-if="can('buyerAccountPayable')">
                    <router-link class="nav-link" :to="{ name: 'buyer_payable' }"
                        :class="{ active: this.$route.name === 'buyer_payable' }" active-class="active">
                        <i class="bi bi-cash-coin"></i><span>Finance</span>
                    </router-link>
                </li>
                <!-- End Profile Page Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="pages-faq.html">
                        <i class="bi bi-bar-chart-line"></i>
                        <span>Statistic</span>
                    </a>
                </li>

                <!-- End Login Page Nav -->
            </ul>
        </aside>
        <!-- End Sidebar-->

        <main id="main" class="main" style="min-height: 100vh">
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
                '/buyer/product',
                '/buyer/productEdit/:id',
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
