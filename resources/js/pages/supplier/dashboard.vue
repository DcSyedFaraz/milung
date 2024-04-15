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

                    <li class="nav-item dropdown pe-3">
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                            data-bs-toggle="dropdown">
                            <img src="./../../../assets/img/profile-img.jpg" alt="Profile" class="rounded-circle" />
                            <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>
                        </a><!-- End Profile Iamge Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile"
                            style="background-color: beige;">
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
                                <a class="dropdown-item d-flex align-items-center" href="#" @click="logout">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sign Out</span>
                                </a>
                            </li>
                        </ul>
                        <!-- End Profile Dropdown Items -->
                    </li>
                    <!-- End Profile Nav -->

                    <li class="nav-item dropdown">
                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-bell"></i>
                            <span class="badge badge-number">4</span> </a><!-- End Notification Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications"
                            style="background-color: beige;">
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

                            <li class="notification-item">
                                <i class="bi bi-x-circle text-danger"></i>
                                <div>
                                    <h4>Atque rerum nesciunt</h4>
                                    <p>Quae dolorem earum veritatis oditseno</p>
                                    <p>1 hr. ago</p>
                                </div>
                            </li>

                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li class="notification-item">
                                <i class="bi bi-check-circle text-success"></i>
                                <div>
                                    <h4>Sit rerum fuga</h4>
                                    <p>Quae dolorem earum veritatis oditseno</p>
                                    <p>2 hrs. ago</p>
                                </div>
                            </li>

                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li class="notification-item">
                                <i class="bi bi-info-circle text-primary"></i>
                                <div>
                                    <h4>Dicta reprehenderit</h4>
                                    <p>Quae dolorem earum veritatis oditseno</p>
                                    <p>4 hrs. ago</p>
                                </div>
                            </li>

                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li class="dropdown-footer">
                                <a href="#">Show all notifications</a>
                            </li>
                        </ul>
                        <!-- End Notification Dropdown Items -->
                    </li>
                    <!-- End Notification Nav -->

                    <li class="nav-item dropdown">
                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-chat-left-text"></i>
                            <span class="badge badge-number">3</span> </a><!-- End Messages Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages"
                            style="background-color: beige;">
                            <li class="dropdown-header">
                                You have 3 new messages
                                <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li class="message-item">
                                <a href="#">
                                    <img src="./../../../assets/img/messages-1.jpg" alt="" class="rounded-circle" />
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
                                    <img src="./../../../assets/img/messages-2.jpg" alt="" class="rounded-circle" />
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
                                    <img src="./../../../assets/img/messages-3.jpg" alt="" class="rounded-circle" />
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
                        <!-- End Messages Dropdown Items -->
                    </li>
                    <!-- End Messages Nav -->
                </ul>
            </nav>
            <!-- End Icons Navigation -->
        </header>
        <!-- End Header -->

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">
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

                <li class="nav-item">
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
                </li>
                <!-- End Forms Nav -->
                <li class="nav-item">
                    <router-link class="nav-link" :to="{ name: 'supplier_price_inquiry' }"
                        :class="{ active: this.$route.name === 'supplier_price_inquiry_entry' }" active-class="active">
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
                            <router-link class="nav-link" :to="{ name: 'supplier_order_list' }"
                                :class="{ active: $route.name === 'order_entry' || $route.name === 'supplier_order_edit' }"
                                active-class="active">
                                <i class="bi bi-bag"></i><span>Order</span>
                            </router-link>
                            <router-link class="nav-link" :to="{ name: 'supplier_order_price_inquiry' }"
                                :class="{ active: $route.name === 'supplier_order_price_inquiry' }"
                                active-class="active">
                                <i class="bi bi-bag"></i><span>Order Price Inquiry</span>
                            </router-link>
                        </li>

                    </ul>
                </li>
                <!-- Shipment -->

                <li class="nav-item">
                    <a class="nav-link collapsed" :class="{ 'active': isAnyShipmentRouteActive() }"
                        data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-box2"></i><span>Shipment</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="icons-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav"
                        :class="{ 'show': isAnyShipmentRouteActive() }">
                        <li>
                            <router-link class="nav-link" :to="{ name: 'supplier_shipment_overview' }"
                                :class="{ active: $route.name === 'packinglist' || $route.name === 'supplier_receiptnote' }" active-class="active">
                                <i class="bi bi-bag"></i><span>Shipment Overview</span>
                            </router-link>
                        </li>

                    </ul>
                </li>
                <!-- End Icons Nav -->
                <li class="nav-item">

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
    methods: {
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
