<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">

                <div class="card  ">
                    <div class="card-header  ">
                        <div class="">

                        </div>
                        <div class="d-flex justify-content-between align-items-center mx-3">
                            <span>
                                <span class=" fw-bold fs-4 text-uppercase" style="color: #14245c;">Shipment
                                    Overview:</span>
                            </span>

                            <div class="col-4 d-flex">
                                <div class="col-12 d-flex justify-content-end">
                                    <!-- <div class="col-8">
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1"><i style="color: #41b400;"
                                                    class="bx bx-filter-alt fw-bold fs-4"></i></span>
                                            <input type="text" name="search" class="form-control " v-model="searchQuery"
                                                ref="search" placeholder="Write here to filter..." />
                                        </div>
                                    </div> -->
                                    <div class="col-4 mx-2 align-items-end">
                                        <router-link :to="{ name: 'create_so' }" v-if="can('createSONumber')"
                                            class="btn btn-warning fw-bold text-dark">Create SO#
                                        </router-link>
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
                        <table class="table table-striped table-hover  ">
                            <thead style="color: #009de1; " class="text-center">
                                <tr style="">
                                    <th @click="sortTable('so_number')" class="text-nowrap cursor-pointer">SO# <i
                                            :class="getSortIcon('so_number')" class="ms-1"></i></th>
                                    <th @click="sortTable('shipment.ship_date')" class="text-nowrap cursor-pointer">
                                        Shipment Date <i :class="getSortIcon('shipment.ship_date')" class="ms-1"></i>
                                    </th>
                                    <th @click="sortTable('method')" class="text-nowrap cursor-pointer">Shipping Method
                                        <i :class="getSortIcon('method')" class="ms-1"></i></th>
                                    <th @click="sortTable('shipment.waybill')" class="text-nowrap cursor-pointer">
                                        Tracking / Waybillt# <i :class="getSortIcon('shipment.waybill')"
                                            class="ms-1"></i></th>
                                    <th @click="sortTable('shipment.delivery')" class="text-nowrap cursor-pointer">
                                        Delivery Date <i :class="getSortIcon('shipment.delivery')" class="ms-1"></i>
                                    </th>
                                    <th class="text-nowrap">Shipping Documents</th>
                                    <th class="text-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody v-for="ship in dataToDisplay" :key="ship.id" v-if="dataToDisplay.length > 0">
                                <tr class="text-center" style="border-bottom-color: snow !important;">
                                    <td>
                                        <div class="form-check">

                                            {{ ship.so_number }}
                                        </div>
                                    </td>
                                    <td
                                        :class="{ 'text-muted': ship?.shipment?.ship_date == null, 'fst-italic': ship?.shipment?.ship_date == null }">
                                        {{ ship?.shipment?.ship_date ?? 'null' }}
                                    </td>
                                    <td>
                                        <span>{{ ship.method }}</span>
                                    </td>
                                    <td
                                        :class="{ 'text-muted': ship?.shipment?.waybill == null, 'fst-italic': ship?.shipment?.waybill == null }">
                                        {{ ship?.shipment?.waybill ?? 'null' }}</td>
                                    <td
                                        :class="{ 'text-muted': ship?.shipment?.delivery == null, 'fst-italic': ship?.shipment?.delivery == null }">
                                        {{ ship?.shipment?.delivery ?? 'null'
                                        }}</td>
                                    <td>
                                        <router-link class="btn btn-light text-black"
                                            v-if="can('exportShippingDocuments')"
                                            :to="{ name: 'information', params: { id: ship.id, so_number: ship.so_number } }">
                                            <i class="bi bi-file-earmark-text fw-bold"></i>
                                        </router-link>

                                    </td>


                                    <td>
                                        <button @click="toggleAccordion(ship)" class="btn btn-light"
                                            :class="{ 'rotate-icon': accordionOpen[ship.id] }"
                                            v-if="can('editShipmentOverview')">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <a href="#" @click="deleteship(ship.id)" class="text-danger"
                                            v-if="can('editShipmentOverview')"><i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <transition name="fade" v-if="can('editShipmentOverview')">
                                    <tr v-show="accordionOpen[ship.id]">
                                        <td :colspan="7">

                                            <shipmentdetails :so-data="ship" @record-updated="handleRecordUpdated" />
                                        </td>
                                    </tr>
                                </transition>

                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="17">
                                        <p class="text-center">No orders to display.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- <DataTable paginator :rows="10" :rowsPerPageOptions="[5, 10, 20, 50]" v-model:expandedRows="accordionOpen" :value="dataToDisplay" responsiveLayout="scroll"
                             dataKey="id" headerClass="text-center text-nowrap" bodyClass="text-center text-wrap">
                            <Column sortable field="so_number" header="SO#" headerStyle="color: #009de1;"></Column>

                            <Column sortable header="Shipment Date" headerStyle="color: #009de1;">
                                <template #body="slotProps">
                                    {{ slotProps.data.shipment?.ship_date || 'null' }}

                                </template>
</Column>

<Column header="Shipping Method" headerStyle="color: #009de1;" sortable>
    <template #body="slotProps">
                                    {{ slotProps.data.method }}
                                </template>
</Column>

<Column sortable header="Tracking / Waybill#" headerStyle="color: #009de1;">
    <template #body="slotProps">
                                    <span :class="{ 'text-muted fst-italic': !slotProps.data.shipment?.waybill }">
                                        {{ slotProps.data.shipment?.waybill || 'null' }}
                                    </span>
                                </template>
</Column>

<Column sortable header="Delivery Date" headerStyle="color: #009de1;">
    <template #body="slotProps">
                                    <span :class="{ 'text-muted fst-italic': !slotProps.data.shipment?.delivery }">
                                        {{ slotProps.data.shipment?.delivery || 'null' }}
                                    </span>
                                </template>
</Column>

<Column header="Shipping Documents" headerStyle="color: #009de1;">
    <template #body="slotProps">
                                    <router-link v-if="can('exportShippingDocuments')" class="btn btn-light text-black"
                                        :to="{
                                            name: 'information',
                                            params: {
                                                id: slotProps.data.id,
                                                so_number: slotProps.data.so_number,
                                            },
                                        }">
                                        <i class="bi bi-file-earmark-text fw-bold"></i>
                                    </router-link>
                                </template>
</Column>

<Column header="Actions" expander headerStyle="color: #009de1;">
    <template #body="slotProps">
                                    <span class="d-flex" >

                                        <button v-if="can('editShipmentOverview')" class="btn btn-light"
                                            :class="{ 'rotate-icon': accordionOpen[slotProps.data.id] }"
                                            @click="toggleAccordion(slotProps.data)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button v-if="can('editShipmentOverview')"
                                            @click="deleteship(slotProps.data.id)" class="text-danger btn">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </span>
                                </template>
</Column>

<template #expansion="slotProps">
                                <h5>Orders for {{ slotProps.data.name }}</h5>
                                <shipmentdetails :so-data="slotProps.data" @record-updated="handleRecordUpdated" />
                            </template>


<template #empty>
                                <p class="text-center">No orders to display.</p>
                            </template>
</DataTable> -->


                        <nav>
                            <ul class="pagination d-flex justify-content-center">
                                <li class="page-item me-auto fw-bold" :class="{ disabled: currentPage === 1 }">
                                    <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)"><i
                                            class="bi bi-arrow-left"></i>
                                        Previous</a>
                                </li>
                                <li class="page-item" v-for="page in totalPages" :key="page"
                                    :class="{ active: page === currentPage }">
                                    <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
                                </li>
                                <li class="page-item ms-auto fw-bold" :class="{ disabled: currentPage === totalPages }">
                                    <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">Next <i
                                            class="bi bi-arrow-right"></i> </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <EventLogTable :key="componentKey" :filterValue="'SO'" />
            </div>
        </div>
    </section>
</template>

<script>
import './../index';
import Swal from 'sweetalert2';
import shipmentdetails from './shipmentdetails.vue';
import 'sweetalert2/dist/sweetalert2.min.css';
import { format } from 'date-fns';
import { parseISO } from 'date-fns';
import NProgress from 'nprogress';
import 'nprogress/nprogress.css';


export default {
    components: {
        shipmentdetails
    },
    props: {
        perPage: {
            type: Number,
            default: 10
        }
    },
    data() {
        return {
            sortKey: '',
            sortAsc: true,
            groupId: null,
            isLoading: true,
            shipment: [],
            selectedshipIds: [],
            accordionOpen: {},
            currentPage: 1,
            componentKey: 0,
            searchQuery: '',
            dropdownOpen: false
        };
    },
    watch: {
        data(newVal) {
            this.shipment = newVal;
        }
    },
    computed: {

        filteredshipment() {
            return this.shipment.filter(ship => {
                return ship.buyer.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    (ship.supplier.toLowerCase().includes(this.searchQuery));

            });
        },
        totalPages() {
            return Math.ceil(this.shipment.length / this.perPage)
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.perPage
            const end = start + this.perPage
            return this.shipment.slice(start, end)
        },
        dataToDisplay() {
            if (this.searchQuery) {
                return this.filteredshipment;
            } else {
                return this.paginatedData;
            }
        }
    },
    mounted() {

    },
    created() {
        this.fetchShipment().then(() => {
            setTimeout(() => {
                this.isLoading = false;
            }, 1000); // Delay of 1 second
        });
    },
    methods: {
        sortTable(key) {
            if (this.sortKey === key) {
                this.sortAsc = !this.sortAsc;
            } else {
                this.sortKey = key;
                this.sortAsc = true;
            }
            this.shipment.sort((a, b) => {
                const getValue = (obj, path) => path.split('.').reduce((acc, part) => acc && acc[part], obj);
                const aValue = getValue(a, key);
                const bValue = getValue(b, key);

                let result = 0;
                if (aValue < bValue) {
                    result = -1;
                } else if (aValue > bValue) {
                    result = 1;
                }
                return this.sortAsc ? result : -result;
            });
        },
        getSortIcon(key) {
            if (this.sortKey === key) {
                return this.sortAsc ? 'fas fa-sort-up' : 'fas fa-sort-down';
            }
            return 'fas fa-sort';
        },
        handleRecordUpdated() {
            this.accordionOpen = {};
            // Refresh the data in the parent component
            this.fetchShipment();
        },
        toggleAccordion(ship) {
            if (this.accordionOpen[ship.id]) {
                delete this.accordionOpen[ship.id];
            } else {
                this.accordionOpen[ship.id] = true;
            }
        },
        changePage(page) {
            this.currentPage = page
        },
        async deleteship(shipId) {
            // Display SweetAlert confirmation dialog
            const result = await Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this inquiry!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            });

            if (result.isConfirmed) {
                // ship confirmed, proceed with the deletion
                try {
                    await axios.delete(`/api/soDelete/${shipId}`);
                    this.componentKey += 1;
                    // If successful, remove the ship from the local data
                    this.shipment = this.shipment.filter(ship => ship.id !== shipId);

                    Swal.fire({
                        icon: 'success',
                        title: 'Order deleted successfully',
                    });
                } catch (error) {
                    console.error('Error deleting order:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error deleting order',
                    });
                }
            }
        },
        async fetchShipment() {
            NProgress.start();
            try {
                const response = await axios.get('/api/shipmentget');
                this.shipment = response.data;
                // this.pagination.totalItems = response.data.total;
                console.log(response.data);

                NProgress.done();
            } catch (error) {
                NProgress.done();
                console.error('Error fetching shipment:', error);
                toastr.error('Error fetching data');
            }
        },
        toggleDropdown() {
            this.dropdownOpen = !this.dropdownOpen;
        },
        toggleModal(modalId, routeName) {
            // Dismiss the modal
            const modal = this.$refs[modalId];
            if (modal) {
                const bootstrapModal = new bootstrap.Modal(modal);
                bootstrapModal.hide();
            }

            // Navigate to the specified route
            if (routeName) {
                this.$router.push({ name: routeName });
            }
        }

    },
};
</script>

<style scoped>
@import url('./../style.css');

.rotate-icon {
    transform: rotate(180deg);
}

.bg-cyan {
    background-color: #12d4b3 !important;
}

.dropdown-menu {
    display: none;
}

.show {
    display: block;
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

.page-item.active .page-link,
.btn-milung {
    background-color: #14245c !important;
    color: white;
}

td {
    border: none !important;
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
