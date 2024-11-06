<template>
    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Sales Card -->
                    <div class="col-xxl-3 col-md-6 ">
                        <div class="card info-card sales-card cursor-pointer" @click="goToBuyersPage">
                            <div class="card-body rounded bg-milung">
                                <h5 class="card-title text-white text-white">Buyers
                                    <!-- <span>| Today</span> -->
                                </h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div class="ps-3">
                                        <p class="text-white fw-bold">{{ data.Buyers }}</p>
                                        <!-- <span class="text-success small pt-1 fw-bold">12%</span>
                                        <span class="text-muted small pt-2 ps-1">increase</span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card revenue-card cursor-pointer" @click="goToProductsPage">
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
                                        <p class="text-white fw-bold">{{ data.Product }}</p>
                                        <!-- <span class="text-success small pt-1 fw-bold">8%</span>
                                        <span class="text-muted small pt-2 ps-1">increase</span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card revenue-card cursor-pointer" @click="goToSuppliersPage">
                            <div class="card-body rounded bg-warning">
                                <h5 class="card-title text-white">
                                    Supplier
                                </h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <p class="text-white fw-bold">{{ data.Supplier }}</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card revenue-card cursor-pointer" @click="goToAdminPage">
                            <div class="card-body rounded bg-primary">
                                <h5 class="card-title text-white">
                                    Admin
                                </h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-gear"></i>
                                    </div>
                                    <div class="ps-3">
                                        <!-- <p class="text-white fw-bold" >$3,264</p> -->

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
                                <GridLayout v-model:layout="layout" :col-num="12" :row-height="30" is-draggable
                                    is-resizable vertical-compact use-css-transforms>
                                    <GridItem key="1" :x="0" :y="0" :w="6" :h="5" i="0">
                                        <RecentOrdersTable :orders="data.orders" />
                                    </GridItem>
                                    <GridItem key="2" :x="6" :y="0" :w="6" :h="5" i="1">
                                        <div class="card info-card revenue-card cursor-pointer">
                                            <div class="card-body rounded bg-primary">
                                                <h5 class="card-title text-white">
                                                    Admin
                                                </h5>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-gear"></i>
                                                    </div>
                                                    <div class="ps-3">
                                                        <!-- Optional Content -->
                                                        <!-- <p class="text-white fw-bold">$3,264</p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </GridItem>
                                </GridLayout>
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
                        <h5 class="card-title text-white">Dashboard</h5>
                        <p><i class="bi bi-clock-fill"></i> 12:24 Today, May 19</p>

                        <div class="Dashboard activity">
                            <p>Pending Tasks or Schedule Board</p>

                        </div>
                        <div>
                            <h5 class="card-title text-white">
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
                            <h5 class="card-title text-white">Top Categories</h5>
                            <p><i class="bi bi-clock-fill"></i> 12:24 Today, May 19</p>
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
import RecentOrdersTable from '@/components/RecentOrdersTable.vue';
export default {
    components: {
        RecentOrdersTable
    },
    data() {
        return {
            layout: [
                { i: '0', x: 0, y: 0, w: 6, h: 5 },
                { i: '1', x: 6, y: 0, w: 6, h: 5 },
            ],
            data: {},
        }
    },
    mounted() {
        this.fetchdata();

    },
    methods: {
        goToBuyersPage() {
            this.$router.push({ name: 'Databuyer' });
        },
        goToProductsPage() {
            this.$router.push({ name: 'product' });
        },
        goToSuppliersPage() {
            this.$router.push({ name: 'Datasupplier' });
        },
        goToAdminPage() {
            this.$router.push({ name: 'user' });
        },
        async fetchdata() {
            try {

                const response = await axios.get('/api/dashboard');
                this.data = response.data;
                console.log(this.data);

            } catch (error) {
                console.error(error);
            }
        },
    },
}
</script>

<style scoped>
@import url('./style.css');
</style>
