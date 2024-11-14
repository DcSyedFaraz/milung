<template>
    <div class="search-container" @click="handleOutsideClick">
        <ais-instant-search :search-client="searchClient" index-name="orders" class="search-form" :routing="routing">
            <!-- Custom Search Box -->
            <div class="search-box-wrapper">
                <ais-search-box v-slot="{ currentRefinement, refine, clear, isSearchStalled }">
                    <div class="input-wrapper">
                        <i class="fas fa-search search-icon"></i> <!-- Search Icon -->
                        <input type="text" :value="currentRefinement" @input="refine($event.target.value)"
                            @focus="showHits = true" @blur="handleBlur" placeholder="Search ..."
                            class="search-input" />
                        <button v-if="currentRefinement" @click="clear" class="clear-button">
                            &times;
                        </button>
                        <span v-if="isSearchStalled" class="loading-indicator">Loading...</span>
                    </div>
                </ais-search-box>
            </div>

            <!-- Search Results -->
            <transition name="fade">
                <div class="hits-wrapper" v-if="showHits">
                    <!-- Conditionally render indices based on accessibleIndices -->
                    <template v-for="index in accessibleIndices" :key="index">
                        <ais-index :index-name="index" v-if="isIndexAccessible(index)">
                            <span class="hit-type">{{ formatIndexName(index) }}</span>
                            <ais-hits>
                                <template v-slot:item="{ item }">
                                    <div class="hit-item" @click="navigateTo(item, determineItemType(index))">
                                        <h2>
                                            <span v-if="index === 'orders'">Order No: </span>
                                            <span v-if="index === 'products'">Article: </span>
                                            <span v-if="index === 'price_inquiries'">Inquiry Number: </span>
                                            <span v-if="index === 'supplier_profiles'">Supplier ID: </span>
                                            <span v-if="index === 'buyer_profiles'">Buyer ID: </span>
                                            <span v-if="index === 'shipment_orders'">SO#: </span>
                                            <ais-highlight :attribute="getPrimaryAttribute(index)" :hit="item" />
                                        </h2>
                                        <p class="hit-description">
                                            <ais-highlight :attribute="getSecondaryAttribute(index)" :hit="item" />
                                        </p>
                                    </div>
                                </template>
                            </ais-hits>
                        </ais-index>
                    </template>
                </div>
            </transition>
        </ais-instant-search>
    </div>
</template>


<script>
import { liteClient as algoliasearch } from 'algoliasearch/lite';
import { history } from 'instantsearch.js/es/lib/routers';
import { singleIndex } from 'instantsearch.js/es/lib/stateMappings';
// import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            searchClient: algoliasearch('YU4IWTKXH8', 'e7ed9d642d6e013e3b7b0e665d81f0f1'),
            showHits: false,
            userRole: localStorage.getItem('authrole'),
            routing: {
                router: history(),
                stateMapping: singleIndex('instant_search'),
            },
        };
    },
    computed: {
        // ...mapGetters(['userRole']),
        accessibleIndices() {
            switch (this.userRole) {
                case 'Admin':
                case 'Internal':
                    return ['orders', 'products', 'price_inquiries', 'supplier_profiles', 'buyer_profiles', 'shipment_orders'];
                case 'Supplier':
                    return ['orders', 'products', 'price_inquiries', 'supplier_profiles', 'shipment_orders'];
                case 'Buyer':
                    return ['orders', 'products', 'price_inquiries', 'buyer_profiles', 'shipment_orders'];
                default:
                    return [];
            }
        },
    },
    methods: {
        handleBlur() {
            setTimeout(() => {
                this.showHits = false;
            }, 200);
        },
        handleOutsideClick(event) {
            if (!this.$el.contains(event.target)) {
                this.showHits = false;
            }
        },
        navigateTo(item, itemType) {
            let routeName;
            let params = { id: item.id };

            // Define route mapping based on role and item type
            if (this.userRole === 'Admin' || this.userRole === 'Internal') {
                switch (itemType) {
                    case 'order':
                        routeName = 'order_edit'; // Ensure this route exists
                        break;
                    case 'product':
                        routeName = 'adminproductEdit';
                        break;
                    case 'price_inquiry':
                        routeName = 'price_inquiry_edit';
                        break;
                    case 'supplier_profile':
                        routeName = 'edituser'; // Adjust as needed
                        break;
                    case 'buyer_profile':
                        routeName = 'editbuyer'; // Adjust as needed
                        break;
                    case 'shipment_order':
                        routeName = 'information'; // Adjust as needed
                        params = { id: item.id, so_number: item.so_number };
                        break;
                    default:
                        routeName = 'home';
                }
            } else if (this.userRole === 'Supplier') {
                switch (itemType) {
                    case 'order':
                        routeName = 'supplier_order_edit';
                        break;
                    case 'product':
                        routeName = 'productEdit'; // Assuming 'productEdit' exists for suppliers
                        break;
                    case 'price_inquiry':
                        routeName = 'supplier_price_inquiry_entry';
                        break;
                    case 'supplier_profile':
                        routeName = 'edituser'; // Adjust as needed
                        break;
                    case 'shipment_order':
                        routeName = 'information'; // Adjust as needed
                        params = { id: item.id, so_number: item.so_number };
                        break;
                    default:
                        routeName = 'home';
                }
            } else if (this.userRole === 'Buyer') {
                switch (itemType) {
                    case 'order':
                        routeName = 'buyer_order_entry';
                        break;
                    case 'product':
                        routeName = 'buyer_productEdit';
                        break;
                    case 'price_inquiry':
                        routeName = 'buyer_price_inquiry_edit';
                        break;
                    case 'buyer_profile':
                        routeName = 'editbuyer'; // Adjust as needed
                        break;
                    case 'shipment_order':
                        routeName = 'buyer_information'; // Adjust as needed
                        params = { id: item.id, so_number: item.so_number };
                        break;
                    default:
                        routeName = 'home';
                }
            } else {
                // Default route or handle unauthorized access
                routeName = 'home';
                params = {};
            }

            // Verify if routeName exists to prevent navigation errors
            if (this.$router.hasRoute(routeName)) {
                this.$router.push({ name: routeName, params });
            } else {
                // Fallback route
                this.$router.push({ name: 'home' });
            }
        },
        isIndexAccessible(index) {
            // Additional logic can be added here if needed
            return this.accessibleIndices.includes(index);
        },
        formatIndexName(index) {
            // Format index names for display purposes
            const mapping = {
                orders: 'Orders',
                products: 'Products',
                price_inquiries: 'Price Inquiry',
                supplier_profiles: 'Supplier',
                buyer_profiles: 'Buyer',
                shipment_orders: 'Shipment Orders',
            };
            return mapping[index] || index;
        },
        determineItemType(index) {
            // Map index names to item types used in navigateTo
            const mapping = {
                orders: 'order',
                products: 'product',
                price_inquiries: 'price_inquiry',
                supplier_profiles: 'supplier_profile',
                buyer_profiles: 'buyer_profile',
                shipment_orders: 'shipment_order',
            };
            return mapping[index] || 'unknown';
        },
        getPrimaryAttribute(index) {
            // Define primary attribute based on index
            const mapping = {
                orders: 'id',
                products: 'article',
                price_inquiries: 'inquiry_number',
                supplier_profiles: 'supplier_id',
                buyer_profiles: 'buyer_id',
                shipment_orders: 'so_number',
            };
            return mapping[index] || 'id';
        },
        getSecondaryAttribute(index) {
            // Define secondary attribute based on index
            const mapping = {
                orders: 'article',
                products: 'description',
                price_inquiries: 'article',
                supplier_profiles: 'status',
                buyer_profiles: 'status',
                shipment_orders: 'destination',
            };
            return mapping[index] || 'description';
        },
    },
};
</script>


<style>
/* Container Styling */
.search-container {
    position: relative;
    max-width: 600px;
    margin: 50px auto;
    font-family: Arial, sans-serif;
}

/* Search Box Styling */
.search-box-wrapper {
    position: relative;
}

.search-input {
    width: 100%;
    padding: 12px 40px 12px 16px;
    border: 2px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.search-input:focus {
    border-color: #007BFF;
    outline: none;
}

/* Clear Button Styling */
.clear-button {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    font-size: 20px;
    color: #888;
    cursor: pointer;
}

.clear-button:hover {
    color: #333;
}

/* Loading Indicator Styling */
.loading-indicator {
    position: absolute;
    right: 40px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 14px;
    color: #007BFF;
}

/* Hits Wrapper Styling */
.hits-wrapper {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #fff;
    border: 2px solid #ccc;
    border-top: none;
    border-radius: 0 0 8px 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 10px;
    z-index: 10;
    max-height: 300px;
    overflow-y: auto;
}

.ais-Hits-item {

    width: 100% !important;
}

/* Hit Item Styling for List View */
.hit-item,
.ais-Hits-list {
    display: block;
    width: 100%;
    padding: 10px 0;
    cursor: pointer;
    transition: background 0.3s;
    border-bottom: 1px solid #ccc;
}

.hit-item:last-child {
    border-bottom: none;
}

.hit-item h2 {
    margin: 0;
    font-size: 16px;
    color: #007BFF;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
}

.hit-item:hover {
    background: #f0f8ff;
}

/* Pagination Styling */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 10px;
}

.pagination .ais-Pagination-item,
.pagination .ais-Pagination-link {

    border-radius: 4px;
    color: #007BFF;
    cursor: pointer;
    transition: background 0.3s, color 0.3s;
}

.input-wrapper {
    position: relative;
}

.pagination .ais-Pagination-item--selected .ais-Pagination-link {
    background: #007BFF;
    color: #fff;
}

.pagination .ais-Pagination-item--disabled .ais-Pagination-link {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Transition Styles */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}

.search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #888;
    pointer-events: none;
    /* Allows clicking on the input without interference */
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}

/* Responsive Styling */
@media (max-width: 768px) {
    .hit-item h2 {
        font-size: 14px;
        max-width: 100%;
    }
}
</style>
