<template>
    <div class="search-container" @click="handleOutsideClick">
        <ais-instant-search :search-client="searchClient" index-name="orders" class="search-form" :routing="routing">
            <!-- Custom Search Box -->
            <div class="search-box-wrapper">
                <ais-search-box v-slot="{ currentRefinement, refine, clear, isSearchStalled }">
                    <div class="input-wrapper">
                        <i class="fas fa-search search-icon"></i> <!-- Search Icon -->
                        <input type="text" :value="currentRefinement" @input="refine($event.target.value)"
                            @focus="showHits = true" @blur="handleBlur" placeholder="Search for price inquiries..."
                            class="search-input" />
                        <button v-if="currentRefinement" @click="clear" class="clear-button">
                            &times;
                        </button>
                        <span v-if="isSearchStalled" class="loading-indicator">Loading...</span>
                    </div>
                </ais-search-box>
                <!-- <ais-configure  :hitsPerPage="2" /> -->
            </div>

            <!-- Search Results -->
            <transition name="fade">
                <div class="hits-wrapper" v-if="showHits">
                    <!-- <ais-hits>
                        <template v-slot:item="{ item }">
                            <div class="hit-item" @click="navigateTo(item)">
                                <h2>{{ item.name }} {{ item.model_type }}</h2>
                            </div>
                        </template>
</ais-hits> -->
                    <!-- Orders Index -->
                    <ais-index index-name="orders">
                        <span class="hit-type">Orders</span>
                        <ais-hits>
                            <template v-slot:item="{ item }">
                                <div class="hit-item" @click="navigateTo(item, 'order')">
                                    <h2>Order No: <ais-highlight :attribute="'id'" :hit="item" /></h2>
                                    <p class="hit-description">Article: <ais-highlight :attribute="'article'"
                                            :hit="item" /></p>
                                </div>
                            </template>
                        </ais-hits>
                    </ais-index>

                    <!-- Products Index -->
                    <ais-index index-name="products">
                        <span class="hit-type">Products</span>
                        <ais-hits>
                            <template v-slot:item="{ item }">
                                <div class="hit-item" @click="navigateTo(item, 'product')">
                                    <h2>Article: <ais-highlight :attribute="'article'" :hit="item" /></h2>
                                    <p class="hit-description">
                                        <ais-highlight :attribute="'description'" :hit="item" />
                                    </p>
                                </div>
                            </template>
                        </ais-hits>
                    </ais-index>

                    <!-- Price Inquiries Index -->
                    <ais-index index-name="price_inquiries">
                        <span class="hit-type">Price Inquiry</span>
                        <ais-hits>
                            <template v-slot:item="{ item }">
                                <div class="hit-item" @click="navigateTo(item, 'user')">
                                    <h2>Inquiry Number: <ais-highlight :attribute="'inquiry_number'" :hit="item" /></h2>
                                    <p class="hit-description">Article: <ais-highlight :attribute="'article'"
                                            :hit="item" /></p>
                                </div>
                            </template>
                        </ais-hits>
                    </ais-index>
                    <ais-index index-name="supplier_profiles">
                        <span class="hit-type">Supplier</span>
                        <ais-hits>
                            <template v-slot:item="{ item }">
                                <div class="hit-item" @click="navigateTo(item, 'user')">
                                    <h2>Supplier ID: <ais-highlight :attribute="'supplier_id'" :hit="item" /></h2>
                                    <p class="hit-description">Status: <ais-highlight :attribute="'status'"
                                            :hit="item" /></p>
                                </div>
                            </template>
                        </ais-hits>
                    </ais-index>
                    <ais-index index-name="buyer_profiles">
                        <span class="hit-type">Buyer</span>
                        <ais-hits>
                            <template v-slot:item="{ item }">
                                <div class="hit-item" @click="navigateTo(item, 'user')">
                                    <h2>Buyer ID: <ais-highlight :attribute="'buyer_id'" :hit="item" /></h2>
                                    <p class="hit-description">Status: <ais-highlight :attribute="'status'"
                                            :hit="item" /></p>
                                </div>
                            </template>
                        </ais-hits>
                    </ais-index>
                    <ais-index index-name="shipment_orders">
                        <span class="hit-type">Shipment Orders</span>
                        <ais-hits>
                            <template v-slot:item="{ item }">
                                <div class="hit-item" @click="navigateTo(item, 'user')">
                                    <h2>SO# : <ais-highlight :attribute="'so_number'" :hit="item" /></h2>
                                    <p class="hit-description">Destination: <ais-highlight :attribute="'destination'"
                                            :hit="item" /></p>
                                </div>
                            </template>
                        </ais-hits>
                    </ais-index>

                    <!-- <ais-pagination class="pagination" /> -->
                </div>
            </transition>
        </ais-instant-search>
    </div>
</template>

<script>
import { liteClient as algoliasearch } from 'algoliasearch/lite';
import { history } from 'instantsearch.js/es/lib/routers';
import { singleIndex } from 'instantsearch.js/es/lib/stateMappings';
// App.js

// Include only the reset
// import 'instantsearch.css/themes/reset.css';
// // or include the full Satellite theme
// import 'instantsearch.css/themes/satellite.css';


export default {
    data() {
        return {
            searchClient: algoliasearch('YU4IWTKXH8', 'e7ed9d642d6e013e3b7b0e665d81f0f1'),
            showHits: false,
            routing: {
                router: history(),
                stateMapping: singleIndex('instant_search'),
            },
        };
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
        navigateTo(item) {
            this.$router.push({ name: `${item.model_type.toLowerCase()}.show`, params: { id: item.id } });
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
