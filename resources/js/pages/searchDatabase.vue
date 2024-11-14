<template>
    <div class="search-container" @click="handleOutsideClick">
        <!-- Search Box -->
        <div class="search-box-wrapper">
            <div class="input-wrapper">
                <i class="fas fa-search search-icon"></i> <!-- Search Icon -->
                <input type="text" v-model="searchQuery" @input="onInput" @focus="showHits = true" @blur="handleBlur"
                    placeholder="Search ..." class="search-input" />
                <button v-if="searchQuery" @click="clear" class="clear-button">
                    &times;
                </button>
                <span v-if="isLoading" class="loading-indicator">Loading...</span>
            </div>
        </div>

        <!-- Search Results -->
        <transition name="fade">
            <div class="hits-wrapper" v-if="showHits && hasResults">
                <template v-for="(data, index) in results" :key="index">
                    <div v-if="isIndexAccessible(index)" class="index-section">
                        <span class="hit-type">{{ formatIndexName(index) }}</span>
                        <div v-if="data.data.length > 0">
                            <div v-for="item in data.data" :key="item.id" class="hit-item"
                                @click="navigateTo(item, determineItemType(index))">
                                <h2>
                                    <span v-if="index === 'orders'">Order No: </span>
                                    <span v-if="index === 'products'">Article: </span>
                                    <span v-if="index === 'price_inquiries'">Inquiry Number: </span>
                                    <span v-if="index === 'supplier_profiles'">Supplier ID: </span>
                                    <span v-if="index === 'buyer_profiles'">Buyer ID: </span>
                                    <span v-if="index === 'shipment_orders'">SO#: </span>
                                    {{ item[getPrimaryAttribute(index)] }}
                                </h2>
                                <p class="hit-description">
                                    {{ item[getSecondaryAttribute(index)] }}
                                </p>
                            </div>
                            <!-- Pagination Controls -->
                            <div class="pagination" v-if="data.last_page > 1">
                                <button :disabled="data.current_page === 1"
                                    @click="changePage(index, data.current_page - 1)" class="pagination-button">
                                    Previous
                                </button>
                                <span>Page {{ data.current_page }} of {{ data.last_page }}</span>
                                <button :disabled="data.current_page === data.last_page"
                                    @click="changePage(index, data.current_page + 1)" class="pagination-button">
                                    Next
                                </button>
                            </div>
                        </div>
                        <div v-else>
                            <p class="no-results">No results found.</p>
                        </div>
                    </div>
                </template>
            </div>
        </transition>
    </div>
</template>

<script>
import axios from 'axios';
import debounce from 'lodash/debounce';

export default {
    data() {
        return {
            searchQuery: '',
            showHits: false,
            isLoading: false,
            results: {}, // Structure: { indexName: { data: [], current_page: 1, last_page: 1, ... }, ... }
            userRole: localStorage.getItem('authrole'), // Assuming the user role is stored in localStorage
            currentPages: {}, // Tracks current page per index
        };
    },
    computed: {
        /**
         * Determines accessible indices based on user role.
         */
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
        /**
         * Checks if there are any search results to display.
         */
        hasResults() {
            return Object.keys(this.results).length > 0;
        },
    },
    methods: {
        /**
         * Debounced input handler to fetch search results.
         */
        onInput: debounce(function () {
            this.resetPages();
            this.fetchResults();
        }, 300),

        /**
         * Fetches search results from the API.
         */
        fetchResults() {
            if (this.searchQuery.trim() === '') {
                this.results = {};
                return;
            }

            this.isLoading = true;

            // Prepare page parameters per index
            const pageParams = {};
            this.accessibleIndices.forEach(index => {
                pageParams[index] = this.currentPages[index] || 1;
            });

            axios
                .get('/api/search', { params: { query: this.searchQuery, page: pageParams } })
                .then(response => {
                    console.log(response);
                    this.results = response.data;
                })
                .catch(error => {
                    console.error('Search error:', error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        /**
         * Clears the search input and results.
         */
        clear() {
            this.searchQuery = '';
            this.results = {};
            this.resetPages();
        },

        /**
         * Handles the blur event to hide search results.
         */
        handleBlur() {
            setTimeout(() => {
                this.showHits = false;
            }, 200);
        },

        /**
         * Detects clicks outside the search component to hide results.
         */
        handleOutsideClick(event) {
            if (!this.$el.contains(event.target)) {
                this.showHits = false;
            }
        },

        /**
         * Navigates to the appropriate route based on item type and user role.
         *
         * @param {Object} item - The search result item.
         * @param {String} itemType - The type of the item (e.g., 'order', 'product').
         */
        navigateTo(item, itemType) {
            let routeName;
            let params = { id: item.id };

            // Define route mapping based on role and item type
            if (this.userRole === 'Admin' || this.userRole === 'Internal') {
                switch (itemType) {
                    case 'order':
                        routeName = 'order_edit';
                        break;
                    case 'product':
                        routeName = 'adminproductEdit';
                        break;
                    case 'price_inquiry':
                        routeName = 'price_inquiry_edit';
                        break;
                    case 'supplier_profile':
                        routeName = 'edituser';
                        break;
                    case 'buyer_profile':
                        routeName = 'editbuyer';
                        break;
                    case 'shipment_order':
                        routeName = 'information';
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
                        routeName = 'productEdit';
                        break;
                    case 'price_inquiry':
                        routeName = 'supplier_price_inquiry_entry';
                        break;
                    case 'supplier_profile':
                        routeName = 'edituser';
                        break;
                    case 'shipment_order':
                        routeName = 'information';
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
                        routeName = 'editbuyer';
                        break;
                    case 'shipment_order':
                        routeName = 'buyer_information';
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

        /**
         * Checks if the given index is accessible based on user role.
         *
         * @param {String} index - The name of the index.
         * @return {Boolean}
         */
        isIndexAccessible(index) {
            return this.accessibleIndices.includes(index);
        },

        /**
         * Formats the index name for display purposes.
         *
         * @param {String} index - The name of the index.
         * @return {String}
         */
        formatIndexName(index) {
            const mapping = {
                orders: 'Orders',
                products: 'Products',
                price_inquiries: 'Price Inquiries',
                supplier_profiles: 'Supplier Profiles',
                buyer_profiles: 'Buyer Profiles',
                shipment_orders: 'Shipment Orders',
            };
            return mapping[index] || index;
        },

        /**
         * Determines the item type based on the index.
         *
         * @param {String} index - The name of the index.
         * @return {String}
         */
        determineItemType(index) {
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

        /**
         * Retrieves the primary attribute for display based on the index.
         *
         * @param {String} index - The name of the index.
         * @return {String}
         */
        getPrimaryAttribute(index) {
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

        /**
         * Retrieves the secondary attribute for display based on the index.
         *
         * @param {String} index - The name of the index.
         * @return {String}
         */
        getSecondaryAttribute(index) {
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

        /**
         * Handles pagination by changing the current page of a specific index.
         *
         * @param {String} index - The name of the index.
         * @param {Number} newPage - The new page number.
         */
        changePage(index, newPage) {
            if (newPage < 1 || newPage > this.results[index].last_page) {
                return;
            }

            // Update current page for the specific index
            this.$set(this.currentPages, index, newPage);

            // Fetch results with updated page parameters
            this.fetchResults();
        },

        /**
         * Resets all current page numbers to 1.
         */
        resetPages() {
            this.currentPages = {};
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
    padding: 12px 40px 12px 33px;
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
    max-height: 400px;
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
    align-items: center;
    margin-top: 10px;
}

.pagination-button {
    background-color: #007BFF;
    color: white;
    border: none;
    padding: 6px 12px;
    margin: 0 5px;
    border-radius: 4px;
    cursor: pointer;
}

.pagination-button:disabled {
    background-color: #cccccc;
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

/* No Results Styling */
.no-results {
    padding: 10px;
    color: #888;
    font-style: italic;
}

/* Responsive Styling */
@media (max-width: 768px) {
    .hit-item h2 {
        font-size: 14px;
        max-width: 100%;
    }
}
</style>
