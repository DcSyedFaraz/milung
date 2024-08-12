<template>
    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6 ">
                        <div class="card info-card sales-card">
                            <div class="card-body rounded bg-milung">
                                <h5 class="card-title text-white text-white">Inquiry
                                    <!-- <span>| Today</span> -->
                                </h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div class="ps-3">
                                        <p class="text-white fw-bold">{{ data.Inquiry }}</p>
                                        <!-- <span class="text-success small pt-1 fw-bold">12%</span>
                                        <span class="text-muted small pt-2 ps-1">increase</span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body rounded bg-blue">
                                <h5 class="card-title text-white">
                                    Products
                                </h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <p class="text-white fw-bold">{{ data.Products }}</p>
                                        <!-- <span class="text-success small pt-1 fw-bold">8%</span>
                                        <span class="text-muted small pt-2 ps-1">increase</span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body rounded bg-warning">
                                <h5 class="card-title text-white">
                                    Orders
                                </h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <p class="text-white fw-bold">{{ data.Orders }}</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Revenue Card -->


                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto shadow-lg">
                            <div class="card-body rounded ">
                                <h5 class="card-title fw-bold text-milung">Recent Orders</h5>
                                <table class="table table-active ">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Send Out  Date</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="orders in data.Order" v-if="data.Order">
                                            <th scope="row">{{ orders.id }}</th>
                                            <td>{{ orders.productname }}</td>
                                            <td>
                                                {{ orders.sendoutdate }}
                                            </td>
                                            <td>{{ orders.status }}</td>

                                        </tr>
                                        <tr v-else>
                                            <td colspan="5" class="text-muted fst-italic text-center">

                                                no orders avaialable
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End Recent Sales -->


                </div>
            </div>

            <!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">
                <!-- Dashboard -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Dashboard</h5>
                        <p><i class="bi bi-clock-fill"></i> 12:24 Taday, May 19</p>

                        <div class="Dashboard activity">
                            <p>Pending Tasks or Schedule Board</p>

                        </div>
                        <div>
                            <h5 class="card-title">
                                Budget Report <span><a href="#">See All</a></span>
                            </h5>
                            <div class="news">
                                <div class="post-item clearfix">
                                    <img src="./../../../assets/img/news-1.jpg" alt="" />
                                    <h4><a href="#">Withdraw Earing</a></h4>
                                    <p>
                                        12:00 am
                                    </p>
                                </div>

                                <div class="post-item clearfix">
                                    <img src="./../../../assets/img/news-2.jpg" alt="" />
                                    <h4><a href="#">Quidem autem et impedit</a></h4>
                                    <p>
                                        12:00 am
                                    </p>
                                </div>

                                <div class="post-item clearfix">
                                    <img src="./../../../assets/img/news-3.jpg" alt="" />
                                    <h4>
                                        <a href="#">Id quia et et ut maxime similique occaecati ut</a>
                                    </h4>
                                    <p>
                                        12:00 am
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Summay Ends -->
                        <div>
                            <h5 class="card-title">Top Categories</h5>
                            <p><i class="bi bi-clock-fill"></i> 12:24 Taday, May 19</p>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            <div class="icon-card">
                                <div class="img-cad">
                                    <i class="bi bi-archive-fill"></i>
                                    <h6>Footwear</h6>
                                    <p>10951 <span>Units</span></p>
                                </div>
                                <div class="img-cad">
                                    <i class="bi bi-incognito"></i>
                                    <h6>Footwear</h6>
                                    <p>10951 <span>Units</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Right side columns -->
                </div>
            </div>
        </div>

    </section>
</template>

<script>
import './index';

import NProgress from "nprogress";
import "nprogress/nprogress.css";

export default {
    data() {


        return {
            data: {},
        }
    },
    created() {
        this.fetchdata();

    },
    methods: {
        async fetchdata() {
            NProgress.start();
            try {

                const response = await axios.get('/api/buyer/dashboard');
                this.data = response.data;
                console.log(this.data);
                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error(error);
            }
        },
    },
}
</script>

<style scoped>
@import url('./style.css');
</style>
