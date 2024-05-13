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

                    <li class="nav-item dropdown">
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                            data-bs-toggle="dropdown">
                            <img src="./../../../assets/img/profile-img.jpg" alt="Profile" class="rounded-circle" />
                            <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>
                        </a><!-- End Profile Iamge Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li class="dropdown-header">
                                <h6>Kevin Anderson</h6>
                                <span>Web Designer</span>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                    <i class="bi bi-person"></i>
                                    <span>My Profile</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                    <i class="bi bi-gear"></i>
                                    <span>Account Settings</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                                    <i class="bi bi-question-circle"></i>
                                    <span>Need Help?</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="#" >
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sign Out</span>
                                </a>
                            </li>
                        </ul>
                        <!-- End Profile Dropdown Items -->
                    </li>
                    <!-- End Profile Nav -->
                    <notifications />

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

        <main id="main" class="main">
            <!-- End Page Title -->

            <router-view></router-view>
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
            componentKey: 0
        }
    },
    mounted() {
        this.remountComponent();

    },
    methods: {
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
