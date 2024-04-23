<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class=""></div>
                        <div class="d-flex justify-content-between align-items-center mx-3">
                            <span>
                                <span class="fw-bold fs-4 text-uppercase" style="color: #14245c">Order List:</span>
                            </span>

                            <div class="col-4 d-flex">
                                <div class="col-12 d-flex">
                                    <div class="col-12">
                                        <div class="card flex justify-content-center">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1"><i style="color: #41b400"
                                                    class="bx bx-filter-alt fw-bold fs-4"></i></span>
                                            <input type="text" name="search" class="form-control" v-model="searchQuery"
                                                ref="search" placeholder="Write here to filter..." />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- // Loader -->
                    <div class="card-body rounded-top" v-if="isLoading">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border text-warning" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <!-- // Loader -->
                    <div class="card-body rounded-top table-responsive" v-else>
                        <!-- Table with stripped rows -->
                        <!-- <table class="table table-striped table-hover">
                            <thead style="color: #009de1" class="text-center">
                                <tr style="">
                                    <th class="text-nowrap">Order Number</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Date Modified</th>
                                    <th class="text-nowrap">Date Created</th>
                                    <th class="text-nowrap">
                                        Latest SendOut Date
                                    </th>
                                    <th class="text-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody
                                v-for="order in dataToDisplay"
                                :key="order.id"
                                v-if="dataToDisplay.length > 0"
                            >
                                <tr
                                    class="text-center"
                                    style="border-bottom-color: snow !important"
                                >
                                    <td>
                                        {{ order.id }}
                                    </td>
                                    <td>
                                        <span :class="statusBadge(order)">{{
                                            order.status
                                        }}</span>
                                    </td>
                                    <td>{{ updated_at(order) }}</td>
                                    <td>{{ created_at(order) }}</td>
                                    <td>{{ order.sendoutdate }}</td>

                                    <td>
                                        <router-link
                                            :to="{
                                                name: 'supplier_order_edit',
                                                params: { id: order.id },
                                            }"
                                            class="text-success mx-2"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </router-link>
                                    </td>
                                </tr>
                                <transition name="fade">
                                    <tr v-show="accordionOpen[order.id]">
                                        <td :colspan="7">

                                        </td>
                                    </tr>
                                </transition>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="17">
                                        <p class="text-center">
                                            No orders to display.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table> -->

                        <DataTable v-model:filters="filters" :value="orders" sortField="id" :sortOrder="-1"
                            tableStyle="min-width: 50rem" filterDisplay="row" paginator :rows="10" :loading="isLoading"
                            :globalFilterFields="['id', 'sendoutdate', 'updated_at', 'created_at', 'status']">

                            <template #header>
                                <div class="d-flex justify-content-end">

                                    <IconField iconPosition="left">
                                        <InputIcon>
                                            <i style="color: #41b400" class="bx bx-filter-alt fw-bold fs-4"></i>
                                        </InputIcon>
                                        <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                                    </IconField>
                                </div>
                            </template>

                            <Column field="id" header="Order Number" sortable style="width: 20%"></Column>
                            <Column field="status" header="Status" sortable style="width: 20%">
                                <template #body="{ data }">
                                    <Tag :value="data.status" :severity="getSeverity(data)" />
                                </template>
                            </Column>
                            <Column field="updated_at" header="Date Modified" :sortable="true">
                                <template #body="{ data }">
                                    {{ created_at(data.updated_at) }}
                                </template>
                            </Column>
                            <Column field="created_at" header="Date Modified" :sortable="true">
                                <template #body="{ data }">
                                    {{ created_at(data.created_at) }}
                                </template>
                            </Column>
                            <Column field="sendoutdate" header="Latest SendOut Date" sortable style="width: 20%">
                            </Column>
                            <Column field="actions" header="Actions" style="width: 10%">
                                <template #body="{ data }">
                                    <div class="d-flex justify-content-center">

                                        <router-link :to="{
                                                name: 'buyer_order_entry',
                                                params: { id: data.id },
                                            }" class="text-success mx-2">
                                            <i class="bi bi-pencil"></i>
                                        </router-link>

                                    </div>
                                </template>
                            </Column>
                        </DataTable>
                        <!-- <nav>
                            <ul class="pagination d-flex justify-content-center">
                                <li class="page-item me-auto fw-bold" :class="{ disabled: currentPage === 1 }">
                                    <a class="page-link" href="#" @click.prevent="
                                                changePage(currentPage - 1)
                                                "><i class="bi bi-arrow-left"></i>
                                        Previous</a>
                                </li>
                                <li class="page-item" v-for="page in totalPages" :key="page"
                                    :class="{ active: page === currentPage }">
                                    <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
                                </li>
                                <li class="page-item ms-auto fw-bold" :class="{
                                                disabled: currentPage === totalPages,
                                            }">
                                    <a class="page-link" href="#" @click.prevent="
                                                changePage(currentPage + 1)
                                                ">Next <i class="bi bi-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Swal from "sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import { format } from "date-fns";
import { parseISO } from "date-fns";
import NProgress from "nprogress";
import "nprogress/nprogress.css";
import { FilterMatchMode, FilterOperator } from 'primevue/api';

import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';


export default {
    components: {
        IconField,
        InputIcon
        // other components...
    },
    props: {
        perPage: {
            type: Number,
            default: 10,
        },
    },
    data() {

        return {
            groupId: null,
            isLoading: true,
            file: null,
            orders: [],
            accordionOpen: {},
            currentPage: 1,
            searchQuery: "",
            filters: null,
        };
    },
    computed: {
        filteredorders() {
            return this.orders.filter((order) => {
                return (
                    order.buyer
                        .toLowerCase()
                        .includes(this.searchQuery.toLowerCase()) ||
                    order.supplier.toLowerCase().includes(this.searchQuery)
                );
            });
        },
        totalPages() {
            return Math.ceil(this.orders.length / this.perPage);
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.orders.slice(start, end);
        },
        dataToDisplay() {
            if (this.searchQuery) {
                return this.filteredorders;
            } else {
                return this.paginatedData;
            }
        },
    },
    methods: {
        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                status: { operator: FilterOperator.OR, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] },
                created_at: { value: null, matchMode: FilterMatchMode.EQUALS },
                updated_at: { value: null, matchMode: FilterMatchMode.EQUALS }
            };
        },
        getSeverity(order) {
            // console.log('hi', order);
            switch (order.status) {
                case "New Order":
                    return "primary";
                case "Printview Confirmation":
                    return "cyan";

                case "Printview Reject":
                    return "danger";

                case "Order Confirm":
                    return "success";

                case "Cargo Ready":
                    return "warning";

                case "Shipment Approval":
                    return "info";

                case "Export/Import":
                    return "contrast";

                case "Delivered":
                    return "secondary";
                default:
                    return "secondary";
            }
        },
        updated_at(order) {
            if (order.updated_at) {
                // Parse the datetime string using date-fns
                const parsedDateTime = parseISO(order.updated_at);
                // Format the parsed date using date-fns
                return format(parsedDateTime, "dd-MM-yyyy HH:mm");
            } else {
                return "";
            }
        },
        created_at(order) {
            // console.log('hello',order);
            if (order) {

                // Parse the datetime string using date-fns
                const parsedDateTime = parseISO(order);
                // Format the parsed date using date-fns
                return format(parsedDateTime, "dd-MM-yyyy HH:mm");
            } else {
                return "";
            }
        },
        changePage(page) {
            this.currentPage = page;
        },
        async fetchorders() {
            NProgress.start();
            try {
                const response = await axios.get("/api/buyer/order");
                this.orders = response.data;
                // this.pagination.totalItems = response.data.total;
                console.log(response.data);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error("Error fetching orders:", error);
                toastr.error("Error fetching data");
            }
        },
    },
    created() {
        this.fetchorders().then(() => {
            setTimeout(() => {
                this.isLoading = false;
            }, 1000); // Delay of 1 second
        });
        this.initFilters();
    },
};
</script>

<style lang="scss" scoped>
@import url("./../style.css");

.rotate-icon {
    transform: rotate(180deg);
}

.bg-cyan {
    background-color: #12d4b3 !important;
}

.bg-pink {
    background-color: #b40096 !important;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s !important;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}

.page-link {
    border: none !important;
    color: #14245c;
}

button.p-paginator-page.p-paginator-element.p-link.p-highlight,
.btn-milung {
    background-color: #14245c !important;
    color: white;
}

td {
    border: none !important;
}

th {
    color: #009de1 !important;
}

.rounded-top-new {
    border-top-left-radius: 2.25rem !important;
    border-top-right-radius: 2.25rem !important;
}

.rounded-bottom-new {
    border-bottom-left-radius: 2.25rem !important;
    border-bottom-right-radius: 2.25rem !important;
}
</style>
