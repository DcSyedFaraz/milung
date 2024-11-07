<template>
    <section class="section dashboard">
        <div class="row">
            <!-- Left Side Columns -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Admin/Internal Top Boxes -->
                    <div v-if="isAdminOrInternal" class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card cursor-pointer" @click="navigateTo('Databuyer')">
                            <div class="card-body rounded bg-milung">
                                <h5 class="card-title text-white fs-6">Buyers</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon my-auto rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div class="ps-3 my-auto">
                                        <p class="text-white fw-bold my-auto">{{ data.Buyers }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="isAdminOrInternal" class="col-xxl-3 col-md-6">
                        <div class="card info-card revenue-card cursor-pointer" @click="navigateTo('product')">
                            <div class="card-body rounded bg-blue">
                                <h5 class="card-title text-white fs-6">Products</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon my-auto rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-box-seam"></i>
                                    </div>
                                    <div class="ps-3 my-auto">
                                        <p class="text-white fw-bold my-auto">{{ data.Products }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="isAdminOrInternal" class="col-xxl-3 col-md-6">
                        <div class="card info-card supplier-card cursor-pointer" @click="navigateTo('Datasupplier')">
                            <div class="card-body rounded bg-warning">
                                <h5 class="card-title text-white fs-6">Suppliers</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon my-auto rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-truck"></i>
                                    </div>
                                    <div class="ps-3 my-auto">
                                        <p class="text-white fw-bold my-auto">{{ data.Suppliers }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="isAdminOrInternal" class="col-xxl-3 col-md-6">
                        <div class="card info-card admin-card cursor-pointer" @click="navigateTo('user')">
                            <div class="card-body rounded bg-primary">
                                <h5 class="card-title text-white fs-6">Admin</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon my-auto rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-gear"></i>
                                    </div>
                                    <div class="ps-3 my-auto">
                                        <p class="text-white fw-bold my-auto">Manage</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Internal Operation Widget -->
                    <div v-if="isBuyer || isSupplier || (isAdminOrInternal && hasPermission('createPriceInquiry'))"
                        class="col-xxl-3 col-md-6">
                        <div class="card info-card operation-card cursor-pointer" @click="navigateTo('priceInquiry')">
                            <div class="card-body rounded bg-operation">
                                <h5 class="card-title text-white fs-6">Order Price Inquiry</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon my-auto rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3 my-auto">
                                        <p class="text-white fw-bold my-auto">{{ data.OrderPriceInquiry }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Internal Merchandiser Widget -->
                    <div v-if="isBuyer || (isAdminOrInternal && hasPermission('printviewConfirmRejectButton'))"
                        class="col-xxl-3 col-md-6">
                        <div class="card info-card merchandiser-card cursor-pointer" @click="navigateTo('printview')">
                            <div class="card-body rounded bg-merchandiser">
                                <h5 class="card-title text-white fs-6">Printview Rejected</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon my-auto rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-printer"></i>
                                    </div>
                                    <div class="ps-3 my-auto">
                                        <p class="text-white fw-bold my-auto">{{ data.PrintviewRejected }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Buyer Widget -->
                    <div v-if="isBuyer" class="col-xxl-3 col-md-6">
                        <div class="card info-card buyer-card cursor-pointer" @click="navigateTo('fixedOrders')">
                            <div class="card-body rounded bg-buyer">
                                <h5 class="card-title text-white fs-6">Fixed Orders</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon my-auto rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart-check"></i>
                                    </div>
                                    <div class="ps-3 my-auto">
                                        <p class="text-white fw-bold my-auto">{{ data.FixedOrders }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Supplier Widget -->
                    <div v-if="isSupplier" class="col-xxl-3 col-md-6">
                        <div class="card info-card supplier-widget-card cursor-pointer"
                            @click="navigateTo('inquiries')">
                            <div class="card-body rounded bg-supplier">
                                <h5 class="card-title text-white fs-6">Inquiries</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon my-auto rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-question-circle"></i>
                                    </div>
                                    <div class="ps-3 my-auto">
                                        <p class="text-white fw-bold my-auto">{{ data.Inquiry }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Widgets Based on Permissions -->
                    <!-- Best Sales Widget -->
                    <div v-if="isAdminOrInternal && hasPermission('bestSales')" class="col-xxl-3 col-md-6">
                        <div class="card info-card best-sales-card cursor-pointer" @click="navigateTo('bestSales')">
                            <div class="card-body rounded bg-best-sales">
                                <h5 class="card-title text-white fs-6">Best Sales</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon my-auto rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-bar-chart-line"></i>
                                    </div>
                                    <div class="ps-3 my-auto">
                                        <p class="text-white fw-bold my-auto">{{ data.bestSalesCount }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Best Purchase Widget -->
                    <div v-if="isAdminOrInternal && hasPermission('bestPurchase')" class="col-xxl-3 col-md-6">
                        <div class="card info-card best-purchase-card cursor-pointer"
                            @click="navigateTo('bestPurchase')">
                            <div class="card-body rounded bg-best-purchase">
                                <h5 class="card-title text-white fs-6">Best Purchase</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon my-auto rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart-plus"></i>
                                    </div>
                                    <div class="ps-3 my-auto">
                                        <p class="text-white fw-bold my-auto">{{ data.bestPurchaseCount }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Revenue Widget -->
                    <div v-if="isAdminOrInternal && hasPermission('salesRevenue')" class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-revenue-card cursor-pointer"
                            @click="navigateTo('salesRevenue')">
                            <div class="card-body rounded bg-sales-revenue">
                                <h5 class="card-title text-white fs-6">Sales Revenue</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon my-auto rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cash-coin"></i>
                                    </div>
                                    <div class="ps-3 my-auto">
                                        <p class="text-white fw-bold my-auto">${{ formatNumber(data.salesRevenue) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Purchase Revenue Widget -->
                    <div v-if="isAdminOrInternal && hasPermission('purchaseRevenue')" class="col-xxl-3 col-md-6">
                        <div class="card info-card purchase-revenue-card cursor-pointer"
                            @click="navigateTo('purchaseRevenue')">
                            <div class="card-body rounded bg-purchase-revenue">
                                <h5 class="card-title text-white fs-6">Purchase Revenue Total</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon my-auto rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cash-stack"></i>
                                    </div>
                                    <div class="ps-3 my-auto">
                                        <p class="text-white fw-bold my-auto">${{
                                            formatNumber(data.purchaseRevenue.total) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="isAdminOrInternal && hasPermission('purchaseRevenue')" class="col-xxl-3 col-md-6">
                        <div class="card info-card purchase-revenue-card cursor-pointer"
                            @click="navigateTo('purchaseRevenue')">
                            <div class="card-body rounded bg-purchase-revenue">
                                <h5 class="card-title text-white fs-6">Purchase Revenue weekly</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon my-auto rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cash-stack"></i>
                                    </div>
                                    <div class="ps-3 my-auto">
                                        <p class="text-white fw-bold my-auto">${{
                                            formatNumber(data.purchaseRevenue.weekly) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="isAdminOrInternal && hasPermission('purchaseRevenue')" class="col-xxl-3 col-md-6">
                        <div class="card info-card purchase-revenue-card cursor-pointer"
                            @click="navigateTo('purchaseRevenue')">
                            <div class="card-body rounded bg-purchase-revenue">
                                <h5 class="card-title text-white fs-6">Purchase Revenue monthly</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon my-auto rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cash-stack"></i>
                                    </div>
                                    <div class="ps-3 my-auto">
                                        <p class="text-white fw-bold my-auto">${{
                                            formatNumber(data.purchaseRevenue.monthly) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="isAdminOrInternal && hasPermission('purchaseRevenue')" class="col-xxl-3 col-md-6">
                        <div class="card info-card purchase-revenue-card cursor-pointer"
                            @click="navigateTo('purchaseRevenue')">
                            <div class="card-body rounded bg-purchase-revenue">
                                <h5 class="card-title text-white fs-6">Purchase Revenue yearly</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon my-auto rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cash-stack"></i>
                                    </div>
                                    <div class="ps-3 my-auto">
                                        <p class="text-white fw-bold my-auto">${{
                                            formatNumber(data.purchaseRevenue.yearly) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders Table -->
                    <div v-if="hasAnyRole(['Admin', 'Internal', 'Buyer', 'Supplier'])" class="col-12">
                        <div class="card recent-sales overflow-auto shadow-lg">
                            <div class="card-body rounded">
                                <h5 class="card-title fw-bold text-milung">Recent Orders</h5>
                                <table class="table table-active">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Send Out Date</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="order in data.Orders" :key="order.id">
                                            <th scope="row">
                                                <router-link :to="{ name: 'order_edit', params: { id: order.id } }">
                                                    {{ order.id }}
                                                </router-link>
                                            </th>
                                            <td>{{ order.productname }}</td>
                                            <td>{{ formatDate(order.sendoutdate) }}</td>
                                            <td>{{ order.status }}</td>
                                        </tr>
                                        <tr v-if="!data.Orders || data.Orders.length === 0">
                                            <td colspan="4" class="text-muted fst-italic text-center">
                                                No orders available
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Top Categories Widget (Assuming Marketing is part of Internal with specific permissions) -->
                    <div v-if="isAdminOrInternal && hasPermission('topCategories')" class="col-12">
                        <div class="card top-categories overflow-auto shadow-lg">
                            <div class="card-body rounded">
                                <h5 class="card-title fw-bold text-milung">Top Categories</h5>
                                <table class="table table-active">
                                    <thead>
                                        <tr>
                                            <th scope="col">Category</th>
                                            <th scope="col">Units Sold</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="category in data.TopCategories" :key="category.name">
                                            <td>{{ category.name }}</td>
                                            <td>{{ category.units_sold }}</td>
                                        </tr>
                                        <tr v-if="!data.TopCategories || data.TopCategories.length === 0">
                                            <td colspan="2" class="text-muted fst-italic text-center">
                                                No categories available
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End Left Side Columns -->

            <!-- Right Side Columns -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-white fs-6">Dashboard</h5>
                        <p><i class="bi bi-clock-fill"></i> {{ currentTime }}</p>

                        <!-- Common Sections -->
                        <div class="Dashboard activity">
                            <p>Pending Tasks or Schedule Board</p>
                        </div>

                        <!-- Admin/Internal Specific Sections -->
                        <div v-if="isAdminOrInternal">
                            <h5 class="card-title text-white fs-6">
                                Budget Report <span><a href="#">See All</a></span>
                            </h5>
                            <div class="news">
                                <div class="post-item clearfix" v-for="report in data.BudgetReports" :key="report.id">
                                    <img :src="report.image" alt="" />
                                    <h4><a :href="report.link">{{ report.title }}</a></h4>
                                    <p>{{ report.time }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Admin/Internal Sections -->
                        <div v-if="isAdminOrInternal && hasPermission('createProductGroup')">
                            <h5 class="card-title text-white fs-6">Top Categories</h5>
                            <p>Track sales of items across groups.</p>
                            <table class="table table-active">
                                <thead>
                                    <tr>
                                        <th scope="col">Product Group</th>
                                        <th scope="col">Units Sold</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="category in data.TopCategories" :key="category.name">
                                        <td>{{ category.group_name }}</td>
                                        <td>{{ category.units_sold }}</td>
                                    </tr>
                                    <tr v-if="!data.TopCategories || data.TopCategories.length === 0">
                                        <td colspan="2" class="text-muted fst-italic text-center">
                                            No categories available
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Buyer Specific Sections -->
                        <div v-if="isBuyer">
                            <h5 class="card-title text-white fs-6">Buyer Insights</h5>
                            <!-- Add Buyer-specific widgets or information here -->
                        </div>

                        <!-- Supplier Specific Sections -->
                        <div v-if="isSupplier">
                            <h5 class="card-title text-white fs-6">Supplier Insights</h5>
                            <!-- Add Supplier-specific widgets or information here -->
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Right Side Columns -->
        </div>
    </section>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Dashboard',
    data() {
        return {
            data: {},
            roles: [],
            permissions: [],
            currentTime: '',
        };
    },
    computed: {
        isAdminOrInternal() {
            return this.hasAnyRole(['Admin', 'Internal']);
        },
        isBuyer() {
            return this.hasAnyRole(['Buyer']);
        },
        isSupplier() {
            return this.hasAnyRole(['Supplier']);
        },
        isInternal() {
            return this.hasAnyRole(['Internal']);
        },
    },
    mounted() {
        this.fetchData();
        this.updateCurrentTime();
        // Update time every minute
        setInterval(this.updateCurrentTime, 60000);
    },
    methods: {
        hasPermission(permission) {
            return this.permissions.includes(permission);
        },
        hasAnyRole(roleArray) {
            return roleArray.some((role) => this.roles.includes(role));
        },
        navigateTo(routeName) {
            this.$router.push({ name: routeName });
        },
        async fetchData() {
            try {
                const response = await axios.get('/api/dashboard');
                this.data = response.data;
                this.roles = this.data.roles || [];
                this.permissions = this.data.permissions || [];
                console.log(this.data);
            } catch (error) {
                console.error(error);
            }
        },
        updateCurrentTime() {
            const now = new Date();
            const options = { hour: '2-digit', minute: '2-digit', month: 'long', day: 'numeric' };
            this.currentTime = now.toLocaleString('en-US', options);
        },
        formatDate(dateString) {
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(dateString).toLocaleDateString(undefined, options);
        },
        formatNumber(number) {
            return number;
        },
    },
};
</script>

<style scoped>
@import url('./style.css');

/* Example Background Colors for Widgets */
.bg-milung {
    background-color: #6c757d;
    /* Adjust color as needed */
}

.bg-blue {
    background-color: #0d6efd;
}

.bg-warning {
    background-color: #ffc107;
}

.bg-primary {
    background-color: #0d6efd;
}

.bg-operation {
    background-color: #17a2b8;
}

.bg-merchandiser {
    background-color: #ffc107;
}

.bg-buyer {
    background-color: #28a745;
}

.bg-supplier {
    background-color: #dc3545;
}

.bg-best-sales {
    background-color: #343a40;
}

.bg-best-purchase {
    background-color: #fd7e14;
}

.bg-sales-revenue {
    background-color: #20c997;
}

.bg-purchase-revenue {
    background-color: #6610f2;
}

/* Additional Styles for Widgets */
.info-card {
    transition: transform 0.2s;
}

.info-card:hover {
    transform: scale(1.05);
}

.card-icon i {
    font-size: 1.5rem;
}

.text-milung {
    color: #6c757d;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .card-body {
        text-align: center;
    }
}
</style>
