<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12 ">

                <div class="card  ">
                    <div class="card-header pt-3  ">
                        <div class="d-flex justify-content-between align-items-center mx-3">
                            <span><span class=" mt-2 fw-bold fs-4 " style="color: #14245c;">Products</span> <br>
                                <!-- <span class="">Overview on all Suppliers</span> -->
                            </span>
                            <div class="col-4 d-flex">
                                <div class="col-12">

                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><i style="color: #41b400;"
                                                class="bx bx-filter-alt fw-bold fs-4"></i></span>
                                        <input type="text" name="search" class="form-control " v-model="searchQuery"
                                            ref="search" placeholder="Write here to filter..." />
                                    </div>
                                </div>
                                <!-- <div class="col-6 mx-2">
                                    <router-link :to="{ name: 'productEntry' }"
                                        class="btn btn-warning fw-bold text-dark">Add New
                                        Product</router-link>
                                </div> -->
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
                    <div class="card-body rounded-top" v-else>


                        <!-- Table with stripped rows -->
                        <table class="table table-striped table-hover  display " id="">
                            <thead style="color: white; background-color: #14245c" class="text-center">
                                <tr class="rounded-top-new" style="">
                                    <th>
                                        Article#
                                    </th>
                                    <th>Product Name</th>
                                    <th>Description</th>
                                    <th>Product Group</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="product in dataToDisplay" :key="product.id">
                                    <td>{{ product.article }}</td>
                                    <td>{{ product.name }}</td>
                                    <td>{{ product.description }}</td>
                                    <td>{{ product.product_group?.group_name }}</td>

                                    <td>
                                        <span
                                            :class="{ 'badge': true, 'bg-success-new': product.status === 'active', 'bg-danger': product.status !== 'active' }">
                                            {{ product.status === 'active' ? 'Active' : 'InActive' }}
                                        </span>
                                    </td>

                                    <td>
                                        <!-- <button @click="toggleAccordion(product)" class="btn btn-light"
                                            :class="{ 'rotate-icon': accordionOpen[product.id] }">
                                            <i class="bi bi-pencil"></i>
                                        </button> -->
                                        <router-link :to="{ name: 'buyer_productEdit', params: { id: product.id } }"
                                            class="text-dark">
                                            <i class="bi bi-pencil"></i>
                                        </router-link>

                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination d-flex justify-content-center">
                                <li class="page-item me-auto fw-bold" :class="{ disabled: currentPage === 1 }">
                                    <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)"><i
                                            class="bi bi-arrow-left"></i> Previous</a>
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

            </div>
        </div>
    </section>
</template>

<script>
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';




export default {
    props: {
        perPage: {
            type: Number,
            default: 10
        }
    },
    data() {
        return {
            isLoading: true,
            products: [],
            accordionOpen: {},
            currentPage: 1,
            searchQuery: ''
        };
    },
    watch: {
        data(newVal) {
            this.products = newVal;
        }
    },
    computed: {
        filteredproducts() {
            return this.products.filter(product => {
                return product.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || product.article.toLowerCase().includes(this.searchQuery.toLowerCase());
            });
        },
        totalPages() {
            return Math.ceil(this.products.length / this.perPage)
        },
        paginatedData() {
            const start = (this.currentPage - 1) * this.perPage
            const end = start + this.perPage
            return this.products.slice(start, end)
        },
        dataToDisplay() {
            if (this.searchQuery) {
                return this.filteredproducts;
            } else {
                return this.paginatedData;
            }
        }
    },
    mounted() {

    },
    created() {
        this.fetchproducts().then(() => {
            setTimeout(() => {
                this.isLoading = false;
            }, 1000); // Delay of 1 second
        });
    },
    methods: {
        showToast(type, message) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                icon: type,
                title: message
            });
        },
        toggleAccordion(product) {
            this.accordionOpen[product.id] = !this.accordionOpen[product.id];
        },
        changePage(page) {
            this.currentPage = page
        },
        async updateproduct(id) {
            // const formData = {

            // };

            // Send formData to your API
            // console.log('Form Data:', formData);
            try {
                // const response = await axios.put(`/api/updateproducts/${id}`, [this.updateproduct, formData]);

                if (response.status === 200) {
                    toastr.success('product updated successfully');
                    this.$router.push({ name: 'product' });
                }
            } catch (error) {
                if (error.response.status === 422) {
                    toastr.error('Please fix the validation errors and try again');
                } else {
                    toastr.error('An error occurred while updating the product');
                }
            }
        },
        async fetchproducts() {
            try {
                const response = await axios.get('/api/buyer/products');
                this.products = response.data;
                // this.pagination.totalItems = response.data.total;
                console.log(response.data);

            } catch (error) {
                console.error('Error fetching products:', error);
                toastr.error('Error fetching data');
            }
        },

    },
};
</script>

<style scoped>
.rotate-icon {
    transform: rotate(180deg);
}

.table {
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 20px;

    border-radius: 10px 10px 0 0;
    overflow: hidden;
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



.rounded-top-new {
    border-top-left-radius: 2.25rem !important;
    border-top-right-radius: 2.25rem !important;
}

.rounded-bottom-new {
    border-bottom-left-radius: 2.25rem !important;
    border-bottom-right-radius: 2.25rem !important;
}
</style>
